<?php

namespace App\Listeners;

use App\Events\ActualizarDocumento;
use App\Documento;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateDocumento
{

    public function handle(ActualizarDocumento $event)
    {

        $documento = Documento::findOrFail($event->documento->id);
        
        $documento->estado_actual = $event->estado;
        $documento->origen = $event->origen;
        $documento->destino = $event->destino;
        $documento->destino_actual = $event->destino_actual;

        $documento->save();
    }
    
}
