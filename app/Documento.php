<?php

namespace App;

use App\Events\CrearDocumento;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;
use App\Estado;

class Documento extends Model
{
    protected $table = "documentos";
    protected $dates = ['fecha_documento'];

	 protected $fillable = [

        'id', 'remitente', 'fecha_documento', 'tipo_documento_id', 'creador', 'numero_documento', 'asunto', 'detalle', 'folio', 'archivo'
    ];

    public function estados()

    {

        return $this->belongsToMany('App\Estado', 'documento_estado', 'documento_id','estado_id', 'id')->withPivot('id', 'proveido', 'fecha_creado', 'fecha_actualizado', 'origen_id', 'destino_id')->orderBy("pivot_id", "DESC");

    }

    // public function getFecha_documentoAttribute($date)
    // {
    //     return new Date($date);
    // }

}
