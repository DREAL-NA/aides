<?php

namespace App\Newsletter\Commands;

use App\NewsletterSubscriber;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Newsletter;

class SynchronizeSubscribers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newsletter:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command synchronize subscribers with the Mailchimp API.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line('Starting sync of subscribers!');

        $hasMembers = true;
        $offset = 0;
        $total = 0;
        $page = 0;

        $mailchimpMembers = new Collection();

        // Retrieving members from the API
        while ($hasMembers === true) {
            $members = Newsletter::getMembers('', ['offset' => $offset]);

            $this->line("\r\nRetrieving members on page {$page}");

            if (empty($members['members'])) {
                $this->warn('No subscriber for this page!');

                $hasMembers = false;
                break;
            }

            $bar = $this->output->createProgressBar(count($members['members']));

            foreach ($members['members'] as $member) {
                $mailchimpMembers->push((object)[
                    'email' => $member['email_address'],
                    'firstname' => $member['merge_fields']['FNAME'] ?? null,
                    'lastname' => $member['merge_fields']['LNAME'] ?? null,
                    'subscribed_at' => $member['status'] === 'subscribed' ? now()->format('Y-m-d H:i:s') : null,
                ]);

                $bar->advance();
                $total++;
            }

            $bar->finish();

            $offset += 10;
            $page++;

            if (app()->environment() === 'testing') {
                break;
            }
        }

        $this->line("\r\n{$total} subscribers have been retrieved from the API!");

        // Get all actual members in the DB
        $dbMembers = NewsletterSubscriber::all(['email', 'firstname', 'lastname', 'subscribed_at']);

        // Diff to compare the dbMembers and the mailchimpMembers
        $membersForAPI = $dbMembers;

        if (!$dbMembers->isEmpty() && !$mailchimpMembers->isEmpty()) {
            $membersForAPI = $this->formatForDiff($dbMembers)->diff($this->formatForDiff($mailchimpMembers));
        }

        // For each db member, update its infos on API
        $membersForAPI->each(function ($item) use ($dbMembers) {
            $this->subscribe($member = $dbMembers->firstWhere('email', $item['email']));

            if (!$member->isSubscribed()) {
                $this->unsubscribe($member);
            }
        });

        // Check if we need to update the status of db members
        // Check if we need to create a new account on db because new on
        $incStatuses = 0;
        $incNewOnDb = 0;

        // Get the intersection between api members and db members
        $mailchimpMembers->each(function ($member) use ($dbMembers, &$incStatuses, &$incNewOnDb) {
            if (is_null($dbMember = $dbMembers->firstWhere('email', $member->email))) {
                // The member does not exist in DB => create him
                NewsletterSubscriber::create((array)$member);
                $incNewOnDb++;

                return true;
            }

            // Statuses between API and DB are the same => no need to update
            if (
                ($this->apiMemberIsSubscribe($member) && $dbMember->isSubscribed())
                || (!$this->apiMemberIsSubscribe($member) && !$dbMember->isSubscribed())
            ) {
                return true;
            }

            // Update status

            // With that, tests dont work ---> weiiiird
//            $dbMember->subscribed_at = $member->subscribed_at;
//            $dbMember->save();

            NewsletterSubscriber::whereEmail($dbMember->email)->update(['subscribed_at' => $member->subscribed_at]);

            $incStatuses++;
        });

        $this->line("{$membersForAPI->count()} added to API.");
        $this->line("{$incStatuses} statuses updated from the API.");
        $this->line("{$incNewOnDb} added to the DB.");

        $this->line("\r\n");
        $this->line('Sync of subscribers finished!');

//        if (!empty(config('logging.channels.slack.url'))) {
//            Log::channel('slack')->info('Synchronization of the Mailchimp API finished!');
//        }
    }

    private function formatForDiff($items)
    {
        return $items->map(function ($item) {
            return collect([
                'email' => $item->email,
//                'firstname' => $item->firstname,
//                'lastname' => $item->lastname,
            ]);
        });
    }

    private function subscribe($member)
    {
        $mergeFields = ['FNAME' => '', 'LNAME' => ''];
        if (!empty($member->firstname)) {
            $mergeFields['FNAME'] = $member->firstname;
        }
        if (!empty($member->lastname)) {
            $mergeFields['LNAME'] = $member->lastname;
        }

        // Adding or subscribe user to the Mailchimp list
        Newsletter::subscribeOrUpdate($member->email, $mergeFields);

        $this->warnIfFailure();
    }

    private function unsubscribe($member)
    {
        Newsletter::unsubscribe($member->email);

        $this->warnIfFailure();
    }

    private function warnIfFailure()
    {
        if (Newsletter::lastActionSucceeded() === false) {
            // Unable to subscribe the user
            // Ex error : "400: john@example.com was permanently deleted and cannot be re-imported. The contact must re-subscribe to get back on the list."

            $this->warn(Newsletter::getLastError());
        }
    }

    private function apiMemberIsSubscribe($member)
    {
        return !is_null($member->subscribed_at);
    }
}
