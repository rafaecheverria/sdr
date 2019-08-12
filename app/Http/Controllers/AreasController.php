<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Area;

class AreasController extends Controller
{
    public function selectArea()
    {
        $area = Area::select('id', 'nombre')->orderBy('id', 'ASC')->get();

        return['areas' => $area];

    }
}
