<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp()
    {
        parent::setUp();
    }

    protected function signIn($user = null)
    {
        $user = $user ?: create(User::class, [
            'id' => 1,
            'name' => 'test',
            'email' => 'test@dreal.loc',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user);

        return $this;
    }
}
