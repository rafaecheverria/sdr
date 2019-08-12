<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Region;

class RegionesController extends Controller
{
 
    public function selectRegion()
    {
        $region = Region::select('id', 'nombre')->orderBy('nombre', 'ASC')->get();

        return['regiones' => $region];

    }

}
