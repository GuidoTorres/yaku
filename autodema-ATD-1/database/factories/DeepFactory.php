<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Deep;
use Faker\Generator as Faker;

$factory->define(Deep::class, function (Faker $faker) {
    $name = $faker->name;

    return [
        'name' => $name,
    ];
});
