<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comuna;

class ComunasController extends Controller
{
    public function selectComuna(Request $request, $id)
    {
        $comuna = Comuna::select('id', 'nombre')->where("region_id", "=", $id)->orderBy('nombre', 'ASC')->get();

        return['comunas' => $comuna];

    }
}
