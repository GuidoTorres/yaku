<?php

use App\CompanyContact;
use App\Survey;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //////////ROLES
        factory(\App\Role::class, 1)->create([
            'id' => \App\Role::ADMINISTRATOR,
            'name' => 'administrador',
        ]);
        factory(\App\Role::class, 1)->create([
            'id' => \App\Role::SUPERVISOR,
            'name' => 'supervisor',
        ]);
        factory(\App\Role::class, 1)->create([
            'id' => \App\Role::ANALYST,
            'name' => 'analista',
        ]);
        factory(\App\Role::class, 1)->create([
            'id' => \App\Role::VISUALIZER,
            'name' => 'visualizador',
        ]);

        //USERS
        factory(\App\User::class, 1)->create([
            'name' => 'Administrador',
            'email' => 'administrador@redyaku.com',
            'role_id' => \App\Role::ADMINISTRATOR,
            'state' => \App\User::ACTIVE,
        ]);
        factory(\App\User::class, 1)->create([
            'name' => 'Supervisor',
            'email' => 'supervisor@redyaku.com',
            'role_id' => \App\Role::SUPERVISOR,
            'state' => \App\User::ACTIVE,
        ]);
        factory(\App\User::class, 1)->create([
            'name' => 'Analista',
            'email' => 'analista@redyaku.com',
            'role_id' => \App\Role::ANALYST,
            'state' => \App\User::ACTIVE,
        ]);
        factory(\App\User::class, 1)->create([
            'name' => 'Visualizador',
            'email' => 'Visualizador@redyaku.com',
            'role_id' => \App\Role::VISUALIZER,
            'state' => \App\User::ACTIVE,
        ]);


        //RANDOM USERS
        factory(\App\User::class, 3)->create();


        /////ECAS
        ///
        /// CAT 1
        factory(\App\Eca::class, 1)->create([
            'id' => 1,
            'name' => 'CAT 1 - A1',
        ]);
        factory(\App\Eca::class, 1)->create([
            'id' => 2,
            'name' => 'CAT 1 - A2',
        ]);
        factory(\App\Eca::class, 1)->create([
            'id' => 3,
            'name' => 'CAT 1 - B1',
        ]);
        /// CAT 2
        factory(\App\Eca::class, 1)->create([
            'id' => 4,
            'name' => 'CAT 2 - A1',
        ]);
        factory(\App\Eca::class, 1)->create([
            'id' => 5,
            'name' => 'CAT 2 - B1',
        ]);


        /////CUENCAS
        factory(\App\Basins::class, 1)->create([
            'name' => 'Quilca-Vitor-Chili',
        ]);
        factory(\App\Basins::class, 1)->create([
            'name' => 'Colca-Camaná',
        ]);

        /////EMBALSES
        factory(\App\Reservoir::class, 1)->create([
            'name' => 'Pañe',
        ]);
        factory(\App\Reservoir::class, 1)->create([
            'name' => 'Frayle',
        ]);
        factory(\App\Reservoir::class, 1)->create([
            'name' => 'Dique los Españoles',
        ]);
        factory(\App\Reservoir::class, 1)->create([
            'name' => 'Aguada Blanca',
        ]);
        factory(\App\Reservoir::class, 1)->create([
            'name' => 'Puente Sumbay',
        ]);
        factory(\App\Reservoir::class, 1)->create([
            'name' => 'Condoroma',
        ]);


        /////AUTODEMA
        ///
        /// ZONES
        factory(\App\Zone::class, 1)->create([
            'name' => 'Lacustre',
        ]);
        factory(\App\Zone::class, 1)->create([
            'name' => 'Intermedia',
        ]);
        factory(\App\Zone::class, 1)->create([
            'name' => 'Fluvial',
        ]);
        //DEEPS
        factory(\App\Deep::class, 1)->create([
            'name' => 'Superficie (1.5m)',
        ]);
        factory(\App\Deep::class, 1)->create([
            'name' => 'Límite de zona eufótica',
        ]);

        //UNITS
        factory(\App\Unit::class, 1)->create([
            'id' => 1,
            'magnitude' => 'Temperatura',
            'unit' => 'Grados celcius',
            'symbol' => '°C',
        ]);
        factory(\App\Unit::class, 1)->create([
            'id' => 2,
            'magnitude' => 'Potencial eléctrico',
            'unit' => 'Voltio',
            'symbol' => 'V',
        ]);
        factory(\App\Unit::class, 1)->create([
            'id' => 3,
            'magnitude' => 'Carga eléctrica',
            'unit' => 'coulombio',
            'symbol' => 'C',
        ]);
        factory(\App\Unit::class, 1)->create([
            'id' => 4,
            'magnitude' => 'Densidad',
            'unit' => 'Kilogramo por metro cúbico',
            'symbol' => 'kg.m-3',
        ]);
        factory(\App\Unit::class, 1)->create([
            'id' => 5,
            'magnitude' => 'Conductancia eléctrica',
            'unit' => 'Siemens',
            'symbol' => 'S',
        ]);
        factory(\App\Unit::class, 1)->create([
            'id' => 6,
            'magnitude' => 'Actividad radiactiva',
            'unit' => 'Becquerel',
            'symbol' => 'Bq',
        ]);
        factory(\App\Unit::class, 1)->create([
            'id' => 7,
            'magnitude' => 'Radiación ionozante',
            'unit' => 'Gray',
            'symbol' => 'Gy',
        ]);

        //PARAMETER
        factory(\App\Parameter::class, 1)->create([
            'id' => 1,
            'name' => 'Temperatura superficial',
            'code' => 'temp_sup',
            'unit_id' => 1,
            'data_type' => \App\Parameter::FLOAT,
        ])
            ->each(function (\App\Parameter $pa) {
                for ($i = 1; $i <= 5; $i++) {
                    $randomMinFloat = rand(15, 20) ;
                    $randomMaxFloat = rand(35, 40) ;
                    factory(\App\EcaParameter::class, 1)->create([
                        'eca_id'=>$i,
                        'parameter_id'=>$pa->id,
                        'min_value'=>$randomMinFloat,
                        'max_value'=>$randomMaxFloat,
                        'allowed_value'=>null,
                    ]);
                }
            });
        factory(\App\Parameter::class, 1)->create([
            'id' => 2,
            'name' => 'Temperatura mínima ambiental',
            'code' => 'temp_min_amb',
            'unit_id' => 1,
            'data_type' => \App\Parameter::NEGATIVE_FLOAT,
        ])
            ->each(function (\App\Parameter $pa) {
                for ($i = 1; $i <= 5; $i++) {
                    $randomMinFloat = rand(-20, -15) ;
                    $randomMaxFloat = rand(-10, -5) ;
                    factory(\App\EcaParameter::class, 1)->create([
                        'eca_id'=>$i,
                        'parameter_id'=>$pa->id,
                        'min_value'=>$randomMinFloat,
                        'max_value'=>null,
                        'allowed_value'=>null,
                    ]);
                }
            });
        factory(\App\Parameter::class, 1)->create([
            'id' => 3,
            'name' => 'Temperatura máxima ambiental',
            'code' => 'temp_max_amb',
            'unit_id' => 1,
            'data_type' => \App\Parameter::POSITIVE_FLOAT,
        ])
            ->each(function (\App\Parameter $pa) {
                for ($i = 1; $i <= 5; $i++) {
                    $randomMinFloat = rand(40, 45) ;
                    $randomMaxFloat = rand(50, 55) ;
                    factory(\App\EcaParameter::class, 1)->create([
                        'eca_id'=>$i,
                        'parameter_id'=>$pa->id,
                        'min_value'=>null,
                        'max_value'=>$randomMaxFloat,
                        'allowed_value'=>null,
                    ]);
                }
            });
        factory(\App\Parameter::class, 1)->create([
            'id' => 4,
            'name' => 'Potencial muestra',
            'code' => 'pot_muest',
            'unit_id' => 2,
            'data_type' => \App\Parameter::INTEGER,
        ])
            ->each(function (\App\Parameter $pa) {
                for ($i = 1; $i <= 5; $i++) {
                    $randomMinFloat = rand(0, 3) ;
                    $randomMaxFloat = rand(10, 20) ;
                    factory(\App\EcaParameter::class, 1)->create([
                        'eca_id'=>$i,
                        'parameter_id'=>$pa->id,
                        'min_value'=>$randomMinFloat,
                        'max_value'=>$randomMaxFloat,
                        'allowed_value'=>null,
                    ]);
                }
            });
        factory(\App\Parameter::class, 1)->create([
            'id' => 5,
            'name' => 'Carga muestra',
            'code' => 'carga_muest',
            'unit_id' => 3,
            'data_type' => \App\Parameter::NEGATIVE_INTEGER,
        ])
            ->each(function (\App\Parameter $pa) {
                for ($i = 1; $i <= 5; $i++) {
                    $randomMinFloat = rand(-20, -15) ;
                    $randomMaxFloat = rand(-5, 0) ;
                    factory(\App\EcaParameter::class, 1)->create([
                        'eca_id'=>$i,
                        'parameter_id'=>$pa->id,
                        'min_value'=>$randomMinFloat,
                        'max_value'=>$randomMaxFloat,
                        'allowed_value'=>null,
                    ]);
                }
            });
        factory(\App\Parameter::class, 1)->create([
            'id' => 6,
            'name' => 'Densidad del agua',
            'code' => 'dens_agua',
            'unit_id' => 4,
            'data_type' => \App\Parameter::ZERO_TO_ONE_DECIMAL,
        ])
            ->each(function (\App\Parameter $pa) {
                for ($i = 1; $i <= 5; $i++) {
                    $randomMinFloat = rand(1, 3)/10 ;
                    $randomMaxFloat = rand(7, 10)/10;
                    factory(\App\EcaParameter::class, 1)->create([
                        'eca_id'=>$i,
                        'parameter_id'=>$pa->id,
                        'min_value'=>$randomMinFloat,
                        'max_value'=>$randomMaxFloat,
                        'allowed_value'=>null,
                    ]);
                }
            });
        factory(\App\Parameter::class, 1)->create([
            'id' => 7,
            'name' => 'Conductancia del medio',
            'code' => 'cond_med',
            'unit_id' => 5,
            'data_type' => \App\Parameter::STRING,
        ])
            ->each(function (\App\Parameter $pa) {
                for ($i = 1; $i <= 5; $i++) {
                    factory(\App\EcaParameter::class, 1)->create([
                        'eca_id'=>$i,
                        'parameter_id'=>$pa->id,
                        'min_value'=>null,
                        'max_value'=>null,
                        'allowed_value'=>"no",
                    ]);
                }
            });
        factory(\App\Parameter::class, 1)->create([
            'id' => 8,
            'name' => 'Radiactividad del medio',
            'code' => 'rad_med',
            'unit_id' => 6,
            'data_type' => \App\Parameter::BOOLEAN,
        ])
            ->each(function (\App\Parameter $pa) {
                for ($i = 1; $i <= 5; $i++) {
                    factory(\App\EcaParameter::class, 1)->create([
                        'eca_id'=>$i,
                        'parameter_id'=>$pa->id,
                        'allowed_value'=>false,
                        'min_value'=>null,
                        'max_value'=>null,
                    ]);
                }
            });
        factory(\App\Parameter::class, 1)->create([
            'id' => 9,
            'name' => 'Ionización del ambiente',
            'code' => 'ion_amb',
            'unit_id' => 7,
            'data_type' => \App\Parameter::FLOAT,
        ])
            ->each(function (\App\Parameter $pa) {
                for ($i = 1; $i <= 5; $i++) {
                    $randomMinFloat = rand(-10, -3)/10 ;
                    $randomMaxFloat = rand(20, 40)/10;
                    factory(\App\EcaParameter::class, 1)->create([
                        'eca_id'=>$i,
                        'parameter_id'=>$pa->id,
                        'min_value'=>$randomMinFloat,
                        'max_value'=>$randomMaxFloat,
                        'allowed_value'=>null,
                    ]);
                }
            });


        //SAMPLING POINTS


        factory(\App\SamplingPoint::class, 1)->create([
            'name' => 'Aguada Blanca',
            'utm_zone' => "19k",
            'north' => 8202410.89,
            'east' => 249346.14,
            'latitude' => -71.345338,
            'longitude' => -16.246670,
            'basin_id' => 1,
            'type' =>\App\SamplingPoint::FIXED_POINT
        ])
            ->each(function (\App\SamplingPoint $sp) {
                factory(\App\Sampling::class, 30)->create([
                    'sampling_point_id'=>$sp->id,
                    ])
                    ->each(function (\App\Sampling $sa) {
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>1,
                            'sampling_id'=>$sa->id,
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>2,
                            'sampling_id'=>$sa->id,
                            'value' => rand(0,20),
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>3,
                            'sampling_id'=>$sa->id,
                            'value' => rand(38,45),
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>4,
                            'sampling_id'=>$sa->id,
                            'value' => rand(0,50)/10,
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>5,
                            'sampling_id'=>$sa->id,
                            'value' => rand(0,220),
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>6,
                            'sampling_id'=>$sa->id,
                            'value' => rand(0,10)/10,
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>7,
                            'sampling_id'=>$sa->id,
                            'value' => rand(0,10),
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>8,
                            'sampling_id'=>$sa->id,
                            'value' => rand(2,15),
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>9,
                            'sampling_id'=>$sa->id,
                            'value' => rand(15,30),
                        ]);
                    });
            });
        factory(\App\SamplingPoint::class, 1)->create([
            'name' => 'Laguna Azul',
            'utm_zone' => "19k",
            'north' => 8202456.09,
            'east' => 249329.47,
            'latitude' => -71.345231,
            'longitude' => -16.245650,
            'basin_id' => 1,
            'type' =>\App\SamplingPoint::FIXED_POINT
        ])
            ->each(function (\App\SamplingPoint $sp) {
                factory(\App\Sampling::class, 30)->create([
                    'sampling_point_id'=>$sp->id,
                ])
                    ->each(function (\App\Sampling $sa) {
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>1,
                            'sampling_id'=>$sa->id,
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>2,
                            'sampling_id'=>$sa->id,
                            'value' => rand(0,20),
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>3,
                            'sampling_id'=>$sa->id,
                            'value' => rand(38,45),
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>4,
                            'sampling_id'=>$sa->id,
                            'value' => rand(0,50)/10,
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>5,
                            'sampling_id'=>$sa->id,
                            'value' => rand(0,220),
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>6,
                            'sampling_id'=>$sa->id,
                            'value' => rand(0,10)/10,
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>7,
                            'sampling_id'=>$sa->id,
                            'value' => rand(0,10),
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>8,
                            'sampling_id'=>$sa->id,
                            'value' => rand(2,15),
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>9,
                            'sampling_id'=>$sa->id,
                            'value' => rand(15,30),
                        ]);
                    });
            });
        factory(\App\SamplingPoint::class, 1)->create([
            'name' => 'Cascada Cristalina',
            'utm_zone' => "19k",
            'north' => 8203238.55,
            'east' => 250042.87,
            'latitude' => -71.338477,
            'longitude' => -16.238656,
            'basin_id' => 1,
            'type' =>\App\SamplingPoint::FIXED_POINT
        ])
            ->each(function (\App\SamplingPoint $sp) {
                factory(\App\Sampling::class, 30)->create([
                    'sampling_point_id'=>$sp->id,
                ])
                    ->each(function (\App\Sampling $sa) {
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>1,
                            'sampling_id'=>$sa->id,
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>2,
                            'sampling_id'=>$sa->id,
                            'value' => rand(0,20),
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>3,
                            'sampling_id'=>$sa->id,
                            'value' => rand(38,45),
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>4,
                            'sampling_id'=>$sa->id,
                            'value' => rand(0,50)/10,
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>5,
                            'sampling_id'=>$sa->id,
                            'value' => rand(0,220),
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>6,
                            'sampling_id'=>$sa->id,
                            'value' => rand(0,10)/10,
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>7,
                            'sampling_id'=>$sa->id,
                            'value' => rand(0,10),
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>8,
                            'sampling_id'=>$sa->id,
                            'value' => rand(2,15),
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>9,
                            'sampling_id'=>$sa->id,
                            'value' => rand(15,30),
                        ]);
                    });
            });
        factory(\App\SamplingPoint::class, 1)->create([
            'name' => 'Delta Rojo',
            'utm_zone' => "19k",
            'north' => 8213775.33,
            'east' => 266403.08,
            'latitude' => -71.184454,
            'longitude' => -16.145103,
            'basin_id' => 2,
            'type' =>\App\SamplingPoint::FIXED_POINT
        ])
            ->each(function (\App\SamplingPoint $sp) {
                factory(\App\Sampling::class, 30)->create([
                    'sampling_point_id'=>$sp->id,
                ])
                    ->each(function (\App\Sampling $sa) {
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>1,
                            'sampling_id'=>$sa->id,
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>2,
                            'sampling_id'=>$sa->id,
                            'value' => rand(0,20),
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>3,
                            'sampling_id'=>$sa->id,
                            'value' => rand(38,45),
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>4,
                            'sampling_id'=>$sa->id,
                            'value' => rand(0,50)/10,
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>5,
                            'sampling_id'=>$sa->id,
                            'value' => rand(0,220),
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>6,
                            'sampling_id'=>$sa->id,
                            'value' => rand(0,10)/10,
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>7,
                            'sampling_id'=>$sa->id,
                            'value' => rand(0,10),
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>8,
                            'sampling_id'=>$sa->id,
                            'value' => rand(2,15),
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>9,
                            'sampling_id'=>$sa->id,
                            'value' => rand(15,30),
                        ]);
                    });
            });
        factory(\App\SamplingPoint::class, 1)->create([
            'name' => 'Delta verde',
            'utm_zone' => "19k",
            'north' => 8214330.17,
            'east' => 265364.05,
            'latitude' => -71.194110,
            'longitude' => -16.139991,
            'basin_id' => 2,
            'type' =>\App\SamplingPoint::FIXED_POINT
        ])
            ->each(function (\App\SamplingPoint $sp) {
                factory(\App\Sampling::class, 30)->create([
                    'sampling_point_id'=>$sp->id,
                ])
                    ->each(function (\App\Sampling $sa) {
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>1,
                            'sampling_id'=>$sa->id,
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>2,
                            'sampling_id'=>$sa->id,
                            'value' => rand(0,20),
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>3,
                            'sampling_id'=>$sa->id,
                            'value' => rand(38,45),
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>4,
                            'sampling_id'=>$sa->id,
                            'value' => rand(0,50)/10,
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>5,
                            'sampling_id'=>$sa->id,
                            'value' => rand(0,220),
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>6,
                            'sampling_id'=>$sa->id,
                            'value' => rand(0,10)/10,
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>7,
                            'sampling_id'=>$sa->id,
                            'value' => rand(0,10),
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>8,
                            'sampling_id'=>$sa->id,
                            'value' => rand(2,15),
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>9,
                            'sampling_id'=>$sa->id,
                            'value' => rand(15,30),
                        ]);
                    });
            });
        factory(\App\SamplingPoint::class, 1)->create([
            'name' => 'Delta verde flotante',
            'utm_zone' => "19k",
            'north' => 8215135.83,
            'east' => 267316.23,
            'latitude' => -71.175785,
            'longitude' => -16.132900,
            'basin_id' => 2,
            'type' =>\App\SamplingPoint::FLOAT_POINT
        ])
            ->each(function (\App\SamplingPoint $sp) {
                factory(\App\Sampling::class, 30)->create([
                    'sampling_point_id'=>$sp->id,
                ])
                    ->each(function (\App\Sampling $sa) {
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>1,
                            'sampling_id'=>$sa->id,
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>2,
                            'sampling_id'=>$sa->id,
                            'value' => rand(0,20),
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>3,
                            'sampling_id'=>$sa->id,
                            'value' => rand(38,45),
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>4,
                            'sampling_id'=>$sa->id,
                            'value' => rand(0,50)/10,
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>5,
                            'sampling_id'=>$sa->id,
                            'value' => rand(0,220),
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>6,
                            'sampling_id'=>$sa->id,
                            'value' => rand(0,10)/10,
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>7,
                            'sampling_id'=>$sa->id,
                            'value' => rand(0,10),
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>8,
                            'sampling_id'=>$sa->id,
                            'value' => rand(2,15),
                        ]);
                        factory(\App\SamplingParameter::class, 1)->create([
                            'parameter_id'=>9,
                            'sampling_id'=>$sa->id,
                            'value' => rand(15,30),
                        ]);
                    });
            });


    }
}
