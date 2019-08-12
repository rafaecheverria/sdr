<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Persona extends Model
{
    use HasRoles;

    protected $guard_name = 'web';
    
    protected $table = "personas";

	 protected $fillable = [

        'nombres', 'apellidos', 'email', 'rut'
    ];
}
