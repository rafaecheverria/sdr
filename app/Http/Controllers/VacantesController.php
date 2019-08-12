<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dirape\Token\Token;
use App\Vacante;
use Jenssegers\Date\Date;
use Carbon\Carbon;

class VacantesController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        $sql = Vacante::traerVacantes();


        if($buscar == ''){

           $vacantes = $sql->orderBy('vacantes.id', 'DESC')->paginate(4);

        }else{

            $vacantes = $sql->where($criterio, 'like', '%' . $buscar . '%')->orderBy('vacantes.id', 'DESC')->paginate(4);

        }
        
        return [
            'pagination' => [
                'total'        => $vacantes->total(),
                'current_page' => $vacantes->currentPage(),
                'per_page'     => $vacantes->perPage(),
                'last_page'    => $vacantes->lastPage(),
                'from'         => $vacantes->firstItem(),
                'to'           => $vacantes->lastItem(),
            ],
            'vacantes' => $vacantes,
        ];
    } 

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        //    $preguntas_adicionales = json_decode(json_encode($request->preguntas_adicionales),true);

            $vacante = new Vacante();
            $vacante->empresa_id = $request->empresa_id;
            $vacante->sucursal_id = $request->sucursal_id;
            $vacante->cargo_id = $request->cargo_id;
            $vacante->descripcion = $request->descripcion;
            $vacante->categoria_id = $request->categoria_id;
            $vacante->tipo_trabajo = $request->tipo_trabajo;
            $vacante->duracion_trabajo = $request->duracion_trabajo;
            $vacante->codigo = (new Token())->Unique('vacantes', 'codigo', 10);
            $privacidad = ($request->privacidad == true) ? 'si' : 'no';
            $vacante->privacidad = $privacidad;
            $vacante->preguntas_adicionales = $request->preguntas_adicionales;
            $vacante->estado = "Vigente";
            $vacante->save();

        return[
            // 'preguntas' => $request->preguntas_adicionales,
        ]; 
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
