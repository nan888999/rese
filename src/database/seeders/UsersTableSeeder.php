<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\facades\DB;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $param = [
            'name' => 'Admin',
            'email' => 'admin@test',
            'password' => bcrypt('password'),
            'role' => 1,
            'email_verified' => 9,
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => 'Shop Manager',
            'email' => 'shop@test',
            'password' => bcrypt('password'),
            'role' => 2,
            'email_verified' => 9,
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => 'User',
            'email' => 'user@test',
            'password' => bcrypt('password'),
            'role' => 3,
            'email_verified' => 9,
        ];
        DB::table('users')->insert($param);

        User::factory()->count(10)->create();
    }
}
