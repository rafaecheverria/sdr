<?php

namespace App;

use Jenssegers\Date\Date;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Vacante;

class Vacante extends Model
{
    protected $table = "vacantes";

    protected $fillable = [

       'id', 'empresa_id', 'sucursal_id', 'cargo_id', 'descripcion', 'codigo', 'fecha_inicio', 'fecha_fin', 'estado', 'created_at'
   ];

    public static function traerVacantes(){
        $vacantes = Vacante::join("empresas", "vacantes.empresa_id", "=", "empresas.id")
                     ->join("cargos", "vacantes.cargo_id", "=", "cargos.id")
                     ->join("sucursales", "vacantes.sucursal_id", "=", "sucursales.id")
                     ->join("comunas", "sucursales.comuna_id", "=", "comunas.id")
                     ->join("regiones", "comunas.region_id", "=", "regiones.id")
                     ->join("categorias", "vacantes.categoria_id", "=", "categorias.id")
                     ->select("vacantes.id as id", "vacantes.preguntas_adicionales as preguntas", "vacantes.descripcion as descripcion", "vacantes.privacidad as privacidad", "vacantes.tipo_trabajo as tipo_trabajo",
                              "vacantes.duracion_trabajo as duracion_trabajo", "vacantes.created_at as fecha_creado", 
                              "vacantes.estado as estado", "vacantes.codigo as codigo", 
                              "empresas.nombre as empresa", "cargos.nombre as cargo", "sucursales.direccion as sucursal", 
                              "comunas.nombre as comuna", "regiones.nombre as region", "categorias.nombre as categoria");

        return $vacantes;

    }

}
