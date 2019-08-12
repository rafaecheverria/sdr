<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostulanteVacanteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postulante_vacante', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('codigo');
            $table->string('video');
            $table->string('estado');
            $table->unsignedInteger('postulante_id')->unsigned();
            $table->unsignedInteger('vacante_id')->unsigned();
            $table->timestamps();

            $table->foreign('postulante_id')->references('id')->on('postulantes')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('vacante_id')->references('id')->on('vacantes')
            ->onUpdate('cascade')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('postulante_vacante');
    }
}
