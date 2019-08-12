<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnVacantesTable extends Migration
{
    public function up()
    {
      Schema::table('vacantes', function (Blueprint $table) {
         $table->unsignedInteger('sucursal_id')->unsigned();
         $table->string('estado')->nullable();
         $table->string('descripcion', 2000)->nullable();

         $table->foreign('sucursal_id')->references('id')->on('sucursales')
         ->onUpdate('cascade')->onDelete('cascade');

     });
    }

    public function down()
    {
      Schema::table('vacantes', function (Blueprint $table) {
         $table->dropColumn('sucursal_id');
         $table->dropColumn('estado');
     });
    }
}