<?php

namespace Tests\Feature\Commands;

use App\NewsletterSubscriber;
use Tests\IntegrationTestCase;

class NewsletterSyncCommandTest extends IntegrationTestCase
{
    /** @test */
    function it_add_new_members_to_the_api()
    {
        // member not in mailchimp api
        factory(NewsletterSubscriber::class)->create([
            'email' => 'anastasia06@gmail.com',
            'firstname' => 'Hillary',
            'lastname' => 'Murazik',
            'subscribed_at' => null
        ]);

        $this->artisan('newsletter:sync')
             ->expectsOutput("1 added to API.")
             ->expectsOutput('Sync of subscribers finished!')
             ->assertExitCode(0);
    }

    /** @test */
    function it_updates_statuses_from_existing_members_from_the_api()
    {
        // member in mailchimp api
        $memberA = factory(NewsletterSubscriber::class)->create([
            'email' => 'nicolas.giraud01+test2@gmail.com',
            'firstname' => 'Allo',
            'lastname' => '',
            'subscribed_at' => null,
        ]);

        // member in mailchimp api
        $memberB = factory(NewsletterSubscriber::class)->create([
            'email' => 'contact@ngiraud.me',
            'firstname' => 'Allo',
            'lastname' => '',
            'subscribed_at' => null,
        ]);

        $this->artisan('newsletter:sync')
             ->expectsOutput("2 statuses updated from the API.")
             ->expectsOutput('Sync of subscribers finished!')
             ->assertExitCode(0);

        $memberA = $memberA->fresh();
        $memberB = $memberB->fresh();

        $this->assertNotNull($memberA->subscribed_at);
        $this->assertNotNull($memberB->subscribed_at);

        $this->assertCount(5, NewsletterSubscriber::all());
    }

    /** @test */
    function it_add_new_members_to_the_db()
    {
        $this->artisan('newsletter:sync')
             ->expectsOutput("5 added to the DB.")
             ->expectsOutput('Sync of subscribers finished!')
             ->assertExitCode(0);

        $this->assertDatabaseHas('newsletter_subscribers', [
            'email' => [
                'Sylvie.Frugier@developpement-durable.gouv.fr',
                'nicolas.giraud01+test1@gmail.com',
                'nicolas.giraud01+test4@gmail.com'
            ]
        ]);

        $this->assertCount(5, NewsletterSubscriber::all());
    }
}
