<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeElectricityCurrentA extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('types')->insert([
            'name' => 'Electricity Current (A)',
            'value' => json_encode([
                "Current(A)" => [
                    "MinimalValue" => [0,1000000000],
                    "MaximalValue" => [0,1000000000],
                ]
            ]),
        ]);
    }
}
