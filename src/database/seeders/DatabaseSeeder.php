<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(AreasTableSeeder::class);

        $this->call(CategoriesTableSeeder::class);

        $this->call(ShopsTableSeeder::class);
    }
}
