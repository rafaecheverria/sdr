<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    protected $table = "nivel_educacional";

    protected $fillable = [

        'id', 'nombre'
    ];

    public function empresas()

    {
        return $this->belongsToMany('App\Empresa');

    }


}
