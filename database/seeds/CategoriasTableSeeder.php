<?php

use App\Categoria;
use Illuminate\Database\Seeder;

class CategoriasTableSeeder extends Seeder
{
    public function run()
    {
        $categoria = new Categoria;
        $categoria->nombre = "Administración";
        $categoria->save();

        $categoria = new Categoria;
        $categoria->nombre = "Arte/Diseño/Medios";
        $categoria->save();

        $categoria = new Categoria;
        $categoria->nombre = "Asistente Adminsitrativo";
        $categoria->save();

        $categoria = new Categoria;
        $categoria->nombre = "Economía/Contabilidad";
        $categoria->save();

        $categoria = new Categoria;
        $categoria->nombre = "Educación y Psicología";
        $categoria->save();

        $categoria = new Categoria;
        $categoria->nombre = "Estética y Ciudado Personal";
        $categoria->save();

        $categoria = new Categoria;
        $categoria->nombre = "Hotelería Turismo y Gastronomía";
        $categoria->save();

        $categoria = new Categoria;
        $categoria->nombre = "Informática/Telecomunicaciones";
        $categoria->save();

        $categoria = new Categoria;
        $categoria->nombre = "Logística/Distribución";
        $categoria->save();

        $categoria = new Categoria;
        $categoria->nombre = "Marketing y Publicidad";
        $categoria->save();

        $categoria = new Categoria;
        $categoria->nombre = "Medicina/Salud";
        $categoria->save();

        $categoria = new Categoria;
        $categoria->nombre = "Operarios";
        $categoria->save();

        $categoria = new Categoria;
        $categoria->nombre = "Otros";
        $categoria->save();

        $categoria = new Categoria;
        $categoria->nombre = "Prácticas Profesionales";
        $categoria->save();

        $categoria = new Categoria;
        $categoria->nombre = "Profesionales y Técnicos";
        $categoria->save();

        $categoria = new Categoria;
        $categoria->nombre = "Receptción/Secretaría";
        $categoria->save();

        $categoria = new Categoria;
        $categoria->nombre = "Recursos Humanos";
        $categoria->save();

        $categoria = new Categoria;
        $categoria->nombre = "Seguridad";
        $categoria->save();

        $categoria = new Categoria;
        $categoria->nombre = "Servicios Domésticos";
        $categoria->save();
        
        $categoria = new Categoria;
        $categoria->nombre = "Trabajos Universitarios";
        $categoria->save();

        $categoria = new Categoria;
        $categoria->nombre = "Ventas/Comercial";
        $categoria->save();
    }
}
