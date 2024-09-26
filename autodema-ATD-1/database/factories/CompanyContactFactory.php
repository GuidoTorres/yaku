<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CompanyContact;
use Faker\Generator as Faker;

$factory->define(CompanyContact::class, function (Faker $faker) {
    $name = $faker->name;
    $last_name =  $faker->lastName;

    return [
        'name' => $name,
        'last_name' => $last_name,
        'email' => $faker->unique()->safeEmail,
        'cellphone' => $faker->phoneNumber,
        'principal' => CompanyContact::SECONDARY,
        'company_id'=>\App\Company::all()->random()->id,
        'user_owner_id'=>\App\User::all()->random()->id,
        'user_id'=>\App\User::all()->random()->id,
    ];
});
