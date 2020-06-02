<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Region;
use App\Departamento;
use Illuminate\Support\Facades\Auth;

class RegionesController extends Controller
{
 
    public function selectRegion()
    {
        $depto_user = Departamento::findOrFail(Auth::user()->departamento_id);
        $region = Region::select('id', 'nombre')->where("id", "!=", $depto_user->region_id)->orderBy('nombre', 'ASC')->get();

        return['regiones' => $region,
                
            ];

    }

}
