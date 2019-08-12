<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->Increments('id');
            // $table->foreign('id')->references('id')->on('personas')->onUpdate('cascade')->onDelete('cascade');

            $table->string('rut');
            $table->string('nombres')->nullable();
            $table->string('apellidos')->nullable();
            $table->string('email')->unique();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('direccion')->nullable();
            $table->string('genero')->nullable();
            $table->string('discapacidad')->nullable();
            $table->string('licencia')->nullable();
            $table->string('movilidad')->nullable();
            $table->string('pais');
            $table->string('region')->nullable();
            $table->string('educacion', 5000)->nullable();
            $table->integer('porcentaje')->nullable();

            $table->string('password')->nullable();
            $table->integer('estado')->default(1);
            $table->boolean('confirmed')->default(0);
            $table->string('confirmation_code')->nullable();

            $table->timestamps();
 
            $table->rememberToken();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}