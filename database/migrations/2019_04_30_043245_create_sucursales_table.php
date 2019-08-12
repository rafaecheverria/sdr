<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSucursalesTable extends Migration
{
    public function up()
    {
        Schema::create('sucursales', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('direccion');
            $table->unsignedInteger('comuna_id')->unsigned();
            $table->unsignedInteger('empresa_id')->unsigned();
            $table->timestamps();

            $table->foreign('comuna_id')->references('id')->on('comunas')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('empresa_id')->references('id')->on('empresas')
            ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sucursales');
    }
}
