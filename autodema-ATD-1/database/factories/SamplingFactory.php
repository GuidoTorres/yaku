<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Sampling;
use Faker\Generator as Faker;

$factory->define(Sampling::class, function (Faker $faker) {
    $sampling_date= \Carbon\Carbon::createFromTimestamp($faker->dateTimeBetween($startDate = '-10 days', $endDate = '-5 days')->getTimeStamp());

    return [
        'sampling_point_id'=>\App\SamplingPoint::all()->random()->id,
        'deep_id'=>\App\Deep::all()->random()->id,
        'utm_zone' => "19k",
        'north' => $faker->latitude,
        'east' => $faker->longitude,
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude,
        'state' => Sampling::APPROVED,
        'user_created_id'=>\App\User::all()->random()->id,
        'user_approved_id'=>\App\User::all()->random()->id,
        'sampling_date' => $sampling_date,
    ];
});
