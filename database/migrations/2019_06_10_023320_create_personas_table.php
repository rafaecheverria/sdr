<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonasTable extends Migration
{
    public function up()
    {
        // Schema::create('personas', function (Blueprint $table) {
        //     $table->Increments('id');
        //     $table->string('rut');
        //     $table->string('nombres')->nullable();
        //     $table->string('apellidos')->nullable();
        //     $table->string('email')->nullable();
        //     $table->date('fecha_nacimiento')->nullable();
        //     $table->string('direccion')->nullable();
        //     $table->string('genero')->nullable();
        //     $table->string('discapacidad')->nullable();
        //     $table->string('licencia')->nullable();
        //     $table->string('movilidad')->nullable();
        //     $table->string('pais');
        //     $table->string('region')->nullable();
        //     $table->timestamps();
        // });
    }

    public function down()
    {
        // Schema::dropIfExists('personas');
    }
}
