<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class TypeState extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('types')->insert([
            'name' => 'State (on/off)',
            'value' => json_encode([
                "state" => [
                    "isActive" => [0,1]
                ],
            ]),
        ]);
    }
}
