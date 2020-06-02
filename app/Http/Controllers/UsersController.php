<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Empresa;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $tipo = $request->tipo;

        $usuarios = ($tipo!='') ? User::traerUsuariosSegunRol($tipo, $buscar, $criterio) : User::traerTodosUsuarios($buscar, $criterio);
    
        return [
            'pagination' => [
                'total'        => $usuarios->total(),
                'current_page' => $usuarios->currentPage(),
                'per_page'     => $usuarios->perPage(),
                'last_page'    => $usuarios->lastPage(),
                'from'         => $usuarios->firstItem(),
                'to'           => $usuarios->lastItem(),
            ],
            'usuarios' => $usuarios
        ];
    } 
    
    public function selectRoles(Request $request, $id)
    {
        if (!$request->ajax()) return redirect('/');

        $los_roles = Role::select('id', 'name')->orderBy('name', 'ASC')->get();

        if($id != 0){

            $el_user = User::findOrFail($id);

            $el_rol = Role::orderBy('name', 'DESC')->pluck('name', 'id');

            $my_roles = $el_user->roles->pluck('id')->ToArray();

        }
    
        return[

            'roles' => $los_roles,
            'my_roles' => $my_roles
        
        ];
    }

    public function selectUsuarioDepto(Request $request, $id)
    {
        $destinatarios = User::join("cargos", "cargos.id", "=", "users.cargo_id")
                            ->select("users.id", "users.nombres", "users.apellidos", "cargos.nombre as cargo")
                            ->where("departamento_id", "=", $id)->orderBy("cargo_id", "ASC")->get();

        return['destinatarios' => $destinatarios];

    }

    public function selectEmpresas(Request $request, $id)
    {
        if (!$request->ajax()) return redirect('/');

        $las_empresas = Empresa::select('id', 'nombre')->orderBy('nombre', 'ASC')->get();

        if($id != 0){

            $el_user = User::findOrFail($id);

            $la_empresa = Empresa::orderBy('nombre', 'DESC')->pluck('nombre', 'id');

            $my_empresas = $el_user->empresas->pluck('id')->ToArray();

        }
    
        return[

            'empresas' => $las_empresas,
            'my_empresas' => $my_empresas
        
        ];
    }

    public function AgregarRolesUsuario(Request $request, $id)
    {
        if (!$request->ajax()) return redirect('/');
        $user = User::findOrFail($id);
        $user->syncRoles($request->roles);
        $user->save();
        
        return[
            'mensage' => "Se agregaron los roles exitosamente!",
        ];
    }

    public function AgregarEmpresasUsuario(Request $request, $id)
    {
        if (!$request->ajax()) return redirect('/');
        $user = User::findOrFail($id);
        $user->empresas()->sync($request->empresas); 

        $user->save();
        
        return[
            'mensage' => "Se agregaron los empresas exitosamente!",
        ];
    }

    public function selectRemitente(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

                //  TRAR A TODOS LOS USUARIOS QUE PERTENECEN AL DEPARTAMENTO DEL USUARIO EN SESIÓN.
                $remitente = User::select('id', 'nombres', 'apellidos')->where("departamento_id", Auth::user()->departamento_id)->where("estado",1)->get();  
    
        return['remitente' => $remitente];
    }
}
