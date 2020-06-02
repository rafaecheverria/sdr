<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Jenssegers\Date\Date;
use App\TipoDocumento;
use App\Documento;
use App\Departamento;
use App\Estado;
use App\Archivador;
use App\User;
use DB;
use App\Events\CrearDocumento;
use App\Events\ActualizarDocumento;
use App\Correlativo;
use Illuminate\Support\Facades\Auth;

class DocumentosController extends Controller
{

    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        $documentos = Documento::whereHas('estados', function ($query) {
        $query->where('origen_id', "=", Auth::user()->departamento_id)->orWhere("destino_id", "=", Auth::user()->departamento_id);
        })->join("estados", "documentos.estado_actual", "=", "estados.id")
        ->join("tipo_documentos", "documentos.tipo_documento_id", "=", "tipo_documentos.id")
        ->join("departamentos as origen", "documentos.origen", "=", "origen.id")
        ->join("departamentos as destino", "documentos.destino", "=", "destino.id")
        ->join("departamentos as destino_actual", "documentos.destino_actual", "=", "destino_actual.id")
        ->join("departamentos as origen_actual", "documentos.origen_actual", "=", "origen_actual.id")
        ->join("users", "documentos.remitente_id", "=", "users.id")
        ->join("cargos as cargo", "users.cargo_id", "=", "cargo.id")
        ->join("regiones as region_origen", "origen.region_id", "=", "region_origen.id")
        ->select("documentos.id as id", "documentos.asunto as asunto", "documentos.numero_documento as numero_documento",
                "users.nombres as remitente_nombres", "users.apellidos as remitente_apellidos", 
                "documentos.fecha_documento as fecha", "region_origen.nombre as region_origen",
                "documentos.creador as creador", "documentos.detalle as detalle",
                "estados.estado as estado", "origen.departamento as origen", "origen.id as origen_id",
                "destino.id as destino_id", "destino.departamento as destino",
                "destino_actual.id as destino_actual",  "origen_actual.id as origen_actual",
                "origen.sigla as osiglas", "destino.sigla as dsiglas", "cargo.nombre as cargo",
                "estados.id as estado_id", "tipo_documentos.tipo_documento as tipo")
        ->orderBy('id', 'DESC')->paginate(10);

