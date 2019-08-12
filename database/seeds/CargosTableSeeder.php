<?php

use App\Cargo;
use Illuminate\Database\Seeder;

class CargosTableSeeder extends Seeder
{
    public function run()
    {
        $cargo = new Cargo;
        $cargo->nombre = "Jefe de Terreno";
        $cargo->save();

        $cargo = new Cargo;
        $cargo->nombre = "Auxiliar de Aseo";
        $cargo->save();

        $cargo = new Cargo;
        $cargo->nombre = "Jefe de Operaciones";
        $cargo->save();

        $cargo = new Cargo;
        $cargo->nombre = "Jefe de Piso";
        $cargo->save();

        $cargo = new Cargo;
        $cargo->nombre = "Promotor en Tienda";
        $cargo->save();

    }
}
