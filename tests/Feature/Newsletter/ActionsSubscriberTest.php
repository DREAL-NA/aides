<?php

namespace Tests\Feature\Newsletter;

use App\NewsletterSubscriber;
use Tests\IntegrationTestCase;

class ActionsSubscriberTest extends IntegrationTestCase
{
    protected $table = 'newsletter_subscribers';
    protected $subscribed_member;
    protected $unsubscribed_member;

    protected function setUp()
    {
        parent::setUp();

        $this->subscribed_member = factory(NewsletterSubscriber::class)->create();
        $this->unsubscribed_member = factory(NewsletterSubscriber::class)->create(['subscribed_at' => null]);
    }

    /** @test */
    function a_subscriber_can_be_unsubscribed()
    {
        $response = $this->postJson(route('bko.subscriber.unsubscribe', $this->subscribed_member));

        $response->assertStatus(200);

        $this->subscribed_member = $this->subscribed_member->fresh();

        $this->assertNull($this->subscribed_member->subscribed_at);
        $this->assertEquals('unsubscribed', $this->subscribed_member->status);

        $this->assertDatabaseHas($this->table, ['email' => $this->subscribed_member->email, 'subscribed_at' => null]);
    }

    /** @test */
    function a_subscriber_can_be_subscribed_through_bko()
    {
        $response = $this->postJson(route('bko.subscriber.subscribe', $this->unsubscribed_member));

        $response->assertStatus(200);

        $this->unsubscribed_member = $this->unsubscribed_member->fresh();

        $this->assertNotNull($this->unsubscribed_member->subscribed_at);
        $this->assertEquals('subscribed', $this->unsubscribed_member->status);

        $this->assertDatabaseHas($this->table, ['email' => $this->unsubscribed_member->email, 'subscribed_at' => $this->unsubscribed_member->subscribed_at]);
    }
}
