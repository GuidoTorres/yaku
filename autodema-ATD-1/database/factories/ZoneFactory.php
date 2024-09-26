<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Zone;
use Faker\Generator as Faker;

$factory->define(Zone::class, function (Faker $faker) {
    $name = $faker->name;

    return [
        'name' => $name,
    ];
});
