<?php

namespace Tests\Unit;

use App\Perimeter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PerimeterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_has_parents()
    {
        $parents = factory(Perimeter::class, 2)->create();

        $perimeter = factory(Perimeter::class)->create();

        $perimeter->each(function ($p) use ($parents) {
            $p->parents()->sync($parents->pluck('id'));
        });

        $this->assertInstanceOf(Perimeter::class, $perimeter->parents->first());
        $this->assertInstanceOf(Perimeter::class, $perimeter->parents->last());
        $this->assertEquals($parents->pluck('id'), $perimeter->parents->pluck('id'));
    }
}
