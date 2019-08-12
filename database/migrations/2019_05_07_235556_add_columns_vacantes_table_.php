<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsVacantesTable extends Migration
{

    public function up()
    {
        Schema::table('vacantes', function (Blueprint $table) {
            $table->unsignedInteger('categoria_id')->unsigned();
            $table->string('privacidad')->nullable();
            $table->string('tipo_trabajo')->nullable();
            $table->string('duracion_trabajo')->nullable();
            $table->string('salario')->nullable();
            $table->string('preguntas_adicionales', 5000)->nullable();

            $table->foreign('categoria_id')->references('id')->on('categorias')
            ->onUpdate('cascade')->onDelete('cascade');
   
        });
    }

    public function down()
    {
        Schema::table('vacantes', function (Blueprint $table) {
            $table->dropColumn('categoria_id');
            $table->dropColumn('privacidad');
            $table->dropColumn('tipo_trabajo');
            $table->dropColumn('duracion_trabajo');
            $table->dropColumn('salario');
            $table->dropColumn('preguntas_adicionales');
        });
    }
}
