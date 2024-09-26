<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ServiceType;
use Faker\Generator as Faker;

$factory->define(ServiceType::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'description' => $faker->text,
        'price' => $faker->numberBetween(100,850),
    ];
});
