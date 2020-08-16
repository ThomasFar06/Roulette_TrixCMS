<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RouletteElements extends Migration
{
    public function up()
    {
        Schema::create('roulette__elements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('element_id');
            $table->integer('type');
            $table->integer('number');
            $table->string('title');
            $table->string('color');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('roulette__elements');
    }
}
