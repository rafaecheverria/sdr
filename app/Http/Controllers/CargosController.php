<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\crearCargoRequest;
use App\Cargo;
use App\Empresa;

class CargosController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar == ''){
            $cargos = Cargo::orderBy('id', 'DESC')->paginate(10);
        }else{
            $cargos = Cargo::where($criterio, 'like', '%' . $buscar . '%')->orderBy('id', 'DESC')->paginate(10);
        }
    
        return [
            'pagination' => [
                'total'        => $cargos->total(),
                'current_page' => $cargos->currentPage(),
                'per_page'     => $cargos->perPage(),
                'last_page'    => $cargos->lastPage(),
                'from'         => $cargos->firstItem(),
                'to'           => $cargos->lastItem(),
            ],
            'cargos' => $cargos
        ];
    }  

    public function selectCargo(Request $request, $id)
    {
        if (!$request->ajax()) return redirect('/');

        $los_cargos = Cargo::select('id', 'nombre')->orderBy('nombre', 'ASC')->get();

        if($id != 0){

            $la_empresa = Empresa::findOrFail($id);

            $el_cargo = Cargo::orderBy('nombre', 'DESC')->pluck('nombre', 'id');

            $my_cargos = $la_empresa->cargos->pluck('id')->ToArray();

        }
    
        return[

            'cargos' => $los_cargos,
            'my_cargos' => $my_cargos
        
        ];
    }

    public function AgregarCargosEmpresa(Request $request, $id)
    {
        if (!$request->ajax()) return redirect('/');
        $empresa = Empresa::findOrFail($id);
        $empresa->cargos()->sync($request->cargos); 
        $empresa->save();

        return[
            'mensage' => "Se agregaron los cargos exitosamente!",
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

            $cargo = new Cargo();
            $cargo->nombre = $request->nombre;
            $cargo->save();
        
        return[
            'nombre' => $cargo->nombre,
        ];
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $cargos = Cargo::findOrFail($request->id);
        $cargos->nombre = $request->nombre;
        $cargos->save();

        return[
            'nombre' => $cargos->nombre,
        ];
    }
}
