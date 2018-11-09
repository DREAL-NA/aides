<?php

namespace App\Newsletter\Commands;

use App\NewsletterSubscriber;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Newsletter;

class ImportSubscribers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newsletter:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command imports subscribers from the Mailchimp API.';

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
        $this->line('Starting import of subscribers!');

        if (!$this->confirm('You are about to delete all records from the newsletter_subscribers table? Are you sure?')) {
            return false;
        }

        $this->line('First, we clean the DB');
        DB::table('newsletter_subscribers')->delete();

        $hasMembers = true;
        $offset = 0;
        $total = 0;
        $page = 0;

        while ($hasMembers === true) {
            $members = Newsletter::getMembers('', ['offset' => $offset]);

            $this->line("\r\nGetting members on page {$page}");

            if (empty($members['members'])) {
                $this->warn('No subscriber for this page!');

                $hasMembers = false;
                break;
            }

            $bar = $this->output->createProgressBar(count($members['members']));

            foreach ($members['members'] as $member) {
                NewsletterSubscriber::firstOrCreate(['email' => $member['email_address']], [
                    'email' => $member['email_address'],
                    'firstname' => $member['merge_fields']['FNAME'] ?? null,
                    'lastname' => $member['merge_fields']['LNAME'] ?? null,
                    'subscribed_at' => $member['status'] === 'subscribed' ? now() : null,
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

        $this->line("\r\n{$total} subscribers have been imported!");

        $this->line('Import of subscribers finished!');

        if (!empty(config('logging.channels.slack.url'))) {
            Log::channel('slack')->info('Import of the Mailchimp API finished!');
        }
    }
}
