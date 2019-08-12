<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = "empresas";

	 protected $fillable = [

        'id', 'nombre', 'email', 'rut', 'telefono', 'direccion', 'razon_social', 'representante'
    ];

    public function sucursales()

    {
        return $this->hasMany('App\Sucursal');

    }

    public function cargos()

    {
        return $this->belongsToMany('App\Cargo');

    }

    public function users()

    {
        return $this->belongsToMany('App\User');

    }
}
