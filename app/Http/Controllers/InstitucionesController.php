<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Institucion;

class InstitucionesController extends Controller
{
    public function selectInstitucion()
    {
        $institucion = Institucion::select('id', 'nombre')->orderBy('id', 'ASC')->get();

        return['instituciones' => $institucion];

    }
}
