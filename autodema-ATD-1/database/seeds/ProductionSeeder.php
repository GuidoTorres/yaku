<?php

use Illuminate\Database\Seeder;

class ProductionSeeder extends Seeder
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
            'name' => 'Desarrollador',
            'email' => 'contacto@redyaku.com',
            //'password' => 'admin2021',
            'role_id' => \App\Role::ADMINISTRATOR,
            'state' => \App\User::ACTIVE,
        ]);
        factory(\App\User::class, 1)->create([
            'name' => 'Supervisor',
            'email' => 'admin@pems.pe',
            'password' => '$2y$10$fp19WB0MAmryw9Q3i5gvzOCIdyMDpa3U/BUGYIr8ZUC5ptJewjqqO',
            //'password' => 'admin2021',
            'role_id' => \App\Role::ADMINISTRATOR,
            'state' => \App\User::ACTIVE,
        ]);
        factory(\App\User::class, 1)->create([
            'name' => 'Jose',
            'last_name' => 'Rodriguez',
            'email' => 'consultasexternas.2016@gmail.com',
            'password' => '$2y$10$DK8lEI512.d0zBnhTLtpkOcAXe8R4BKe5REr0Re3KnkGR8tTJ9Ppy',
            //'password' => 'admin2021',
            'role_id' => \App\Role::VISUALIZER,
            'state' => \App\User::ACTIVE,
        ]);

        /////ECAS
        ///
        /// CAT 1
        factory(\App\Eca::class, 1)->create([
            'id' => 1,
            'name' => 'CATEGORÍA 1A2',
        ]);
        factory(\App\Eca::class, 1)->create([
            'id' => 2,
            'name' => 'CATEGORÍA 3D1',
        ]);
        factory(\App\Eca::class, 1)->create([
            'id' => 3,
            'name' => 'CATEGORÍA 4E1',
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
            'name' => 'El Pañe',
        ]);
        factory(\App\Reservoir::class, 1)->create([
            'name' => 'El Frayle',
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
        factory(\App\Reservoir::class, 1)->create([
            'name' => 'San José de Uzuña',
        ]);
        factory(\App\Reservoir::class, 1)->create([
            'name' => 'Pillones',
        ]);
        factory(\App\Reservoir::class, 1)->create([
            'name' => 'Chalhuanca',
        ]);
        factory(\App\Reservoir::class, 1)->create([
            'name' => 'Bamputañe',
        ]);
        factory(\App\Reservoir::class, 1)->create([
            'name' => 'Bocatoma Tuti',
        ]);
        factory(\App\Reservoir::class, 1)->create([
            'name' => 'Bocatoma Pitay',
        ]);
        factory(\App\Reservoir::class, 1)->create([
            'name' => 'Desarenador Huambo',
        ]);


        /////AUTODEMA
        ///
        /// ZONES
        factory(\App\Zone::class, 1)->create([
            'name' => 'Fluvial',
        ]);
        factory(\App\Zone::class, 1)->create([
            'name' => 'Intermedia',
        ]);
        factory(\App\Zone::class, 1)->create([
            'name' => 'Lacustre',
        ]);
        factory(\App\Zone::class, 1)->create([
            'name' => 'Afluente',
        ]);
        factory(\App\Zone::class, 1)->create([
            'name' => 'Efluente',
        ]);
        factory(\App\Zone::class, 1)->create([
            'name' => 'Bocatoma',
        ]);
        factory(\App\Zone::class, 1)->create([
            'name' => 'Desarenador',
        ]);
        factory(\App\Zone::class, 1)->create([
            'name' => 'Lacustre piscigranja',
        ]);
        factory(\App\Zone::class, 1)->create([
            'name' => 'N.A.',
        ]);

        //DEEPS
        factory(\App\Deep::class, 1)->create([
            'name' => 'Prof. máx._(m)',
        ]);
        factory(\App\Deep::class, 1)->create([
            'name' => 'Secchi_m',
        ]);
        factory(\App\Deep::class, 1)->create([
            'name' => 'Z_eu (m)',
        ]);
        factory(\App\Deep::class, 1)->create([
            'name' => 'Llímite_afótica (m)',
        ]);
        factory(\App\Deep::class, 1)->create([
            'name' => 'Z_afo (m)',
        ]);

        //UNITS
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Temperatura',
            'unit' => 'grados Celsius',
            'symbol' => '°C',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Temperatura mínima ambiental',
                    'code'=>'tmin_amb',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Temperatura máxima ambiental',
                    'code'=>'tmax_amb',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Temperatura',
                    'code'=>'temp_agua',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'pH',
            'unit' => 'pH',
            'symbol' => 'pH',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Potencial de hidrogeniones',
                    'code'=>'pH',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Unidad nefelométrica',
            'unit' => 'unidades nefelometrica',
            'symbol' => 'UNT',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Unidad nefelométrica de turbiedad',
                    'code'=>'unt',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Unidad nefelométrica de turbiedad_espec',
                    'code'=>'unt_espec',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Conductividad',
            'unit' => 'microSiemens por centímetro',
            'symbol' => 'µS/cm',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Conductividad',
                    'code'=>'cond',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Oxígeno disuelto',
            'unit' => 'miligramos por litro',
            'symbol' => 'mg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Oxígeno disuelto',
                    'code'=>'od',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Oxígeno disuelto_porcentaje',
                    'code'=>'od_porcentaje',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Sólidos suspendidos totales',
            'unit' => 'miligramos por litro',
            'symbol' => 'mg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Sólidos suspendidos totales',
                    'code'=>'tss',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Sólidos suspendidos totales_espec',
                    'code'=>'tss_espec',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Sólidos totales disueltos',
            'unit' => 'miligramos por litro',
            'symbol' => 'mg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Sólidos totales disueltos',
                    'code'=>'tds',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Nitrógeno amoniacal',
            'unit' => 'miligramos por litro',
            'symbol' => 'mg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Nitrógeno amoniacal',
                    'code'=>'n_amoniacal',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Amoniaco',
            'unit' => 'miligramos por litro',
            'symbol' => 'mg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Amoniaco',
                    'code'=>'amoniaco',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Amonio',
            'unit' => 'miligramos por litro',
            'symbol' => 'mg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Amonio',
                    'code'=>'amonio',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Fosfatos',
            'unit' => 'miligramos por litro',
            'symbol' => 'mg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Fosfatos',
                    'code'=>'fosfatos',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Fósforo del ortofosfato',
            'unit' => 'miligramos por litro',
            'symbol' => 'mg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Fósforo_ortofosfato',
                    'code'=>'p_ortofosfato',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Pentóxido de fósforo',
            'unit' => 'miligramos por litro',
            'symbol' => 'mg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Pentóxido de fósforo',
                    'code'=>'pentoxido_fosforo',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Nitrógeno de nitrato',
            'unit' => 'miligramos por litro',
            'symbol' => 'mg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Nitrógeno de nitrato',
                    'code'=>'nitrogeno_nitrato',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Nitrato',
            'unit' => 'miligramos por litro',
            'symbol' => 'mg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Nitrato',
                    'code'=>'nitrato',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Fósforo total',
            'unit' => 'miligramos por litro',
            'symbol' => 'mg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Fósforo total',
                    'code'=>'p_total',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Ortofosfato_fósforo total',
            'unit' => 'miligramos por litro',
            'symbol' => 'mg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Ortofosfato_fósforo total',
                    'code'=>'ortofosfato_fosforo_ total',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Óxido de fósforo_fósforo total',
            'unit' => 'miligramos por litro',
            'symbol' => 'mg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Óxido de fósforo_fósforo total',
                    'code'=>'oxido_fosforo_fosforo_total',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Nitrógeno total',
            'unit' => 'miligramos por litro',
            'symbol' => 'mg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Nitrógeno total',
                    'code'=>'n_total',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Nitrógeno amoniacal_nitrógeno total',
            'unit' => 'miligramos por litro',
            'symbol' => 'mg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Nitrógeno amoniacal_nitrógeno total',
                    'code'=>'nitrogeno amoniacal_n',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Nitrato_nitrógeno total',
            'unit' => 'miligramos por litro',
            'symbol' => 'mg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Nitrato_nitrógeno total',
                    'code'=>'nitrato_nitrogeno_total',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Óxido de silicio',
            'unit' => 'miligramos por litro',
            'symbol' => 'mg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Óxido de silicio',
                    'code'=>'oxido_silicio',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Silicio',
            'unit' => 'miligramos por litro',
            'symbol' => 'mg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Silicio',
                    'code'=>'silicio',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Hierro',
            'unit' => 'miligramos por litro',
            'symbol' => 'mg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Hierro',
                    'code'=>'hierro',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Hierro (II)',
            'unit' => 'miligramos por litro',
            'symbol' => 'mg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Hierro (II)',
                    'code'=>'hierro_ii',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Hierro (III)',
            'unit' => 'miligramos por litro',
            'symbol' => 'mg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Hierro (III)',
                    'code'=>'hierro_iii',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Manganeso',
            'unit' => 'miligramos por litro',
            'symbol' => 'mg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Manganeso',
                    'code'=>'manganeso',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Permanganato',
            'unit' => 'miligramos por litro',
            'symbol' => 'mg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Permanganato',
                    'code'=>'permanganato',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Permanganato de potasio',
            'unit' => 'miligramos por litro',
            'symbol' => 'mg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Permanganato de potasio',
                    'code'=>'permanganato_potasio',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Sulfatos',
            'unit' => 'miligramos por litro',
            'symbol' => 'mg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Sulfatos',
                    'code'=>'sulfatos',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Cloruros',
            'unit' => 'miligramos por litro',
            'symbol' => 'mg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Cloruros',
                    'code'=>'cloruros',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Potasio',
            'unit' => 'miligramos por litro',
            'symbol' => 'mg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Potasio',
                    'code'=>'potasio',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Óxido de potasio',
            'unit' => 'miligramos por litro',
            'symbol' => 'mg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Óxido de potasio',
                    'code'=>'oxido_potasio',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Calcio',
            'unit' => 'miligramos por litro',
            'symbol' => 'mg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Calcio',
                    'code'=>'calcio',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Magnesio',
            'unit' => 'miligramos por litro',
            'symbol' => 'mg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Magnesio',
                    'code'=>'magnesio',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Dureza cálcica',
            'unit' => 'miligramos por litro',
            'symbol' => 'mg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Dureza cálcica',
                    'code'=>'dureza _calcica',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Alcalinidad',
            'unit' => 'miligramos por litro',
            'symbol' => 'mg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Alcalinidad',
                    'code'=>'alcalinidad',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Arsénico',
            'unit' => 'miligramos por litro',
            'symbol' => 'mg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Arsénico',
                    'code'=>'arsenico',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Clorofila-a',
            'unit' => 'microgramos por litro',
            'symbol' => 'µg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Clorofila-a',
                    'code'=>'chla',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Microcistina-LR',
            'unit' => 'microgramos por litro',
            'symbol' => 'µg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Microcistina-LR',
                    'code'=>'mr_lr',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Anatoxina-a',
            'unit' => 'microgramos por litro',
            'symbol' => 'µg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Anatoxina-a',
                    'code'=>'ana_a',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Nitrógeno de nitrito',
            'unit' => 'microgramos por litro',
            'symbol' => 'µg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Nitrógeno de nitrito',
                    'code'=>'N-NO2_µg/L',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Nitrito',
            'unit' => 'microgramos por litro',
            'symbol' => 'µg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Nitrito',
                    'code'=>'NO2-_µg/L',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Nitrito de sodio',
            'unit' => 'microgramos por litro',
            'symbol' => 'µg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Nitrito de sodio',
                    'code'=>'NaNO2_µg/L',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Cianobacteria',
            'unit' => 'células por mililitro',
            'symbol' => 'cel/mL',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Cianobacteria',
                    'code'=>'cya',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Dinoflagelado',
            'unit' => 'células por mililitro',
            'symbol' => 'cel/mL',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Dinoflagelado',
                    'code'=>'din',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Criptofícea',
            'unit' => 'células por mililitro',
            'symbol' => 'cel/mL',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Criptofícea',
                    'code'=>'cry',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Crisofícea',
            'unit' => 'células por mililitro',
            'symbol' => 'cel/mL',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Crisofícea',
                    'code'=>'cry',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Diatomeas',
            'unit' => 'células por mililitro',
            'symbol' => 'cel/mL',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Diatomeas',
                    'code'=>'diato',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Clorofíceas',
            'unit' => 'células por mililitro',
            'symbol' => 'cel/mL',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Clorofíceas',
                    'code'=>'chl',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Zignemafíceas',
            'unit' => 'células por mililitro',
            'symbol' => 'cel/mL',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Zignemafíceas',
                    'code'=>'zyg',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Fitoplancton total',
            'unit' => 'células por mililitro',
            'symbol' => 'cel/mL',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Fitoplancton total',
                    'code'=>'ft',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Cianobacteria biovolumen',
            'unit' => 'células por mililitro',
            'symbol' => 'mm3/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Cianobacteria biovolumen',
                    'code'=>'cya_biov',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Dinoflagelado biovolumen',
            'unit' => 'milimetros cúbicos por litro',
            'symbol' => 'mm3/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Dinoflagelado biovolumen',
                    'code'=>'din_biov',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Criptofícea biovolumen',
            'unit' => 'milimetros cúbicos por litro',
            'symbol' => 'mm3/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Criptofícea biovolumen',
                    'code'=>'cry_biov',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Crisofícea biovolumen',
            'unit' => 'milimetros cúbicos por litro',
            'symbol' => 'mm3/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Crisofícea biovolumen',
                    'code'=>'chr_biov',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Diatomeas biovolumen',
            'unit' => 'milimetros cúbicos por litro',
            'symbol' => 'mm3/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Diatomeas biovolumen',
                    'code'=>'diato_biov',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Clorofíceas biovolumen',
            'unit' => 'milimetros cúbicos por litro',
            'symbol' => 'mm3/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Clorofíceas biovolumen',
                    'code'=>'chl_biov',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Zignemafíceas biovolumen',
            'unit' => 'milimetros cúbicos por litro',
            'symbol' => 'mm3/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Zignemafíceas biovolumen',
                    'code'=>'zyg_biov',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Fitoplancton total biovolumen',
            'unit' => 'milimetros cúbicos por litro',
            'symbol' => 'mm3/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Fitoplancton total biovolumen',
                    'code'=>'ft_biov',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Rotífero',
            'unit' => 'organismos por litro',
            'symbol' => 'org/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Rotífero',
                    'code'=>'rot',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Nauplio ciclopoide',
            'unit' => 'organismos por litro',
            'symbol' => 'org/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Nauplio ciclopoide',
                    'code'=>'naup_cyclo',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Nauplio calanoide',
            'unit' => 'organismos por litro',
            'symbol' => 'org/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Nauplio calanoide',
                    'code'=>'naup_cala',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Copepodito ciclopoide',
            'unit' => 'organismos por litro',
            'symbol' => 'org/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Copepodito ciclopoide',
                    'code'=>'dito_cyclo',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Copepodito calanoide',
            'unit' => 'organismos por litro',
            'symbol' => 'org/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Copepodito calanoide',
                    'code'=>'dito_cala',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Copépodo ciclopoide',
            'unit' => 'organismos por litro',
            'symbol' => 'org/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Copépodo ciclopoide',
                    'code'=>'cope_cyclo',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Copépodo calanoide',
            'unit' => 'organismos por litro',
            'symbol' => 'org/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Copépodo calanoide',
                    'code'=>'cope_cala',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Cladócero',
            'unit' => 'organismos por litro',
            'symbol' => 'org/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Cladócero',
                    'code'=>'clad',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Pequeños filtradores',
            'unit' => 'organismos por litro',
            'symbol' => 'org/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Pequeños filtradores',
                    'code'=>'peq_fil',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Herbívoros medianos filtradores',
            'unit' => 'organismos por litro',
            'symbol' => 'org/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Herbívoros medianos filtradores',
                    'code'=>'herb_med',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Omnívoros carnívoros',
            'unit' => 'organismos por litro',
            'symbol' => 'org/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Omnívoros carnívoros',
                    'code'=>'om_car',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Zooplancton total',
            'unit' => 'organismos por litro',
            'symbol' => 'org/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Zooplancton total',
                    'code'=>'zt',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Color aparente',
            'unit' => 'unidades platino cobalto',
            'symbol' => 'PCU',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Color aparente',
                    'code'=>'color_apa',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Color verdadero',
            'unit' => 'unidades platino cobalto',
            'symbol' => 'PCU',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Color verdadero',
                    'code'=>'color_ ver',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Salinidad',
            'unit' => 'partes por mil',
            'symbol' => 'ppt',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Salinidad',
                    'code'=>'sal',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Salinidad',
            'unit' => 'partes por mil',
            'symbol' => 'ppt',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Salinidad',
                    'code'=>'sal',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });





        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Macroinvertebrados total',
            'unit' => 'individuo por metro cuadrado',
            'symbol' => 'ind/m2',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Macroinvertebrados total',
                    'code'=>'mv',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Clase turbellaria',
            'unit' => 'individuo por metro cuadrado',
            'symbol' => 'ind/m2',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Clase turbellaria',
                    'code'=>'turb',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Clase hirudinea',
            'unit' => 'individuo por metro cuadrado',
            'symbol' => 'ind/m2',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Clase hirudinea',
                    'code'=>'hiru',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Clase oligochaeta',
            'unit' => 'individuo por metro cuadrado',
            'symbol' => 'ind/m2',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Clase oligochaeta',
                    'code'=>'oligo',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Clase gasteropoda',
            'unit' => 'individuo por metro cuadrado',
            'symbol' => 'ind/m2',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Clase gasteropoda',
                    'code'=>'gaste',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Clase bivalvia',
            'unit' => 'individuo por metro cuadrado',
            'symbol' => 'ind/m2',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Clase bivalvia',
                    'code'=>'biv',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Orden amphipoda',
            'unit' => 'individuo por metro cuadrado',
            'symbol' => 'ind/m2',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Orden amphipoda',
                    'code'=>'amphi',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Clase ostracoda',
            'unit' => 'individuo por metro cuadrado',
            'symbol' => 'ind/m2',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Clase ostracoda',
                    'code'=>'ostra',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Orden ephemeroptera',
            'unit' => 'individuo por metro cuadrado',
            'symbol' => 'ind/m2',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Orden ephemeroptera',
                    'code'=>'ephe',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Orden odonata',
            'unit' => 'individuo por metro cuadrado',
            'symbol' => 'ind/m2',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Orden odonata',
                    'code'=>'odo',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Orden plecoptera',
            'unit' => 'individuo por metro cuadrado',
            'symbol' => 'ind/m2',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Orden plecoptera',
                    'code'=>'ple',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Orden trichoptera',
            'unit' => 'individuo por metro cuadrado',
            'symbol' => 'ind/m2',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Orden trichoptera',
                    'code'=>'tri',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Orden lepidoptera',
            'unit' => 'individuo por metro cuadrado',
            'symbol' => 'ind/m2',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Orden lepidoptera',
                    'code'=>'lep',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Orden coleoptera',
            'unit' => 'individuo por metro cuadrado',
            'symbol' => 'ind/m2',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Orden coleoptera',
                    'code'=>'cole',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Orden diptera',
            'unit' => 'individuo por metro cuadrado',
            'symbol' => 'ind/m2',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Orden diptera',
                    'code'=>'dip',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Protozoarios',
            'unit' => 'células por mililitro',
            'symbol' => 'cel/mL',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Protozoarios',
                    'code'=>'pz',
                    'data_type'=>\App\Parameter::INTEGER,
                    'unit_id'=>$pa->id,
                ]);
            });
        factory(\App\Unit::class, 1)->create([
            'magnitude' => 'Saxitoxina',
            'unit' => 'microgramos por litro',
            'symbol' => 'µg/L',
        ])
            ->each(function (\App\Unit $pa) {
                factory(\App\Parameter::class, 1)->create([
                    'name'=>'Saxitoxina',
                    'code'=>'sx',
                    'data_type'=>\App\Parameter::POSITIVE_FLOAT,
                    'unit_id'=>$pa->id,
                ]);
            });

        //SAMPLING POINTS


        factory(\App\SamplingPoint::class, 1)->create([
            'name' => '134EPañe1',
            'hidrographic_unit' => '134',
            'east' => 283479,
            'north' => 8306071,
            'latitude' => 657.62466824472,
            'longitude' => -73.18757815394,
            'eca_id' => 3,
            'basin_id' => 2,
            'reservoir_id' => 1,
            'zone_id' => 1,
            'type' =>\App\SamplingPoint::FIXED_POINT
        ]);
        factory(\App\SamplingPoint::class, 1)->create([
            'name' => '134EPañe2',
            'hidrographic_unit' => '134',
            'east' => 281450,
            'north' => 8303142,
            'latitude' => -15.339082791512,
            'longitude' => -71.035755134453,
            'eca_id' => 3,
            'basin_id' => 2,
            'reservoir_id' => 1,
            'zone_id' => 2,
            'type' =>\App\SamplingPoint::FIXED_POINT
        ]);
        factory(\App\SamplingPoint::class, 1)->create([
            'name' => '134EPañe3',
            'hidrographic_unit' => '134',
            'east' => 278729,
            'north' => 8294844,
            'latitude' => -15.413822961073,
            'longitude' => -71.061826596991,
            'eca_id' =>  3,
            'basin_id' => 2,
            'reservoir_id' => 1,
            'zone_id' => 3,
            'type' =>\App\SamplingPoint::FIXED_POINT
        ]);
        factory(\App\SamplingPoint::class, 1)->create([
            'name' => '134EDEsp3',
            'hidrographic_unit' => '134',
            'east' => 280415,
            'north' => 8254877,
            'latitude' => -15.775067649744,
            'longitude' => -71.049704959049,
            'eca_id' => 1,
            'basin_id' => 2,
            'reservoir_id' => 3,
            'zone_id' => 3,
            'type' =>\App\SamplingPoint::FIXED_POINT
        ]);
        factory(\App\SamplingPoint::class, 1)->create([
            'name' => '134ECond1',
            'hidrographic_unit' => '134',
            'east' => 258527,
            'north' => 8294395,
            'latitude' => -15.41605308386,
            'longitude' => -71.250014829492,
            'eca_id' => 1,
            'basin_id' => 2,
            'reservoir_id' => 6,
            'zone_id' => 1,
            'type' =>\App\SamplingPoint::FIXED_POINT
        ]);
        factory(\App\SamplingPoint::class, 1)->create([
            'name' => '134ECond2',
            'hidrographic_unit' => '134',
            'east' => 254878,
            'north' => 8296213,
            'latitude' => -15.399282963066,
            'longitude' => -71.283817117134,
            'eca_id' => 1,
            'basin_id' => 2,
            'reservoir_id' => 6,
            'zone_id' => 3,
            'type' =>\App\SamplingPoint::FIXED_POINT
        ]);
        factory(\App\SamplingPoint::class, 1)->create([
            'name' => '134ECond3',
            'hidrographic_unit' => '134',
            'east' => 254939,
            'north' => 8295147,
            'latitude' => -15.408918705964,
            'longitude' => -71.283354234026,
            'eca_id' => 1,
            'basin_id' => 2,
            'reservoir_id' => 6,
            'zone_id' => 8,
            'type' =>\App\SamplingPoint::FIXED_POINT
        ]);
        factory(\App\SamplingPoint::class, 1)->create([
            'name' => '134ETuti',
            'hidrographic_unit' => '134',
            'east' => 227624,
            'north' => 8280844,
            'latitude' => -15.535342795284,
            'longitude' => -71.539266703293,
            'eca_id' => 2,
            'basin_id' => 2,
            'reservoir_id' => 11,
            'zone_id' => 6,
            'type' =>\App\SamplingPoint::FIXED_POINT
        ]);
        factory(\App\SamplingPoint::class, 1)->create([
            'name' => '134RHuam',
            'hidrographic_unit' => '134',
            'east' => 810970,
            'north' => 8253514,
            'latitude' => -15.777674148989,
            'longitude' => -66.097763259065,
            'eca_id' => 2,
            'basin_id' => 2,
            'reservoir_id' => 13,
            'zone_id' => 7,
            'type' =>\App\SamplingPoint::FIXED_POINT
        ]);
        factory(\App\SamplingPoint::class, 1)->create([
            'name' => '132EFray1',
            'hidrographic_unit' => '132',
            'east' => 269803,
            'north' => 8216774,
            'latitude' => -16.118336812597,
            'longitude' => -71.152383732369,
            'eca_id' => 3,
            'basin_id' => 1,
            'reservoir_id' => 2,
            'zone_id' => 1,
            'type' =>\App\SamplingPoint::FIXED_POINT
        ]);
        factory(\App\SamplingPoint::class, 1)->create([
            'name' => '132EFray2',
            'hidrographic_unit' => '132',
            'east' => 267109,
            'north' => 8215178,
            'latitude' => -16.132499239381,
            'longitude' => -71.1777175905,
            'eca_id' => 2,
            'basin_id' => 1,
            'reservoir_id' => 2,
            'zone_id' => 2,
            'type' =>\App\SamplingPoint::FIXED_POINT
        ]);
        factory(\App\SamplingPoint::class, 1)->create([
            'name' => '132EFray3',
            'hidrographic_unit' => '132',
            'east' => 265892,
            'north' => 8213365,
            'latitude' => -16.14876079309,
            'longitude' => -71.189271606879,
            'eca_id' => 3,
            'basin_id' => 1,
            'reservoir_id' => 2,
            'zone_id' => 3,
            'type' =>\App\SamplingPoint::FIXED_POINT
        ]);
        factory(\App\SamplingPoint::class, 1)->create([
            'name' => '132EABla1',
            'hidrographic_unit' => '132',
            'east' => 250095,
            'north' => 8204835,
            'latitude' => -16.224241247968,
            'longitude' => -71.33781925476,
            'eca_id' => 3,
            'basin_id' => 1,
            'reservoir_id' => 4,
            'zone_id' => 1,
            'type' =>\App\SamplingPoint::FIXED_POINT
        ]);
        factory(\App\SamplingPoint::class, 1)->create([
            'name' => '132EABla2',
            'hidrographic_unit' => '132',
            'east' => 249968,
            'north' => 8203384,
            'latitude' => -16.237334522463,
            'longitude' => -71.339161491159,
            'eca_id' => 3,
            'basin_id' => 1,
            'reservoir_id' => 4,
            'zone_id' => 2,
            'type' =>\App\SamplingPoint::FIXED_POINT
        ]);
        factory(\App\SamplingPoint::class, 1)->create([
            'name' => '132EABla3',
            'hidrographic_unit' => '132',
            'east' => 249333,
            'north' => 8202376,
            'latitude' => -16.246373778961,
            'longitude' => -71.345206565673,
            'eca_id' => 3,
            'basin_id' => 1,
            'reservoir_id' => 4,
            'zone_id' => 3,
            'type' =>\App\SamplingPoint::FIXED_POINT
        ]);
        factory(\App\SamplingPoint::class, 1)->create([
            'name' => '132RSigu3',
            'hidrographic_unit' => '132',
            'east' => 815385,
            'north' => 8207055,
            'latitude' => -16.196571317834,
            'longitude' => -66.050450400804,
            'eca_id' => 2,
            'basin_id' => 1,
            'reservoir_id' => 12,
            'zone_id' => 6,
            'type' =>\App\SamplingPoint::FIXED_POINT
        ]);


    }
}
