<?php

use Faker\Generator as Faker;

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('password'),
        'remember_token' => str_random(10),
    ];
});

$factory->state(App\User::class, 'custom', [
    'name' => 'Nico',
    'email' => 'contact@ngiraud.me',
]);

//$factory->define(App\OrganizationType::class, function (Faker $faker) {
//    return [
//        'name' => $faker->unique()->company,
//    ];
//});

$factory->define(App\Perimeter::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->city,
    ];
});

$factory->define(App\ProjectHolder::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->company,
    ];
});

$factory->define(App\Thematic::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word,
        'parent_id' => null
    ];
});

//$factory->state(App\Thematic::class, 'subthematic', [
//    'parent_id' => App\Thematic::inRandomOrder()->first()->id
//]);

$factory->define(App\Beneficiary::class, function (Faker $faker) {
    return [
        'type' => $faker->randomKey(\App\Beneficiary::types()->toArray(), 1),
        'name' => $faker->unique()->company,
    ];
});

$factory->define(App\CallForProjects::class, function (Faker $faker) {
    return [
        'thematic_id' => App\Thematic::primary()->inRandomOrder()->first()->id,
        'subthematic_id' => null,
        'name' => $faker->unique()->company,
        'closing_date' => $faker->dateTimeThisDecade()->format('Y-m-d H:i:s'),
        'project_holder_contact' => $faker->paragraph,
        'objectives' => $faker->paragraph,
        'beneficiary_comments' => $faker->paragraph,
        'allocation_global' => $faker->numberBetween(0, 1),
        'allocation_per_project' => $faker->numberBetween(0, 1),
        'allocation_amount' => '1000 €',
        'website_url' => $faker->url,
        'editor_id' => App\User::inRandomOrder()->first()->id
    ];
});


$factory->define(App\Website::class, function (Faker $faker) {
    return [
        'themes' => $faker->sentence(3),
        'name' => $faker->sentence(4),
        'perimeter_comments' => $faker->sentence(4),
        'website_url' => $faker->url,
//        'organization_type_id' => function () {
//            return factory(App\OrganizationType::class)->create()->id;
//        },
        'description' => $faker->paragraph
    ];
});