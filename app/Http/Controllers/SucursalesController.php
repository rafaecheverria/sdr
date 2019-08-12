<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\crearSucursal;
use App\Empresa;
use App\Sucursal;

class SucursalesController extends Controller
{
    public function selectSucursal(Request $request, $id)
    {
       if (!$request->ajax()) return redirect('/');

        $sucursal = Sucursal::join("comunas", "sucursales.comuna_id", "=", "comunas.id")
        ->join("empresas", "sucursales.empresa_id", "=", "empresas.id")
        ->select("sucursales.id", "sucursales.direccion", "comunas.nombre as ciudad", "empresas.nombre as empresa")
        ->where("empresa_id", "=", $id)->get();

        $cargo = Empresa::findOrFail($id)->cargos()->where("empresa_id", "=", $id)->get();

  
        return[
            'sucursales' => $sucursal,
            'cargos' => $cargo
        
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $sucursal = new Sucursal();
        $sucursal->direccion = $request->direccion;
        $sucursal->comuna_id = $request->comuna_id;
        $sucursal->empresa_id = $request->empresa_id;
        $sucursal->save();

        return[
            'direccion' => $sucursal->direccion,
        ];
    }

}
