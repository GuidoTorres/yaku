<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Campaign;
use Faker\Generator as Faker;

$factory->define(Campaign::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'campaign_type_id'=>\App\CampaignType::all()->random()->id,
        'user_id'=>\App\User::all()->random()->id,
    ];
});
