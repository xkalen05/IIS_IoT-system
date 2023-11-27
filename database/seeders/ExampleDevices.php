<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExampleDevices extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('devices')->insert([
            'name' => 'Example_Device_01',
            'description' => 'This is an example device 01!',
            'alias' => 'Device_01',
            'result' => '1',
            'system_id' => '1',
            'user_id' => '1'
        ]);
        DB::table('devices')->insert([
            'name' => 'Example_Device_02',
            'description' => 'This is an example device 02!',
            'alias' => 'Device_02',
            'result' => '1',
            'system_id' => '2',
            'user_id' => '1'
        ]);
        DB::table('devices')->insert([
            'name' => 'Example_Device_03',
            'description' => 'This is an example device 03!',
            'alias' => 'Device_03',
            'result' => '0',
            'system_id' => '2',
            'user_id' => '1'
        ]);
    }
}
