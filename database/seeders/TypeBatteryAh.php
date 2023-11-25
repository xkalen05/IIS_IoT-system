<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeBatteryAh extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('types')->insert([
            'name' => 'Battery (Ah)',
            'value' => json_encode([
                "Battery(Ah)" => [
                    "MinimalValue" => [0,1000000000],
                    "MaximalValue" => [0,1000000000],
                ]
            ]),
        ]);
    }
}
