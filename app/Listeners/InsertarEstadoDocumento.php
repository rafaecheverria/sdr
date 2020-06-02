<?php

namespace App\Listeners;

use App\Events\CrearDocumento;
use App\Documento;
use App\Estado;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;

class InsertarEstadoDocumento
{
    public function handle(CrearDocumento $event)
    {

        $insertar_documento_estado = $event->documento->estados()
                                                      ->attach(
                                                      $event->estado,
                                                      ['origen_id' => $event->origen,
                                                       'destino_id' => $event->destino,
                                                       'proveido' => $event->proveido ,
                                                       'fecha_creado' => Carbon::now(),
                                                       'fecha_actualizado' => Carbon::now()]);
    
    }
}