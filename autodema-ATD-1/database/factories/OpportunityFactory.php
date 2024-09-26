<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Opportunity;
use Faker\Generator as Faker;

$factory->define(Opportunity::class, function (Faker $faker) {
    $order_updated_at= \Carbon\Carbon::createFromTimestamp($faker->dateTimeBetween($startDate = '-10 days', $endDate = '-5 days')->getTimeStamp());
    $closed_at= \Carbon\Carbon::createFromTimestamp($faker->dateTimeBetween($startDate = '-5 days', $endDate = '-1 days')->getTimeStamp());

    $created_at= \Carbon\Carbon::createFromTimestamp($faker->dateTimeBetween($startDate = '-3 years', $endDate = '-1 days')->getTimeStamp());

    $pre_arr=["Servicio de", "Paquete de", "Propuesta de", "Cotización de"];
    $mid_arr=[" consultoría ", " asesoría ", " capacitación "];
    $post_arr=["empresarial", "", "a empresa", "completa", "total"];

    $quotation_arr=["1tQzcWVQUMjzl8Wlr5qkUWxJ878X9G7k9WpnY2muDVFo", "1xPFyO2eqhBn-3D2li0al1ZfdXC0NrStj3tLzgvQQam4", "1rXHhZ848Opnw2ARkm2L62laKKzgBQTQbJ4Q4p93dSg8", "1E3N1Oa_wfcNcOQCa8BZ0xZfNU-plGe6TMwOTO8k7CzA", ""];
    $contract_arr=["1iX-djoLeYdULZKB_mHOpFhvp1ZKTQoWKlaHsJgQKCvk", "1nLPOyBrYnltFnAyHnDCxmT0dndU4i1uNxaXdcMssMkI", "12XMUpPl-i9pUDX6d5BH9CSMU_TL79fzIImbmoteyYD8", "1Hw_TtbTFVgnUIelfhVSctaa9haPNhWpR15CpCvFf6y8", ""];


    $name = $faker->randomElement($pre_arr).$faker->randomElement($mid_arr).$faker->randomElement($post_arr);
    return [
        'name' => $name,
        'code' => $faker->bothify('COT-??-##'),
        'company_id'=>\App\Company::all()->random()->id,
        'opportunity_type_id'=>\App\OpportunityType::all()->random()->id,
        'campaign_id'=>\App\Campaign::all()->random()->id,
        'user_owner_id'=>\App\User::all()->random()->id,
        'user_id'=>\App\User::all()->random()->id,
        'stage_id'=>\App\Stage::all()->random()->id,
        'company_contact_id'=>\App\CompanyContact::all()->random()->id,
        'budget' => $faker->numberBetween(100,850),
        'service_price' => $faker->numberBetween(100,850),
        'order' => $faker->numberBetween(1,10),
        'order_updated_at' => $order_updated_at,
        'probability' => $faker->numberBetween(Opportunity::VERY_LOW,Opportunity::VERY_HIGH),
        'closed_at' => $closed_at,
        'quotation' => $faker->randomElement($quotation_arr),
        'contract' => $faker->randomElement($quotation_arr),
        'work_order' => "",
        'created_at' => $created_at,
    ];
});
