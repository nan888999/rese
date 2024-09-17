<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => 'イタリアン',
        ];
        DB::table('categories')->insert($param);

        $param = [
            'name' => 'ラーメン',
        ];
        DB::table('categories')->insert($param);

        $param = [
            'name' => '居酒屋',
        ];
        DB::table('categories')->insert($param);

        $param = [
            'name' => '寿司',
        ];
        DB::table('categories')->insert($param);

        $param = [
            'name' => '焼肉',
        ];
        DB::table('categories')->insert($param);
    }
}
