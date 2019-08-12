<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    protected $table = "comunas";

    protected $fillable = [

       'id', 'nombre'
   ];
}
