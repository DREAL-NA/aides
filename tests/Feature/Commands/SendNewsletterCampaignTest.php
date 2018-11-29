<?php

namespace Tests\Feature\Commands;

use App\CallForProjects;
use App\Newsletter\Notifications\CampaignCreatedAndSent;
use App\NewsletterSubscriber;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\IntegrationTestCase;

class SendNewsletterCampaignTest extends IntegrationTestCase
{
    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();
    }

    /** @test */
    function it_does_not_creates_and_sends_a_campaign_beacause_there_is_no_news()
    {
        $this->artisan('newsletter:send')
             ->expectsOutput('No news to send through a newsletter.')
             ->assertExitCode(0);
    }

    /** @test */
    function it_sends_an_email_to_the_admin_when_campaign_was_sent()
    {
        Notification::fake();

        $admin = factory(User::class)->create(['email' => env('MAIL_TEST_ADDRESS')]);

        factory(NewsletterSubscriber::class, 2)->create();
        $news = factory(CallForProjects::class, 5)->states('news')->create();

        $this->artisan('newsletter:send')
             ->expectsOutput('Campaign sent!')
             ->assertExitCode(0);

        Notification::assertSentTo(
            $admin,
            CampaignCreatedAndSent::class,
            function ($notification, $channels) use ($news) {
                return $notification->news->pluck('id')->diff($news->pluck('id'))->isEmpty();
            }
        );
    }
}