        return [
            'pagination' => [
                'total'        => $documentos->total(),
                'current_page' => $documentos->currentPage(),
                'per_page'     => $documentos->perPage(),
                'last_page'    => $documentos->lastPage(),
                'from'         => $documentos->firstItem(),
                'to'           => $documentos->lastItem(),
            ],
            'documentos' => $documentos,
        ];
    }
 
    public function selectTipoDocumento(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
            //Obtiene todas las empresas
            $tipo_documento = TipoDocumento::select('id', 'tipo_documento')->orderBy('tipo_documento', 'ASC')->get();
            return['tipo_documento' => $tipo_documento];
    }


    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $departamento                 = Departamento::findOrFail(Auth::user()->departamento_id);
        $documento                    = new Documento();
        $documento->remitente_id      = $request->remitente; //GUARDA EL ID DEL REMITENTE DEL DOCUMENTO
        $documento->destinatario_id   = $request->destinatario;//GUARDA A LA PERSONA DE DESTINO DEL DOCUMENTO
        $documento->fecha_documento   = Date::parse($request->fecha_documento)->format('Y-m-d H:i:s');
        $documento->tipo_documento_id = $request->tipo_documento;
        $documento->numero_documento  = $request->numero_documento;
        $documento->asunto            = ucfirst(strtolower($request->asunto));
        $documento->detalle           = ucfirst(strtolower($request->detalle));
        $documento->folio             = $request->folios;
        $documento->archivo           = $request->archivo;
        $documento->origen            = Auth::user()->departamento_id;
        $documento->creador           = $departamento->id; //guarda el departamento que creó el documento.

        $documento->destino           = ($request->departamento > 0) ? $request->departamento : Auth::user()->departamento_id;
        $documento->destino_actual    = ($request->departamento > 0) ? $request->departamento : Auth::user()->departamento_id;
        $documento->origen_actual     = Auth::user()->departamento_id;
        $documento->estado_actual     = ($request->departamento > 0) ? 2 : 1; //si es 3 es porque esta derivando a un departamento, si es 1 no esta derivando
        $estado                       = ($request->departamento > 0) ? 2 : 1;
        $proveido                     = '--';

        $documento->save();
        
        CrearDocumento::dispatch($documento, Auth::user()->departamento_id, $estado, $documento->origen, $documento->destino, $proveido);

        return[
            'documento' => $documento,
        ];
    }

    public function correlativo($id)
    {
        $correlativo = Correlativo::select(["tipo_documento", "departamento", "numero"])
                                    ->where("tipo_documento", "=", $id)
                                    ->where("departamento", "=", Auth::user()->departamento_id)
                                    ->orderby("numero", "desc")->first();

        return [
            'correlativo' => $correlativo
        ];
    }

    public function recibir(Request $request, $id)
    {
        if (!$request->ajax()) return redirect('/');

        //SE BUSCA EL DOCUMENTO AL QUE SE LE HACE CLICK POR MEDIO DE SU ID
        $documento = Documento::findOrFail($id);

        //SE INICIALIZA LA VARIABLE DE ESTADO ACTUAL EN FALSO PARA TRABAJARLA DENTRO DE LA ITERACIÓN
        $estado_actual = false;

        //CONSULTAMOS EL ESTADO ACTUAL DEL DOCUMENTO CONSULTADO EN EL FINDORFAIL
        if($documento->estado_actual != 1){
            //NUESTRA VARIABLE LOCAL LA DEJAMOS EN TRUE PARA PODER TRABAJARLA DESDE VUE
            $estado_actual = true;

            //CAMBIAMOS EL ESTADO DEL DOCUMENTO Y GUARDAMOS LOS CAMBIOS
            $documento->estado_actual = 1;

            $documento->save();
    
            //OBTENEMOS LOS DATOS DEL DEPARTAMENTO DEL USUARIO ACTUAL PARA PODER SACAR EL NOMBRE Y MOSTRARLO EN EL PROVEIDO QUE DEJAREMOS POR DEFECTO EN LA SIGUIENTE LINEA.
            //ESTE PROVEIDO SOLO PUEDE SER MODIFICADO DESDE ESTE DOCUEMENTO
            $departamento = Departamento::findOrFail(Auth::user()->departamento_id);
    
            $proveido = "El documento fue recibido por ".$departamento->departamento;

            //CREAMOS UN REGISTRO EN LA TABLA PIVOTE DEL DOCUMENTO
            CrearDocumento::dispatch($documento, Auth::user()->departamento_id, $documento->estado_actual, $documento->origen_actual, Auth::user()->departamento_id, $proveido);

        }else{

            $estado_actual = false;
        }

        return[
            'estado' => $estado_actual,
        ];
    }

    public function derivar(Request $request, $id)
    {
        if (!$request->ajax()) return redirect('/');
            $documento                 = Documento::findOrFail($id);
            $documento->estado_actual  = 2; //2 es el estado por recibir
            $documento->destino_actual = $request->destino;
            $documento->origen_actual  =  Auth::user()->departamento_id;
            $documento->save();

        CrearDocumento::dispatch($documento, Auth::user()->departamento_id, $documento->estado_actual, Auth::user()->departamento_id, $documento->destino_actual, $request->proveido);

        return[
            'estado' => $documento->estado_actual,
        ];
    }

    public function archivar(Request $request, $id)
    {
        if (!$request->ajax()) return redirect('/');
        //CAMBIA EL ESTADO DEL DOCUMENTO A ARCHIVADO EN LA TABLA DOCUMENTO.
        $documento = Documento::findOrFail($id);
        $documento->estado_actual = 3; //3 ES EL ESTADO ARCHIVADO
        $documento->archivador_id = $request->archivador;
        $documento->save();

        CrearDocumento::dispatch($documento, Auth::user()->departamento_id, $documento->estado_actual, $documento->origen, $documento->destino, $request->proveido);

        return[
            'estado' => $documento->estado_actual,
        ];
    }

    public function desDerivar(Request $request, $id)
    {

        $documento = Documento::findOrFail($id);
        $depto_user = Auth::user()->departamento_id;

        //BUSCAMOS EL ULTMO REGISTRO DE LA TABLA DINAMICA DOCUMENTO_ESTADO PARA PODER ELIMINARLA.
        $sql = DB::table($documento->estados()->getTable());

        //CUENTA LOS REGISTROS QUE EXISTEN EN LA TABLA PIVOTE QUE PERTENECEN AL DOCUMENTO.
        $count = $sql->count();

        $last = $sql->orderBy('fecha_creado', 'desc')->first();

        //TRAE EL ULTIMO REGISTRO DEL DOCUMENTO EN LA TABLA PIVOTE.
        $consulta =  $sql->where('fecha_creado', '=', $last->fecha_creado);

        //INICIA EN FALSO EL ESTADO PARA VERIFICAR SI EL DOCUMENTO HA SIDO RECIBIDO POR EL DESTINATARIO.
        $estado_actual = false;

        //SI EL DESTINATARIO NO HA RECIBIDO EL DOCUMENTO PUEDE REALIZAR LA DES-DERIVACIÒN
        if($documento->estado_actual != 1 && $documento->estado_actual != 3){

            $estado_actual = true;

            //SI EL DOCUMENTO TIENE SOLO 1 REGISTRO EN LA TABLA PIVOTE, BORRA EL ULTIMO REGISTRO Y AGREGA OTRO NUEVO CON EL ESTADO EN PROCESO
            //CON EL ORIGEN Y EL DESTINO DEL DEPARTAMENTO QUE REALIZO LA DES-DERIVACIÒN.
            if ($count <= 1){

                $consulta->delete();
                CrearDocumento::dispatch($documento, $depto_user, 1, $depto_user, $depto_user, "--");
    
            }else{
                 //SI EL DOCUMENTO TIENE MAS DE 1 REGISTRO, ELIMINA EL ULTIMO REGISTRO INGRESADO PARA REALIZAR LA DES-DERIVACIÒN.
                $consulta->delete();
    
            }

            //ACTUALIZAMOS EL REGISTRO EN LA TABLA DOCUMENTO PARA QUE VUELVA A SU ESTADO ANTERIOR Y REALICE LA DES-DERIVACIÓN.            
            ActualizarDocumento::dispatch($documento, 1, $depto_user, $depto_user, $depto_user);

            
        }else{
             //SI EL DESTINATARIO HA RECIBIDO EL DOCUMENTO, LA DERIVACIÒN NO SE PUEDE EJECUTAR
            $estado_actual = false;

        }
        
        return [
            "estado" => $estado_actual,
        ];
        

    }

    public function desArchivar(Request $request, $id){

        //OBTIENE EL DOCUMENTO SELECCIONADO PARA DESARCHIVAR
        $documento = Documento::findOrFail($id);
       //ASIGNA A UNA VARIABLE EL DEPARTAMENTO DEL USUARIO EN SESION
        $depto_user = Auth::user()->departamento_id;
        
        //ACTUALIZA EL DOCUMENTO CON LOS DATOS DEL ULTIMO REGISTO DEL DOCUMENTO PARA SACARLO DEL ARCHIVADOR DIGITAL
        ActualizarDocumento::dispatch($documento, 1, $documento->origen, $documento->destino, $documento->destino_actual);

        CrearDocumento::dispatch($documento, $depto_user, 1, $depto_user, $depto_user, "El documento ha sido desarchivado");

        $documento->archivador_id = null;
        $documento->save();

    }

    public function verDocumento(Request $request, $id)
    {
        $archivador = "";
        $documento = Documento::join("tipo_documentos as tipo", "documentos.tipo_documento_id", "=", "tipo.id")
                                ->join("departamentos as depto", "documentos.creador", "=", "depto.id")
                                ->join("estados as estado","documentos.estado_actual", "=", "estado.id")
                                ->join('departamentos as origen', 'documentos.origen', '=', 'origen.id')
                                ->join('departamentos as destino', 'documentos.destino', '=', 'destino.id')
                                ->join('users as remitente', 'documentos.remitente_id', '=', 'remitente.id')
                                ->join('users as destinatario', 'documentos.destinatario_id', '=', 'destinatario.id')
                                ->select("documentos.id as id", "documentos.asunto as asunto", "documentos.detalle as detalle", 
                                        "tipo.tipo_documento as tipo", "remitente.nombres as remitente_nombres", "remitente.apellidos as remitente_apellidos",
                                        "destinatario.nombres as destinatario_nombres", "destinatario.apellidos as destinatario_apellidos", "depto.departamento as creador",
                                        "documentos.numero_documento as numero_documento", "estado.estado", 'origen.departamento as origen', 
                                        'destino.departamento as destino', "documentos.archivador_id", "documentos.fecha_documento as fecha_documento")
                                ->findOrFail($id);

        $documento_estados = $documento->estados()
                                        ->join('departamentos as origen', 'documento_estado.origen_id', '=', 'origen.id')
                                        ->join('departamentos as destino', 'documento_estado.destino_id', '=', 'destino.id')
                                        ->join('estados as estado', 'documento_estado.estado_id', '=', 'estado.id')
                                        ->select('documento_estado.id as id', 'estado.estado as estado', 'origen.departamento as origen', 
                                                 'destino.departamento as destino', 'proveido', 'estado.id as estado_id', 'documento_estado.fecha_creado as fecha_creado')
                                        ->get();

        $datos = $documento_estados->map(function($item, $key){
            return [
                'id'            => $item['id'],
                'fecha_creado'  => Date::parse($item['fecha_creado'])->format('j F Y'),
                'hora'          => Date::parse($item['fecha_creado'])->format('H:i'),
                'proveido'      => $item['proveido'],
                'origen'        => $item['origen'],
                'destino'       => $item['destino'],
                'estado'        => $item['estado'],
                'estado_id'     => $item['estado_id'],
            ];
         });

        //CONSULTA A LA BASE DE DATOS SI EL DOCUMENTO ESTA ARCHIVADO, SI NO ESTA ARCHIVADO SE MUESTRA UN STRING Y SI ESTA ARCHIVADO TRAE EL NOMBRE DEL ARCHIVADOR
        if($documento->archivador_id == null){
            $archivador = "El documento no está archivado";
        }else{
            $sql = Archivador::where("id", $documento->archivador_id)->get();
            $archivador = $sql[0]->archivador;
        }


        return response()->json([
            "datos" => $datos,
            "id" => $documento->id,
            "tipo" => $documento->tipo,
            "numero_documento" => $documento->numero_documento,
            "creador" => $documento->creador,
            "asunto" => $documento->asunto,
            "detalle" => strip_tags($documento->detalle),
            "estado" => $documento->estado,
            "fecha_documento" => Date::parse($documento['fecha_documento'])->format('j F Y'),
            "remitente" => $documento->remitente_nombres." ".$documento->remitente_apellidos,
            "destinatario" => $documento->destinatario_nombres.' '.$documento->destinatario_apellidos,
            "documento" => $documento,
            "archivador" => $archivador
        ]);
    }

    public function pdf(Request $request, $id){
        $documento = Documento::join("tipo_documentos as tipo", "documentos.tipo_documento_id", "=", "tipo.id")
                                ->join("departamentos as depto", "documentos.creador", "=", "depto.id")
                                ->join("estados as estado","documentos.estado_actual", "=", "estado.id")
                                ->join('departamentos as origen', 'documentos.origen', '=', 'origen.id')
                                ->join('departamentos as destino', 'documentos.destino', '=', 'destino.id')
                                ->join('users as destinatario', 'destinatario.id', '=', 'documentos.destinatario_id')
                                ->join('users as remitente', 'remitente.id', '=', 'documentos.remitente_id')
                                ->select("documentos.id as id", "documentos.asunto as asunto", "documentos.detalle as detalle", 
                                        "tipo.tipo_documento as tipo", "depto.departamento as creador",
                                        "documentos.numero_documento as numero_documento", "estado.estado", 
                                        "origen.id as origen_id", "origen.departamento as origen", 
                                        'destino.departamento as destino', "destino.id as destino_id","documentos.archivador_id", 
                                        "documentos.fecha_documento as fecha_documento", 
                                        "destinatario.nombres as destinatario_nombres", "destinatario.id as destinatario_id",
                                        "destinatario.apellidos as destinatario_apellidos",
                                        "remitente.nombres as remitente_nombres", "remitente.id as remitente_id",
                                        "remitente.apellidos as remitente_apellidos")
                                ->findOrFail($id);

        $cargo_remitente = User::findOrFail($documento["remitente_id"]);
        $cargo_destinatario = User::findOrFail($documento["destinatario_id"]);
        $region_depto_remitente = Departamento::findOrFail($documento["origen_id"]); 
        $region_depto_destinatario = Departamento::findOrFail($documento["destino_id"]); 

        $fecha  = Date::now()->toFormattedDateString();
        $pdf  = \PDF::loadView('pdf.documento', [
                                                 'fecha' => $fecha, 
                                                 'fecha_documento' => Date::parse($documento['fecha_documento'])->format('j F Y'), 
                                                 'remitente' => mb_strtoupper($documento["remitente_nombres"])." ".mb_strtoupper($documento["remitente_apellidos"]),
                                                 'asunto' => mb_strtoupper($documento["asunto"]),
                                                 'documento' => $documento,
                                                 'detalle' => $documento["detalle"],
                                                 'depto_destino' => mb_strtoupper($documento["destino"]),
                                                 'depto_origen' => mb_strtoupper($documento["origen"]),
                                                 'destinatario' => mb_strtoupper($documento["destinatario_nombres"])." ".mb_strtoupper($documento["destinatario_apellidos"]),
                                                 'cargo_remitente' => mb_strtoupper($cargo_remitente->cargo->nombre),
                                                 'cargo_destinatario' => mb_strtoupper($cargo_destinatario->cargo->nombre),
                                                 'region_depto_remitente' => mb_strtoupper($region_depto_remitente->region->nombre),
                                                 'region_depto_destinatario' => mb_strtoupper($region_depto_destinatario->region->nombre),
                                                ]);

        return $pdf->download($documento->tipo ." Nº ". $documento->numero_documento ." - ".$documento->creador.".pdf");
    }
}