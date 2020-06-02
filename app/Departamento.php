<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = "departamentos";

	 protected $fillable = [

        'id', 'departamento', 'abreviado', 'sigla', 'region_id'
    ];

    public function user()

    {
        return $this->HasMany('App\Users');

    }

    public function region()

    {
        return $this->belongsTo('App\Region');

    }

}
