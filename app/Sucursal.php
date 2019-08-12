<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{

    protected $table = "sucursales";

	 protected $fillable = [

        'id', 'direccion', 'empresa_id', 'comuna_id'
    ];

    public function empresas()

    {
        return $this->hasOne('App\Empresa');

    }
}
