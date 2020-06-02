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

class ActualizarDocumento
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $documento;
    public $estado;
    public $origen;
    public $destino; 

    public function __construct(Documento $documento, $estado, $origen, $destino, $destino_actual)
    {
        $this->documento = $documento;
        $this->estado = $estado;
        $this->origen = $origen;
        $this->destino = $destino;
        $this->destino_actual = $destino_actual;
    }

}
