<?php

namespace App\Events;

use App\Documento;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CrearDocumento
{
    use Dispatchable, SerializesModels;

    public $documento;
    public $departamento;

    public function __construct(Documento $documento, $departamento, $estado, $origen, $destino, $proveido)
    {
        $this->documento = $documento;
        $this->departamento = $departamento;
        $this->estado = $estado;
        $this->origen = $origen;
        $this->destino = $destino;
        $this->proveido = $proveido;
    }

}
