<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComunasTable extends Migration
{

    public function up()
    {
        Schema::create('comunas', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('nombre');
            $table->unsignedInteger('region_id')->unsigned();
            $table->timestamps();

            $table->foreign('region_id')->references('id')->on('regiones')
            ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('comunas');
    }
}
