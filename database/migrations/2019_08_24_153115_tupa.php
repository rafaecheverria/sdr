<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tupa extends Migration
{
    public function up()
    {
        Schema::create('tupa', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('proceso')->nullable();
            $table->string('requisitos')->nullable();
            $table->string('plazo')->nullable(); //indica el plazo en dias donde se debe atender el proceso.
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tupa');
    }
}
