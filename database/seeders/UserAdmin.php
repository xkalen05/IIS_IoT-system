<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserAdmin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'surname' => 'admin',
            'email' => 'admin@admin.cz',
            'password' => '$2y$12$76JpdVkucfzgKKiL2imu.O8fV1mt7X2uSBLUa23TaTocPa0zK1YIG',
            'role' => 'admin'
        ]);
    }
}
