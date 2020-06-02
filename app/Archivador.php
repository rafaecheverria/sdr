<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Archivador extends Model
{
    protected $table = "archivadores";

    protected $fillable = [

        'id', 'archivador', 'periodo', 'departamento'
    ];

    public function departamentos()

    {
        return $this->hasMany('App\Departamento');

    }
}
