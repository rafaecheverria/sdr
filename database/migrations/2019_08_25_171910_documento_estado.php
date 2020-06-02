<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Carbon;

class DocumentoEstado extends Migration
{
    public function up()
    {
        Schema::create('documento_estado', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('proveido',1000)->nullable();
            $table->text('detalle')->nullable();
            $table->integer('documento_id')->unsigned();
            $table->integer('estado_id')->unsigned();
            $table->integer('origen_id')->unsigned();
            $table->integer('destino_id')->unsigned();

            $table->foreign('documento_id')->references('id')->on('documentos')
            ->onUpdate('cascade')->onDelete('cascade');
            
            $table->foreign('estado_id')->references('id')->on('estados')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('origen_id')->references('id')->on('departamentos')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('destino_id')->references('id')->on('departamentos')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->timestamp('fecha_creado')->nullable()->default(Carbon::now());
            $table->timestamp('fecha_actualizado')->nullable()->default(Carbon::now());
        });
    }

    public function down()
    {
        Schema::dropIfExists('documento_estado');
    }
}
