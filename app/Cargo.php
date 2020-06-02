<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $table = "cargos";

	 protected $fillable = [

        'id', 'nombre'
    ];

    public function empresas()

    {
        return $this->belongsToMany('App\Empresa');

    }

    public function user()

    {
        return $this->HasMany('App\User');

    }
}
