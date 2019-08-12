<?php

namespace App\Http\Controllers\Empresa;

use Illuminate\Http\Request;
use App\Http\Requests\crearEmpresaRequest;
use App\Http\Requests\actualizarEmpresaRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Empresa;
use App\User;
use Illuminate\Support\Facades\Auth;


class EmpresasController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar == ''){
            $empresas = Empresa::orderBy('id', 'DESC')->paginate(10);
        }else{
            $empresas = Empresa::where($criterio, 'like', '%' . $buscar . '%')->orderBy('id', 'DESC')->paginate(10);
        }
    
        return [
            'pagination' => [
                'total'        => $empresas->total(),
                'current_page' => $empresas->currentPage(),
                'per_page'     => $empresas->perPage(),
                'last_page'    => $empresas->lastPage(),
                'from'         => $empresas->firstItem(),
                'to'           => $empresas->lastItem(),
            ],
            'empresas' => $empresas
        ];
    }  

    public function selectEmpresa(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

            if(Auth::user()->hasRole('Administrador')){

                //Obtiene todas las empresas
                $empresa = Empresa::select('id', 'nombre')->orderBy('nombre', 'ASC')->get();

            }else{
                //Obtiene todas las empresas que estan asociadas al usuario en sesion
                $empresa = User::findOrFail(Auth::id())->empresas;

            }
    
        return['empresas' => $empresa];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $empresa = new Empresa();
        $empresa->rut = $request->rut;
        $empresa->nombre = $request->nombre;
        $empresa->email = $request->email;
        $empresa->telefono = $request->telefono;
        $empresa->razon_social = $request->razon_social;
        $empresa->direccion = $request->direccion;
        $empresa->save();

        return[
            'nombre' => $empresa->nombre,
        ];
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $empresa = Empresa::findOrFail($request->id);
        $empresa->nombre = $request->nombre;
        $empresa->email = $request->email;
        $empresa->telefono = $request->telefono;
        $empresa->razon_social = $request->razon_social;
        $empresa->direccion = $request->direccion;
        $empresa->save();

        return[
            'nombre' => $empresa->nombre,
        ];
    }
}
