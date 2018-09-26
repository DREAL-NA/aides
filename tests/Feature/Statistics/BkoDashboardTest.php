<?php

namespace Tests\Feature\Statistics;

//use App\CallForProjects;
use App\Beneficiary;
use App\NewsletterSubscriber;
use App\Perimeter;
use App\ProjectHolder;
use App\Thematic;
use App\Website;
use Tests\IntegrationTestCase;

class BkoDashboardTest extends IntegrationTestCase
{
    /** @test */
    function it_get_last_calls_for_projects()
    {
        $lastCallsForProjects__7days = factory(\App\CallForProjects::class, 5)->create([
            'created_at' => now()->subDays(rand(0, 6)),
            'updated_at' => now()->subDays(rand(0, 6))
        ]);

        $lastCallsForProjects__1month = factory(\App\CallForProjects::class, 10)->create([
            'created_at' => now()->subDays(rand(8, 25)),
            'updated_at' => now()->subDays(rand(8, 25))
        ]);

        $lastCallsForProjects__6months = factory(\App\CallForProjects::class, 50)->create([
            'created_at' => now()->subDays(rand(40, 100)),
            'updated_at' => now()->subDays(rand(40, 100))
        ]);

        $response = $this->get(route('bko.home'));

        $response->assertStatus(200);

        $response->assertViewHas('countLastCallsForProjects__7days', 5);
        $response->assertViewHas('countLastCallsForProjects__1month', 15);
        $response->assertViewHas('countLastCallsForProjects__6months', 65);
    }

    /** @test */
    function it_get_counts_of_beneficiaries()
    {
        factory(Beneficiary::class, 5)->create();

        $response = $this->get(route('bko.home'));

        $response->assertStatus(200);

        $response->assertViewHas('countBeneficiaries', 5);
    }

    /** @test */
    function it_get_counts_of_perimeters()
    {
        factory(Perimeter::class, 10)->create();

        $response = $this->get(route('bko.home'));

        $response->assertStatus(200);

        $response->assertViewHas('countPerimeters', 10);
    }

    /** @test */
    function it_get_counts_of_thematics()
    {
        factory(Thematic::class, 15)->create();

        $response = $this->get(route('bko.home'));

        $response->assertStatus(200);

        $response->assertViewHas('countThematics', 15);
    }

    /** @test */
    function it_get_counts_of_subthematics()
    {
        factory(Thematic::class, 20)->states('subthematic')->create();

        $response = $this->get(route('bko.home'));

        $response->assertStatus(200);

        $response->assertViewHas('countSubthematics', 20);
    }

    /** @test */
    function it_get_counts_of_project_holders()
    {
        factory(ProjectHolder::class, 25)->create();

        $response = $this->get(route('bko.home'));

        $response->assertStatus(200);

        $response->assertViewHas('countProjectHolders', 25);
    }

    /** @test */
    function it_get_counts_of_websites()
    {
        factory(Website::class, 5)->create();

        $response = $this->get(route('bko.home'));

        $response->assertStatus(200);

        $response->assertViewHas('countWebsites', 5);
    }

    /** @test */
    function it_get_counts_of_newsletter_subscribers_subscribed()
    {
        factory(NewsletterSubscriber::class, 5)->create();
        factory(NewsletterSubscriber::class, 5)->states('unsubscribed')->create();

        $response = $this->get(route('bko.home'));

        $response->assertStatus(200);

        $response->assertViewHas('countNewsletterSubscribers__subscribed', 5);
    }

    /** @test */
    function it_get_counts_of_newsletter_subscribers_unsubscribed()
    {
        factory(NewsletterSubscriber::class, 5)->create();
        factory(NewsletterSubscriber::class, 5)->states('unsubscribed')->create();

        $response = $this->get(route('bko.home'));

        $response->assertStatus(200);

        $response->assertViewHas('countNewsletterSubscribers__unsubscribed', 5);
    }
}
