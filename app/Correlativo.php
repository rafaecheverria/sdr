<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Correlativo extends Model
{
    protected $table = "correlativos";

	 protected $fillable = [

        'id', 'tipo_documento', 'departamento', 'numero'
    ];
}
