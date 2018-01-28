<?php

use Faker\Generator as Faker;

$factory->define(App\Website::class, function (Faker $faker) {
    return [
        'themes' => $faker->sentence(3),
        'name' => $faker->sentence(4),
        'perimeter_comments' => $faker->sentence(4),
        'website_url' => $faker->url,
        'organization_type_id' => function () {
            return factory(App\OrganizationType::class)->create()->id;
        },
        'description' => $faker->paragraph
    ];
});
