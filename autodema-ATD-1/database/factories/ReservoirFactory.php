<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Reservoir;
use Faker\Generator as Faker;

$factory->define(Reservoir::class, function (Faker $faker) {
    $name = $faker->name;

    return [
        'name' => $name,
    ];
});
