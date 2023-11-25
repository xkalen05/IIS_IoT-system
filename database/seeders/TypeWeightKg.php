<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeWeightKg extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('types')->insert([
            'name' => 'Weight (kg)',
            'value' => json_encode([
                "Weight(kg)" => [
                    "MinimalValue" => [0,1000000],
                    "MaximalValue" => [0,1000000],
                ]
            ]),
        ]);
    }
}
