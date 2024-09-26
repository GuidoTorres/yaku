<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Additional;
use Faker\Generator as Faker;

$factory->define(Additional::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'description' => $faker->text,
        'price' => $faker->numberBetween(100,850),
        'service_type_id'=>\App\ServiceType::all()->random()->id,
    ];
});
