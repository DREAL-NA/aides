<?php

use Faker\Generator as Faker;

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => \Illuminate\Support\Facades\Hash::make('password'),
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

$factory->state(App\Thematic::class, 'subthematic', [
    'parent_id' => function () {
        return factory(\App\Thematic::class)->create();
    },
]);

$factory->define(App\Beneficiary::class, function (Faker $faker) {
    return [
        'type' => $faker->randomKey(\App\Beneficiary::types()->toArray(), 1),
        'name' => $faker->unique()->company,
    ];
});

$factory->define(App\CallForProjects::class, function (Faker $faker) {
    return [
//        'thematic_id' => App\Thematic::primary()->inRandomOrder()->first()->id,
        'thematic_id' => function () {
            return factory(\App\Thematic::class)->create()->id;
        },
        'subthematic_id' => null,
        'name' => $faker->unique()->company,
        'slug' => $faker->unique()->slug,
        'closing_date' => $faker->dateTimeThisDecade()->format('Y-m-d H:i:s'),
        'project_holder_contact' => $faker->paragraph,
        'objectives' => $faker->paragraph,
        'beneficiary_comments' => $faker->paragraph,
        'allocation_global' => $faker->numberBetween(0, 1),
        'allocation_per_project' => $faker->numberBetween(0, 1),
        'allocation_amount' => '1000 €',
        'website_url' => $faker->url,
        'editor_id' => App\User::inRandomOrder()->first()->id,
        'is_news' => rand(0, 1)
    ];
});

$factory->state(App\CallForProjects::class, 'news', [
    'closing_date' => now()->addDays(rand(1, 180)),
    'is_news' => 1,
]);

$factory->state(App\CallForProjects::class, 'older-news', [
    'is_news' => 1,
    'created_at' => $date = now()->subDays(rand(10, 50)),
    'updated_at' => $date,
]);

$factory->afterCreating(App\CallForProjects::class, function ($item, $faker) {
    $item->perimeters()->save(factory(App\Perimeter::class)->make());
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

$factory->define(App\NewsletterSubscriber::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->email,
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'subscribed_at' => now()->subDays(random_int(1, 180)),
    ];
});

$factory->state(App\NewsletterSubscriber::class, 'unsubscribed', [
    'subscribed_at' => null,
]);