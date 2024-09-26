<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Parameter;
use Faker\Generator as Faker;

$factory->define(Parameter::class, function (Faker $faker) {
    $name = $faker->name;
    $data_type = $faker->numberBetween(Parameter::POSITIVE_INTEGER,Parameter::ZERO_TO_ONE_DECIMAL);
    return [
        'name' => $name,
        'description' => $faker->sentence,
        'code' => $faker->lexify('?????'),
        'unit_id'=>\App\Unit::all()->random()->id,
        'data_type'=>$data_type,
    ];
});
