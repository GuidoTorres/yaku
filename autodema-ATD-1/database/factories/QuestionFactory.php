<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Question;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    $order_updated_at= \Carbon\Carbon::createFromTimestamp($faker->dateTimeBetween($startDate = '-5 days', $endDate = '-1 days')->getTimeStamp());

    $pre_arr=["Tiempo", "Calidad", "Trato", "Sensación"];
    $mid_arr=[" al ser atendido ", " durante el servicio brindado ", " al recibir el proyecto ", " durante la visita "];
    $post_arr=["por nuestro consultor.", "por nuestro asociado", "por nuestro trabajador", "por nuestro representante"];

    $question = $faker->randomElement($pre_arr).$faker->randomElement($mid_arr).$faker->randomElement($post_arr);

    return [
        'name' => $question,
        'order' => $faker->numberBetween(1,5),
        'order_updated_at' => $order_updated_at,
        'survey_id'=>\App\Survey::all()->random()->id,
    ];
});
