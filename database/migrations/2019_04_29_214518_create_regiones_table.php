<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionesTable extends Migration
{
    public function up()
    {
        Schema::create('regiones', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('nombre');
            $table->unsignedInteger('pais_id')->unsigned();
            $table->timestamps();

            $table->foreign('pais_id')->references('id')->on('paises')
            ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('regiones');
    }
}
