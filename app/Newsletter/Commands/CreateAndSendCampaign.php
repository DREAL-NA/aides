<?php

namespace App\Newsletter\Commands;

use App\CallForProjects;
use App\Newsletter\Notifications\CampaignCreatedAndSent;
use App\User;
use Illuminate\Console\Command;
use Newsletter;

class CreateAndSendCampaign extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newsletter:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command creates and send a new Mailchimp campaign.';

    protected $api;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->api = Newsletter::getApi();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line('Creating campaign.');

        $from = config('newsletter.from.email');
        $fromName = config('newsletter.from.name');
        $subject = 'Des dispositifs pour les territoires de la Nouvelle Aquitaine (Site pilote) - Actualités de la semaine ' . date('W');

        $news = $this->getNews();

        if ($news->isEmpty()) {
            $this->warn('No news to send through a newsletter.');

            return false;
        }

        $campaign = Newsletter::createCampaign($fromName, $from, $subject, $this->renderEmailTemplate($news));

        if (Newsletter::lastActionSucceeded() === false || empty($campaign['id'])) {
            $this->warn('Unable to create campaign. Aborting.');

            // Ex error : "400: john@example.com was permanently deleted and cannot be re-imported. The contact must re-subscribe to get back on the list."
            if ($error = Newsletter::getLastError()) {
                $this->warn($error);
            }

            return false;
        }

        $this->line('Sending newly created campaign.');

        Newsletter::send($campaign['id']);
//        $this->api->post("campaigns/{$campaign['id']}/actions/send");

        if (Newsletter::lastActionSucceeded() === false) {
            $this->warn('Unable to send campaign. Aborting.');

            $this->warn(Newsletter::getLastError());

            $this->info('Deleting previously created campaign.');
            $this->api->delete("campaigns/{$campaign['id']}");

            return false;
        }

        // Notify admin user the campaign has been created and sent
        $admin = User::whereEmail(config('newsletter.from.email'))->first();

        if (is_null($admin)) {
            \Log::error('Command : CreateAndSendCampaign - Unable to find the admin user ' . config('newsletter.from.email'));
        } else {
            \Log::info('passe');
            $admin->notify(new CampaignCreatedAndSent($news));
        }

        $this->line('Campaign sent!');
    }

    private function getNews()
    {
        return CallForProjects::with([
            'thematic',
            'subthematic',
            'projectHolders',
            'perimeters',
            'beneficiaries'
        ])->ofTheWeek()->orderBy('updated_at', 'desc')->get();
    }

    private function renderEmailTemplate($news)
    {
        return view('emails.mailchimp.new-calls-for-projects', ['callsOfTheWeek' => $news])->render();
    }
}
