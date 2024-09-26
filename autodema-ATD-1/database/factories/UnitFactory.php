<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Unit;
use Faker\Generator as Faker;

$factory->define(Unit::class, function (Faker $faker) {
    $name = $faker->name;
    return [
        'magnitude' => $name,
        'unit' => $faker->sentence,
        'symbol' => $faker->randomLetter,
    ];
});
