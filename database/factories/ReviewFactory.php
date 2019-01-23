<?php

use Faker\Generator as Faker;

$factory->define(App\Review::class, function (Faker $faker) {
    return [
        'fundraiser_id' => factory(App\Fundraiser::class),
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'rating' => $faker->numberBetween(1, 5),
        'comment' => $faker->text,
    ];
});
