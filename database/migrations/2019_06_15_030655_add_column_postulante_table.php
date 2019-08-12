<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnPostulanteTable extends Migration
{
    public function up()
    {
        Schema::table('postulantes', function (Blueprint $table) {
            $table->string('perfil_cognitivo')->nullable();
            $table->string('perfil_laboral')->nullable();
        });
    }

    public function down()
    {
        Schema::table('postulantes', function (Blueprint $table) {
            $table->dropColumn('perfil_cognitivo');
            $table->dropColumn('perfil_laboral');
        });
    }
}
