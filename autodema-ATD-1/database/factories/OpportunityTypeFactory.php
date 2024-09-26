<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\OpportunityType;
use Faker\Generator as Faker;

$factory->define(OpportunityType::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
