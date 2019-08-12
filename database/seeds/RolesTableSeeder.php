<?php

use App\User;
use App\Persona;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;


class RolesTableSeeder extends Seeder
{

    public function run()
    {
        Role::truncate();
        User::truncate();

        $adminRole = Role::create(['name' => 'Administrador']);
        $postulanteRole = Role::create(['name' => 'Postulante']);

        $admin = new User();
            $admin->rut = "16.447.779-7";
            $admin->pais = "chile";
            $admin->nombres = "Rafael";
            $admin->apellidos = "Echeverria Reyes";
            $admin->email = "rafaecheverria@live.cl";
            $admin->password = bcrypt("raer2608");
            $admin->estado = 1;
            $admin->confirmed = true;
            $admin->confirmation_code = null;
            $admin->id = $admin->id;

            $admin->save();
            
            $admin->assignRole($adminRole);

        $postulante = new User();
            $postulante->rut = "17.748.600-0";
            $postulante->pais = "chile";
            $postulante->nombres = "Fernando";
            $postulante->apellidos = "Romero Rodriguez";
            $postulante->email = "fernando.romero@live.com";
            $postulante->id = $postulante->id;
            $postulante->password = bcrypt("raer2608");
            $postulante->estado = 1;
            $postulante->confirmed = true;
            $postulante->confirmation_code = null;

            $postulante->save();

            $postulante->assignRole($postulanteRole);
            
    }
}
