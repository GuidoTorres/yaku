<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\EcaParameter;
use Faker\Generator as Faker;

$factory->define(EcaParameter::class, function (Faker $faker) {
    $min_value = 0+$faker->randomNumber(2)/20;
    $max_value = 45+$faker->randomNumber(2)/20;
    $allowed_value = $faker->word;
    return [
        'eca_id'=>\App\Eca::all()->random()->id,
        'parameter_id'=>\App\Parameter::all()->random()->id,
        'min_value' => $min_value,
        'max_value' => $max_value,
        'allowed_value' => $allowed_value,
    ];
});
