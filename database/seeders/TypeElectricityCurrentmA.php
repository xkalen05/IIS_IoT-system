<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeElectricityCurrentmA extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('types')->insert([
            'name' => 'Electricity Current (mA)',
            'value' => json_encode([
                "Current(mA)" => [
                    "MinimalValue" => [0,1000000000],
                    "MaximalValue" => [0,1000000000],
                ]
            ]),
        ]);
    }
}
