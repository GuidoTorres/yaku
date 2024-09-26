<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Survey;
use Faker\Generator as Faker;

$factory->define(Survey::class, function (Faker $faker) {
    $code = $faker->bothify("??##-#?#?");
    $code = $faker->toUpper($code);
    return [
        'name' => "Encuesta de satisfacción ".$code,
        'state' => $faker->numberBetween(Survey::ACTIVE,Survey::INACTIVE),
    ];
});
