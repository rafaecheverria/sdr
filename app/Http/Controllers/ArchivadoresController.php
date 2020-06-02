<?php

namespace App\Http\Controllers;

use App\Archivador;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ArchivadoresController extends Controller
{

    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar == ''){
            $archivadores = Archivador::where("departamento", "=", Auth::user()->departamento_id)->orderBy('id', 'DESC')->paginate(10);
        }else{
            $archivadores = Archivador::where("departamento", "=", Auth::user()->departamento_id)->where($criterio, 'like', '%' . $buscar . '%')->orderBy('id', 'DESC')->paginate(10);
        }
    
        return [
            'pagination' => [
                'total'        => $archivadores->total(),
                'current_page' => $archivadores->currentPage(),
                'per_page'     => $archivadores->perPage(),
                'last_page'    => $archivadores->lastPage(),
                'from'         => $archivadores->firstItem(),
                'to'           => $archivadores->lastItem(),
            ],
            'archivadores' => $archivadores
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

            $archivador = new Archivador();
            $archivador->archivador = $request->archivador;
            $archivador->periodo = $request->periodo;
            $archivador->departamento = Auth::user()->departamento_id;
            $archivador->save();
        
        return[
            'archivador' => $archivador->archivador,
        ];
    }

    public function selectArchivador()
    {
        $archivador = Archivador::select('id', 'archivador')->where("departamento", "=", Auth::user()->departamento_id)->orderBy('archivador', 'DESC')->get();

        return['archivador' => $archivador];

    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $archivador = Archivador::findOrFail($request->id);
        $archivador->archivador = $request->archivador;
        $archivador->periodo = $request->periodo;
        $archivador->save();

        return[
            'archivador' => $archivador->archivador,
        ];
    }

    public function destroy($id)
    {
        // SE DEBE CODIFICAR ESTA FUNCIÓN
    }
}
