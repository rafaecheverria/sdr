<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        // $this->call(EmpresaTableSeeder::class);
        $this->call(ComunasRegionesSeeder::class);
        $this->call(CargosTableSeeder::class);
        $this->call(EstadosTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(DepartamentosTableSeeder::class);
        $this->call(TipoDocumentoTableSeeder::class);
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

    }
}
