<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePorstulantesTable extends Migration
{
    public function up()
    {
        Schema::create('postulantes', function (Blueprint $table) {
            $table->Integer('id')->unsigned();
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
            
            $table->string('salario');
            $table->string('experiencia_laboral');
            $table->string('educacion');
            $table->string('objetivo');
            $table->string('idiomas');
            $table->string('conocimientos_adicionales');
            $table->string('referencias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('postulantes');
    }
}
