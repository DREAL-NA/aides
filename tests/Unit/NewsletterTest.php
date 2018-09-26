<?php

namespace Tests\Unit;

use App\NewsletterSubscriber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsletterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_has_an_email()
    {
        $subscriber = factory(NewsletterSubscriber::class)->create(['email' => 'john@example.com']);

        $this->assertEquals('john@example.com', $subscriber->email);
        $this->assertDatabaseHas('newsletter_subscribers', ['email' => 'john@example.com']);
    }

    /** @test */
    function it_has_a_firstname()
    {
        $subscriber = factory(NewsletterSubscriber::class)->create(['firstname' => 'John']);

        $this->assertEquals('John', $subscriber->firstname);
        $this->assertDatabaseHas('newsletter_subscribers', ['firstname' => 'John']);
    }

    /** @test */
    function it_has_a_lastname()
    {
        $subscriber = factory(NewsletterSubscriber::class)->create(['lastname' => 'Doe']);

        $this->assertEquals('Doe', $subscriber->lastname);
        $this->assertDatabaseHas('newsletter_subscribers', ['lastname' => 'Doe']);
    }

    /** @test */
    function firstname_can_be_null()
    {
        $subscriber = factory(NewsletterSubscriber::class)->create(['firstname' => null]);

        $this->assertEquals(null, $subscriber->firstname);
        $this->assertDatabaseHas('newsletter_subscribers', ['id' => $subscriber->id]);
    }

    /** @test */
    function lastname_can_be_null()
    {
        $subscriber = factory(NewsletterSubscriber::class)->create(['lastname' => null]);

        $this->assertEquals(null, $subscriber->lastname);
        $this->assertDatabaseHas('newsletter_subscribers', ['id' => $subscriber->id]);
    }

    /** @test */
    function it_has_a_subscribed_date()
    {
        $subscriber = factory(NewsletterSubscriber::class)->create(['subscribed_at' => '2018-09-15 00:00:00']);

        $this->assertEquals('2018-09-15 00:00:00', $subscriber->subscribed_at);
        $this->assertDatabaseHas('newsletter_subscribers', ['subscribed_at' => '2018-09-15 00:00:00']);
    }
}
