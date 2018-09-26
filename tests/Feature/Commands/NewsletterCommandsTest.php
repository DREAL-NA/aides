<?php

namespace Tests\Feature\Commands;

use App\NewsletterSubscriber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\IntegrationTestCase;

class NewsletterCommandsTest extends IntegrationTestCase
{
    use RefreshDatabase;

    /** @test */
    function it_imports_subscribers_from_the_api()
    {
        $this->artisan('newsletter:import')
             ->expectsQuestion('You are about to delete all records from the newsletter_subscribers table? Are you sure?', 'Yes')
             ->expectsOutput('Import of subscribers finished!')
             ->assertExitCode(0);

        $this->assertCount(5, NewsletterSubscriber::all());
    }

    /** @test */
    function it_sync_subscribers_with_the_api()
    {
        factory(NewsletterSubscriber::class)->create([
            'email' => 'anastasia06@gmail.com',
            'firstname' => 'Hillary',
            'lastname' => 'Murazik',
        ]);

        factory(NewsletterSubscriber::class)->create([
            'email' => 'nicolas.giraud01+test2@gmail.com',
            'firstname' => 'Allo',
            'lastname' => '',
        ]);

        factory(NewsletterSubscriber::class, 1)->create();

        $this->artisan('newsletter:sync')
             ->expectsOutput('Sync of subscribers finished!')
             ->assertExitCode(0);

        $this->assertCount(7, NewsletterSubscriber::all());
    }
}
