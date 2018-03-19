<?php

namespace Tests\Feature;

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
        $user = make(User::class);

        $this->postJson(route('bko.utilisateur.store'), $user->toArray())
            ->assertStatus(201);
    }
}
