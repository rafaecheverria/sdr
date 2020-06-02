<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Departamento;
use App\User;
use Illuminate\Support\Facades\Auth;

class DepartamentosController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar == ''){
            $departamentos = Departamento::where("estado", "=", 1)
                                        ->orderBy('id', 'DESC')
                                        ->paginate(10);
        }else{
            $departamentos = Departamento::where($criterio, 'like', '%' . $buscar . '%')
                                        ->where("estado", "=", 1)
                                        ->orderBy('id', 'DESC')
                                        ->paginate(10);
        }
    
        return [
            'pagination' => [
                'total'        => $departamentos->total(),
                'current_page' => $departamentos->currentPage(),
                'per_page'     => $departamentos->perPage(),
                'last_page'    => $departamentos->lastPage(),
                'from'         => $departamentos->firstItem(),
                'to'           => $departamentos->lastItem(),
            ],
            'departamentos' => $departamentos
        ];
    }  

    public function selectDepartamento(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

            $departamento = Departamento::findOrFail(Auth::user()->departamento_id);

            // trae todos los departamentos menos los del user actual
            $departamentos = Departamento::select("id","departamento", "region_id")
                                        ->where("id", "!=", $departamento->id)
                                        ->where("region_id", "=" ,$departamento->region_id)
                                        ->orderBy('departamento', 'ASC')
                                        ->get();

        return['departamentos' => $departamentos];
    }

    public function selectDepartamentoReg(Request $request, $id)
    {
        $departamento = Departamento::select('id', 'departamento')
                                    ->where("region_id", "=", $id)
                                    ->orderBy('departamento', 'ASC')
                                    ->get();

        return['departamentos' => $departamento];

    }

    public function selectDepartamentoCopiar(Request $request, $id)
    {
        if (!$request->ajax()) return redirect('/');

            //Obtiene todas las empresas
            $copiar = Departamento::select('id', 'departamento')
                                    ->where("id", "!=", $id)
                                    ->orderBy('departamento', 'ASC')
                                    ->get();

            return['copiar' => $copiar];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $departamento = new Departamento();
        $departamento->departamento = $request->departamento;
        $departamento->abreviado = $request->abreviado;
        $departamento->sigla = $request->sigla;
        $departamento->save();

        return[
            'departamento' => $departamento->departamento,
        ];
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $departamento = Departamento::findOrFail($request->id);
        $departamento->departamento = $request->departamento;
        $departamento->abreviado = $request->abreviado;
        $departamento->sigla = $request->sigla;
        $departamento->save();

        return[
            'departamento' => $departamento->departamento,
        ];
    }
}
