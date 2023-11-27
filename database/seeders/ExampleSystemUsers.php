<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExampleSystemUsers extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('system_users')->insert([
            'system_id' => '1',
            'user_id' => '1'
        ]);
        DB::table('system_users')->insert([
            'system_id' => '2',
            'user_id' => '1'
        ]);
        DB::table('system_users')->insert([
            'system_id' => '3',
            'user_id' => '1'
        ]);
    }
}
