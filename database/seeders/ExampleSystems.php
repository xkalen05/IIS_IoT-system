<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExampleSystems extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('systems')->insert([
            'name' => 'Example_System_OK',
            'description' => 'This is an example system with OK state!',
            'result' => '1',
            'system_admin_id' => '1'
        ]);
        DB::table('systems')->insert([
            'name' => 'Example_System_ERROR',
            'description' => 'This is an example system with ERROR state!',
            'result' => '0',
            'system_admin_id' => '1'
        ]);
        DB::table('systems')->insert([
            'name' => 'Example_System_No_Devices',
            'description' => 'This is an example system without any devices!',
            'result' => '0',
            'system_admin_id' => '1'
        ]);
    }
}
