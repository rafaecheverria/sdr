<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaArchivadores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archivadores', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('archivador')->nullable();
            $table->string('periodo')->nullable();
            $table->unsignedInteger('departamento')->unsigned();
            $table->timestamps();

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
        Schema::dropIfExists('archivadores');
    }
}
