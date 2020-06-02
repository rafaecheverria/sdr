<?php

namespace App\Listeners;


use App\Events\CrearDocumento;
use App\Correlativo;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CrearNumeroCorrelativo
{

    public function handle(CrearDocumento $event)
    {
        //    dd($event->departamento);

           $correlativo = new Correlativo();
           $correlativo->tipo_documento = $event->documento->tipo_documento_id;
           $correlativo->departamento = $event->departamento;
           $correlativo->numero = $event->documento->numero_documento;

           $correlativo->save();

    
    }
}
