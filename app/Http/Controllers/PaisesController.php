<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pais;

class PaisesController extends Controller
{
    public function selectPais()
    {
        $pais = Pais::select('id', 'nombre')->orderBy('id', 'ASC')->get();

        return['paises' => $pais];

    }

}
