<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExampleParameters extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('parameters')->insert([
            'result' => '1',
            'value' => '{"Battery(%)":42}',
            'kpi_id' => '1',
            'device_id' => '1',
            'type_id' => '3'
        ]);
        DB::table('parameters')->insert([
            'result' => '1',
            'value' => '{"state":1}',
            'kpi_id' => '2',
            'device_id' => '2',
            'type_id' => '10'
        ]);
        DB::table('parameters')->insert([
            'result' => '0',
            'value' => '{"temperature(\u00b0C)":42}',
            'kpi_id' => '3',
            'device_id' => '3',
            'type_id' => '11'
        ]);
        DB::table('parameters')->insert([
            'result' => '1',
            'value' => '{"Battery(%)":13}',
            'kpi_id' => '1',
            'device_id' => '2',
            'type_id' => '3'
        ]);
        DB::table('parameters')->insert([
            'result' => '1',
            'value' => '{"Battery(%)":2}',
            'kpi_id' => '1',
            'device_id' => '3',
            'type_id' => '3'
        ]);
    }
}
