<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeRefrigerator extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('types')->insert([
            'name' => 'Fridge',
            'value' => json_encode([
                "Temperature" => [
                    "MinimalValue" => [0,10000],
                    "MaximalValue" => [0,10000],
                ],
                "opened" => [
                    "state" => [0,1],
                ],
                "active" => [
                    "state" => [0,1],
                ]
            ]),
        ]);
    }
}
