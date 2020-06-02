<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorrelativosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('correlativos', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('departamento')->unsigned();
            $table->unsignedInteger('tipo_documento')->unsigned();
            $table->string('numero')->nullable();
            $table->string('periodo')->nullable();
            $table->timestamps();

            $table->foreign('tipo_documento')->references('id')->on('tipo_documentos')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('departamento')->references('id')->on('departamentos')
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
        Schema::dropIfExists('correlativos');
    }
}
