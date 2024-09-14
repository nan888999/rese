<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('area')->comment('地域:1=東京都, 2=大阪府, 3=福岡県');
            $table->tinyInteger('category')->comment('ジャンル:1=イタリアン, 2=ラーメン, 3=居酒屋, 4=寿司, 5=焼肉');
            $table->text('detail', 200);
            $table->string('img_url');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shops');
    }
}
