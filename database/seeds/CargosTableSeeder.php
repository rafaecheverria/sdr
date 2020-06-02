<?php

use App\Cargo;
use Illuminate\Database\Seeder;

class CargosTableSeeder extends Seeder
{
    public function run()
    {
        $cargo = new Cargo;
        $cargo->nombre = "Director/a";
        $cargo->save();

        $cargo = new Cargo;
        $cargo->nombre = "Jefe";
        $cargo->save();

        $cargo = new Cargo;
        $cargo->nombre = "Profesional";
        $cargo->save();

        $cargo = new Cargo;
        $cargo->nombre = "Analista";
        $cargo->save();

        $cargo = new Cargo;
        $cargo->nombre = "Analista";
        $cargo->save();

    }
}
