<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function principal()
    {
        return view("contenido.contenido");
    }
}
