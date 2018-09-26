<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Newsletter;

class TestMailchimpEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:mailchimp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        dd(Newsletter::getMembers());

        $api = Newsletter::getApi();

        dd($api);

        $callsOfTheWeek = CallForProjects::with([
            'thematic',
            'subthematic',
            'projectHolders',
            'perimeters',
            'beneficiaries'
        ])->ofTheWeek()->orderBy('updated_at', 'desc')->get();

        $html = view('emails.mailchimp.new-calls-for-projects', ['callsOfTheWeek' => $callsOfTheWeek])->render();


        $campaign = Newsletter::createCampaign(
            'Nico',
            'contact@ngiraud.me',
            'This is a test (' . date('Y-m-d H:i:s') . ')',
            $html
        );

        $response = $api->post("campaigns/{$campaign['id']}/actions/send");

        dd($response);

        $this->info('Done!');
    }
}
