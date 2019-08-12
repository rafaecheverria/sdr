<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermisosController extends Controller
{

    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar == ''){
            $permisos = Permission::orderBy('id', 'DESC')->paginate(10);
        }else{
            $permisos = Permission::where($criterio, 'like', '%' . $buscar . '%')->orderBy('id', 'DESC')->paginate(10);
        }
    
        return [
            'pagination' => [
                'total'        => $permisos->total(),
                'current_page' => $permisos->currentPage(),
                'per_page'     => $permisos->perPage(),
                'last_page'    => $permisos->lastPage(),
                'from'         => $permisos->firstItem(),
                'to'           => $permisos->lastItem(),
            ],
            'permisos' => $permisos
        ];
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $permiso = new Permission();
        $permiso->name = $request->nombre;
        $permiso->save();
    
        return[
            'nombre' => $permiso->name,
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
    public function selectPermisos(Request $request, $id)
    {
        if (!$request->ajax()) return redirect('/');

        $los_permisos = Permission::select('id', 'name')->orderBy('name', 'ASC')->get();

        if($id != 0){

            $el_rol = Role::findOrFail($id);

            $el_permiso= Permission::orderBy('name', 'DESC')->pluck('name', 'id');

            $my_permisos = $el_rol->permissions->pluck('id')->ToArray();

        }
    
        return[

            'permisos' => $los_permisos,
            'my_permisos' => $my_permisos
        
        ];
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $permisos = Permission::findOrFail($request->id);
        $permisos->name = $request->nombre;
        $permisos->save();

        return[
            'nombre' => $permisos->name,
        ];
    }

    public function destroy($id)
    {
        //
    }
}
