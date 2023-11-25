<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeLiquidFlow extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('types')->insert([
            'name' => 'Liquid Flow (m^3)',
            'value' => json_encode([
                "m^3" => [
                    "MinimalValue" => [0,10000000],
                    "MaximalValue" => [0,10000000],
                ]
            ]),
        ]);
    }
}
