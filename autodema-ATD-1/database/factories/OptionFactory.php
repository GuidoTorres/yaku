<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Option;
use Faker\Generator as Faker;

$factory->define(Option::class, function (Faker $faker) {
    return [
        'type' => $faker->numberBetween(Option::WAY_BELOW_MEAN,Option::WAY_ABOVE_MEAN),
        'question_id'=>\App\Question::all()->random()->id,
    ];
});
