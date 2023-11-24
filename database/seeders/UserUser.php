<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'user',
            'surname' => 'user',
            'email' => 'user@user.cz',
            'password' => '$2y$12$76JpdVkucfzgKKiL2imu.O8fV1mt7X2uSBLUa23TaTocPa0zK1YIG',
            'role' => 'basic_user'
        ]);
    }
}
