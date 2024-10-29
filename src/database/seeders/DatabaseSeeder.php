<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            AreasTableSeeder::class,
            CategoriesTableSeeder::class,
            ShopsTableSeeder::class,
            ReservationsTableSeeder::class,
        ]);
    }
}