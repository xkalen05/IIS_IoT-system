<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeThermometer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('types')->insert([
            'name' => 'Thermometer (°C)',
            'value' => json_encode([
                "temperature(°C)" => [
                    "MinimalValue" => [-270,10000],
                    "MaximalValue" => [-270,10000],
                ]
            ]),
        ]);
    }
}
