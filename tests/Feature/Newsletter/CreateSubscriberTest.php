<?php

namespace Tests\Feature\Newsletter;

use App\NewsletterSubscriber;
use Tests\IntegrationTestCase;

class CreateSubscriberTest extends IntegrationTestCase
{
    protected $table = 'newsletter_subscribers';

    protected function route()
    {
        return route('bko.subscriber.store');
    }

    /** @test */
    function it_can_create_a_subscriber()
    {
        $subscriber = factory(NewsletterSubscriber::class)->make();

        $response = $this->postJson($this->route(), $subscriber->toArray());

        $response->assertStatus(201);

        $this->assertDatabaseHas($this->table, ['email' => $subscriber->email]);
    }

    /** @test */
    function email_is_required()
    {
        $subscriber = factory(NewsletterSubscriber::class)->make(['email' => null]);

        $response = $this->postJson($this->route(), $subscriber->toArray());

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');

        $this->assertDatabaseMissing($this->table, ['email' => $subscriber->email]);
    }

    /** @test */
    function email_is_unique()
    {
        factory(NewsletterSubscriber::class)->create(['email' => 'john@example.com']);
        $subscriberB = factory(NewsletterSubscriber::class)->make(['email' => 'john@example.com']);

        $response = $this->postJson($this->route(), $subscriberB->toArray());

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');

        $this->assertCount(1, NewsletterSubscriber::whereEmail('john@example.com')->get());
    }

    /** @test */
    function email_is_valid()
    {
        $subscriber = factory(NewsletterSubscriber::class)->make(['email' => 'not-an-email']);

        $response = $this->postJson($this->route(), $subscriber->toArray());

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');

        $this->assertDatabaseMissing($this->table, ['email' => $subscriber->email]);
    }

    /** @test */
    function firstname_has_a_max_length_of_255()
    {
        $subscriber = factory(NewsletterSubscriber::class)->make(['firstname' => str_random(300)]);

        $response = $this->postJson($this->route(), $subscriber->toArray());

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('firstname');

        $this->assertDatabaseMissing($this->table, ['email' => $subscriber->email]);
    }

    /** @test */
    function lastname_has_a_max_length_of_255()
    {
        $subscriber = factory(NewsletterSubscriber::class)->make(['lastname' => str_random(300)]);

        $response = $this->postJson($this->route(), $subscriber->toArray());

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('lastname');

        $this->assertDatabaseMissing($this->table, ['email' => $subscriber->email]);
    }
}
