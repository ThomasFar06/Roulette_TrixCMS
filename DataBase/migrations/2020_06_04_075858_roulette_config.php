<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RouletteConfig extends Migration
{
    public function up()
    {
        Schema::create('roulette__config', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('elements');
            $table->integer('price');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('roulette__config');
    }
}
