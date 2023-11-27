<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExampleKPIs extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kpis')->insert([
            'name' => 'Example_Battery_KPI',
            'value' => '{"Battery(%)":{"MinimalValue":1,"MaximalValue":100}}',
            'user_id' => '1',
            'type_id' => '3'
        ]);
        DB::table('kpis')->insert([
            'name' => 'Example_State_KPI',
            'value' => '{"state":{"isActive":1}}',
            'user_id' => '1',
            'type_id' => '10'
        ]);
        DB::table('kpis')->insert([
            'name' => 'Example_Temperature_KPI',
            'value' => '{"temperature(\u00b0C)":{"MinimalValue":20,"MaximalValue":27}}',
            'user_id' => '1',
            'type_id' => '11'
        ]);
    }
}
