<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CampaignType;
use Faker\Generator as Faker;

$factory->define(CampaignType::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
    ];
});
