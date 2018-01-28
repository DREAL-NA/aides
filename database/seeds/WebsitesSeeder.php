<?php

use Illuminate\Database\Seeder;

class WebsitesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Website::class, 30)->create()->each(function ($w) {
            $w->perimeters()->sync(\App\Perimeter::inRandomOrder()->get()->take(2));
        });
    }
}
