<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Eca;
use Faker\Generator as Faker;

$factory->define(Eca::class, function (Faker $faker) {
    $name = $faker->name;
    $description =  $faker->text;
    return [
        'name' => $name,
        'description' => $description,
    ];
});
