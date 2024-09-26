<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Basins;
use Faker\Generator as Faker;

$factory->define(Basins::class, function (Faker $faker) {
    $name = $faker->name;

    return [
        'name' => $name,
    ];
});
