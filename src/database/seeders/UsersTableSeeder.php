<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\facades\DB;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $param = [
            'name' => 'Manager',
            'email' => 'manager@test',
            'password' => bcrypt('password'),
            'role' => 1,
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => 'Shop',
            'email' => 'shop@test',
            'password' => bcrypt('password'),
            'role' => 2,
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => 'User',
            'email' => 'user@test',
            'password' => bcrypt('password'),
            'role' => 3,
        ];
        DB::table('users')->insert($param);
    }
}
