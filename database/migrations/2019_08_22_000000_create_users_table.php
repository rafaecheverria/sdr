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
            $table->string('rut');
            $table->string('nombres')->nullable();
            $table->string('apellidos')->nullable();
            $table->string('email')->unique();
            $table->date('fecha_nacimiento')->nullable();
            $table->date('vigencia')->nullable();
            $table->string('direccion')->nullable();
            $table->string('genero')->nullable();
            $table->string('nacionalidad')->nullable();
            $table->string('telefono')->nullable();
            $table->string('celular')->nullable();
            $table->string('anexo')->nullable();
            $table->string('pais');
            $table->string('region')->nullable();
            $table->string('password')->nullable();
            $table->integer('estado')->default(1);
            $table->integer('representante')->default(0);
            $table->unsignedInteger('cargo_id')->unsigned();
            $table->unsignedInteger('departamento_id')->unsigned();

            $table->timestamps();
            $table->rememberToken();

            $table->foreign('cargo_id')->references('id')->on('cargos')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('departamento_id')->references('id')->on('departamentos')
            ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}