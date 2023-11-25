<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeLightSensor extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('types')->insert([
            'name' => 'Light Sensor (lux)',
            'value' => json_encode([
                "lux" => [
                    "MinimalValue" => [0,1000000],
                    "MaximalValue" => [0,1000000],
                ]
            ]),
        ]);
    }
}
