<?php

use Illuminate\Database\Seeder;

class CallForProjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        create(App\CallForProjects::class)->each(function ($call) {
            $call->perimeters()->sync(create(App\Perimeter::class, [], 2));
            $call->beneficiaries()->sync(create(App\Beneficiary::class, [], 2));
            $call->projectHolders()->sync(create(App\ProjectHolder::class, [], 2));
        });
    }
}
