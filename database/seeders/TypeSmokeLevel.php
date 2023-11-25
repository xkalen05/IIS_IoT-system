<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSmokeLevel extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('types')->insert([
            'name' => 'Smoke Level (%)',
            'value' => json_encode([
                "PercentageOfAir" => [
                    "MinimalValue" => [0,100],
                    "MaximalValue" => [0,100],
                ]
            ]),
        ]);
    }
}
