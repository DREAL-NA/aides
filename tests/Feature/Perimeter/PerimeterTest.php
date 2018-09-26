<?php

namespace Tests\Feature\Perimeter;

use App\Perimeter;
use Tests\IntegrationTestCase;

class PerimeterTest extends IntegrationTestCase
{
    protected $tableAssoc = 'perimeters_parents';

    /** @test */
    function it_saves_parents_on_creation()
    {
        $parents = factory(Perimeter::class, 2)->create();

        $data = ['name' => 'My perimeter', 'parents' => $parents->pluck('id')->toArray(), 'description' => null];

        $response = $this->postJson(route('bko.perimetre.store'), $data);

        $perimeter = Perimeter::whereName('My perimeter')->first();

        $response->assertStatus(201);

        $this->assertNotNull($perimeter);
        $this->assertDatabaseHas($this->tableAssoc, ['child_id' => $perimeter->id, 'parent_id' => $parents->first()->id]);
        $this->assertDatabaseHas($this->tableAssoc, ['child_id' => $perimeter->id, 'parent_id' => $parents->last()->id]);
    }

    /** @test */
    function it_saves_parents_on_update()
    {
        $parents = factory(Perimeter::class, 2)->create();

        $perimeter = factory(Perimeter::class)->create();

        $data = ['name' => 'My perimeter', 'parents' => $parents->pluck('id')->toArray(), 'description' => null];

        $response = $this->putJson(route('bko.perimetre.update', $perimeter), $data);

        $perimeter = $perimeter->fresh();

        $response->assertStatus(201);

        $this->assertEquals('My perimeter', $perimeter->name);
        $this->assertDatabaseHas($this->tableAssoc, ['child_id' => $perimeter->id, 'parent_id' => $parents->first()->id]);
        $this->assertDatabaseHas($this->tableAssoc, ['child_id' => $perimeter->id, 'parent_id' => $parents->last()->id]);
    }
}
