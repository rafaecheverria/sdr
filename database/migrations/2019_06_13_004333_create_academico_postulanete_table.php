<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcademicoPostulaneteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academico_postulante', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('postulante_id')->unsigned();
            $table->unsignedInteger('academico_id')->unsigned();
            $table->timestamps();

            $table->foreign('postulante_id')->references('id')->on('postulantes')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('academico_id')->references('id')->on('academicos')
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
        Schema::dropIfExists('academico_postulante');
    }
}
