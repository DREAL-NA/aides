<?php

namespace Tests\Feature\Newsletter;

use App\NewsletterSubscriber;
use Tests\IntegrationTestCase;

class IndexSubscriberTest extends IntegrationTestCase
{
    protected $table = 'newsletter_subscribers';

    protected function route()
    {
        return route('bko.subscriber.index');
    }

    /** @test */
    function it_returns_a_list_of_subscribers()
    {
        $subscribers = factory(NewsletterSubscriber::class, 10)->create();

        $response = $this->getJson($this->route());

        $response->assertStatus(200);

        $response->assertViewHas('subscribers', NewsletterSubscriber::all());

        $this->assertDatabaseHas($this->table, ['email' => $subscribers->pluck('email')]);
    }
}
