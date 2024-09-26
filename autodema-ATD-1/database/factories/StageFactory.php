<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Stage;
use Faker\Generator as Faker;

$factory->define(Stage::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'order' => $faker->numberBetween(Stage::FIRST_MEETING,Stage::CLOSED_LOST),
    ];
});
