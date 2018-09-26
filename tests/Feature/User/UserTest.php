<?php

namespace Tests\Feature\User;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CallForProjectsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();

        $this->signIn();
    }

    /** @test */
    function an_admin_can_create_a_user()
    {
        $user = factory(User::class)->make();

        $response = $this->postJson(route('bko.utilisateur.store'), $user->toArray());

        $response->assertStatus(201);
    }
}
