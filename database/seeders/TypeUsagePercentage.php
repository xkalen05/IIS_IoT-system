<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeUsagePercentage extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('types')->insert([
            'name' => 'Usage (%)',
            'value' => json_encode([
                "Usage(%)" => [
                    "MinimalValue" => [0,100],
                    "MaximalValue" => [0,100],
                ]
            ]),
        ]);
    }
}
