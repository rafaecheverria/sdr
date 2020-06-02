<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $fillable = [
        'id', 'estado'
    ];

    public function documentos()

    {

        return $this->belongsToMany('App\Documento', 'documento_estado', 'documento_id','estado_id')->withPivot('proveido', 'origen_id', 'fecha_creado', 'fecha_actualizado', 'origen_id', 'destino_id');

    }
}
