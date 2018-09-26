<?php

namespace Tests\Feature\Newsletter;

use App\NewsletterSubscriber;
use Tests\IntegrationTestCase;

class UpdateSubscriberTest extends IntegrationTestCase
{
    protected $table = 'newsletter_subscribers';
    protected $subscriber;

    protected function setUp()
    {
        parent::setUp();

        $this->subscriber = factory(NewsletterSubscriber::class)->create([
            'email' => 'john@example.com',
            'firstname' => 'John',
            'lastname' => 'Doe',
        ]);
    }

    protected function route()
    {
        return route('bko.subscriber.update', $this->subscriber);
    }

    /** @test */
    function it_can_update_a_subscriber()
    {
        $this->subscriber->firstname = 'Jane';

        $response = $this->putJson($this->route(), $this->subscriber->toArray());

        $response->assertStatus(201);

        $this->assertDatabaseHas($this->table, ['email' => $this->subscriber->email, 'firstname' => 'Jane']);
    }

    /** @test */
    function firstname_has_a_max_length_of_255()
    {
        $this->subscriber->firstname = str_random(300);

        $response = $this->putJson($this->route(), $this->subscriber->toArray());

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('firstname');

        $this->assertDatabaseMissing($this->table, ['email' => $this->subscriber->email, 'firstname' => $this->subscriber->firstname]);
    }

    /** @test */
    function lastname_has_a_max_length_of_255()
    {
        $this->subscriber->lastname = str_random(300);

        $response = $this->putJson($this->route(), $this->subscriber->toArray());

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('lastname');

        $this->assertDatabaseMissing($this->table, ['email' => $this->subscriber->email, 'lastname' => $this->subscriber->lastname]);
    }
}
