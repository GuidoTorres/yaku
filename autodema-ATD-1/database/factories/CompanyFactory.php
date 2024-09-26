<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Company;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {
    return [
        'company_name' => $faker->company,
        'fanpage' => $faker->url,
        'website' => $faker->url,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'turn' => $faker->catchPhrase,
        'country_id' => \App\Country::all()->random()->id,
        'user_id'=>\App\User::all()->random()->id,
    ];
});
