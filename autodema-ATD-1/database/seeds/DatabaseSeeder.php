<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $faker = \Faker\Factory::create();

        //$this->call(CountrySeeder::class);


        $this->call(TestSeeder::class);
        //$this->call(ProductionSeeder::class);


    }
}
