<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Activity;
use Faker\Generator as Faker;

$factory->define(Activity::class, function (Faker $faker) {
    $did_at= \Carbon\Carbon::createFromTimestamp($faker->dateTimeBetween($startDate = '-10 days', $endDate = '-5 days')->getTimeStamp());

    $pre_arr=["Primera", "Segunda", "Tercera", "Última"];
    $mid_arr=[" llamada ", " vez enviando correo ", " visita "];
    $post_arr=["realizada", "a cliente", "a empresa", "a contacto de empresa"];

    $name = $faker->randomElement($pre_arr).$faker->randomElement($mid_arr);
    $description = $name.$faker->randomElement($post_arr);

    return [
        'activity_type_id'=>\App\ActivityType::all()->random()->id,
        'opportunity_id'=>\App\Opportunity::all()->random()->id,
        'company_contact_id'=>\App\CompanyContact::all()->random()->id,
        'user_id'=>\App\User::all()->random()->id,
        'name' => $name,
        'description' => $faker->text,
        'did_at' => $did_at,
    ];
});
