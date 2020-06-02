<?php

namespace App;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    public $timestamps = false;

    protected $fillable = [
        'nombres', 'apellidos', 'email', 'rut', 'departamento_id', 'cargo_id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function departamento()

    {
        return $this->belongsTo('App\Departamento');

    }

    public static function traerUsuariosSegunRol($tipo, $buscar, $criterio){

        if($buscar == ''){
            $usuarios = User::whereHas("roles", function($q) use ($tipo){ $q->where("name", $tipo); })->orderBy('id', 'DESC')->paginate(10);
        }else{
            $usuarios = User::whereHas("roles", function($q) use ($tipo){ $q->where("name", $tipo); })->where($criterio, 'like', '%' . $buscar . '%')->orderBy('id', 'DESC')->paginate(10);
        }

        return $usuarios;

    }

    public static function traerTodosUsuarios($buscar, $criterio){

        if($buscar == ''){
            $usuarios = User::orderBy('id', 'DESC')->paginate(10);
        }else{
            $usuarios = User::where($criterio, 'like', '%' . $buscar . '%')->orderBy('id', 'DESC')->paginate(10);
        }

        return $usuarios;

    }

    public function cargo()

    {
        return $this->belongsTo('App\Cargo');

    }

}