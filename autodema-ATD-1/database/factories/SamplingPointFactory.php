<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SamplingPoint;
use Faker\Generator as Faker;

$factory->define(SamplingPoint::class, function (Faker $faker) {
    $name = $faker->name;
    $hidrographic_unit = $faker->name;

    return [
        'name' => $name,
        'hidrographic_unit' => $hidrographic_unit,
        'utm_zone' => "19k",
        'north' => $faker->numberBetween(1000,2000),
        'east' => $faker->numberBetween(1000,2000),
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude,
        'eca_id'=>\App\Eca::all()->random()->id,
        'basin_id'=>\App\Basins::all()->random()->id,
        'reservoir_id'=>\App\Reservoir::all()->random()->id,
        'zone_id'=>\App\Zone::all()->random()->id,
        'user_created'=>\App\User::all()->random()->id,
        'type'=>$faker->numberBetween(1,2),
    ];
});
