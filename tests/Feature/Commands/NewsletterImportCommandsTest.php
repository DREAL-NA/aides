<?php

namespace Tests\Feature\Commands;

use App\NewsletterSubscriber;
use Tests\IntegrationTestCase;

class NewsletterImportCommandsTest extends IntegrationTestCase
{
    /** @test */
    function it_imports_subscribers_from_the_api()
    {
        $this->artisan('newsletter:import')
             ->expectsQuestion('You are about to delete all records from the newsletter_subscribers table? Are you sure?', 'Yes')
             ->expectsOutput('Import of subscribers finished!')
             ->assertExitCode(0);

        $this->assertCount(5, NewsletterSubscriber::all());
    }
}
