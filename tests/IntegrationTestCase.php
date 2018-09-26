<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Newsletter;

class IntegrationTestCase extends TestCase
{
    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();

        $this->signIn();

        $this->app->bind('newsletter', function () {
            return new FakeMailchimpGateway();
        });
    }

    public function tearDown()
    {
        parent::tearDown();

        if ($container = Mockery::getContainer()) {
            $this->addToAssertionCount($container->mockery_getExpectationCount());
        }

        Mockery::close();
    }
}