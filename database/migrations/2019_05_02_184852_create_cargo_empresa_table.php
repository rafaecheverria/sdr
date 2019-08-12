<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCargoEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cargo_empresa', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('empresa_id')->unsigned();
            $table->unsignedInteger('cargo_id')->unsigned();

            $table->foreign('empresa_id')->references('id')->on('empresas')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('cargo_id')->references('id')->on('cargos')
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
        Schema::dropIfExists('cargo_empresa');
    }
}
