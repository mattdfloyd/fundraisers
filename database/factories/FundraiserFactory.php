<?php

use Faker\Generator as Faker;

$factory->define(App\Fundraiser::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
    ];
});
