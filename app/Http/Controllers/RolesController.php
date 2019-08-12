<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{

    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar == ''){
            $roles = Role::orderBy('id', 'DESC')->paginate(10);
        }else{
            $roles = Role::where($criterio, 'like', '%' . $buscar . '%')->orderBy('id', 'DESC')->paginate(10);
        }
    
        return [
            'pagination' => [
                'total'        => $roles->total(),
                'current_page' => $roles->currentPage(),
                'per_page'     => $roles->perPage(),
                'last_page'    => $roles->lastPage(),
                'from'         => $roles->firstItem(),
                'to'           => $roles->lastItem(),
            ],
            'roles' => $roles
        ];
    }

    public function AgregarPermisosRol(Request $request, $id)
    {
        if (!$request->ajax()) return redirect('/');
        $rol = Role::findOrFail($id);
        $rol->syncPermissions($request->permisos);
        $rol->save();
        
        return[
            'mensage' => "Se agregaron permisos exitosamente!",
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $rol = new Role();
        $rol->name = $request->nombre;
        $rol->save();
    
        return[
            'nombre' => $rol->name,
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

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $roles = Role::findOrFail($request->id);
        $roles->name = $request->nombre;
        $roles->save();

        return[
            'nombre' => $roles->name,
        ];
    }

    public function destroy($id)
    {
        //
    }
}
