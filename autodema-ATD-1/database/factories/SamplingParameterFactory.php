<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SamplingParameter;
use Faker\Generator as Faker;

$factory->define(SamplingParameter::class, function (Faker $faker) {
    $min_value = 30+$faker->randomNumber(2)/20;
    return [
        'value' => $min_value,
        'parameter_id'=>\App\Parameter::all()->random()->id,
    ];
});
