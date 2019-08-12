<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('nombre');
            $table->string('razon_social');
            $table->string('rut');
            $table->string('direccion');
            $table->string('telefono');
            $table->string('email');
            $table->string('representante')->nullable();
            $table->string('sucursales')->nullable(); //Json con todas las sucursales
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresas');
    }
}
