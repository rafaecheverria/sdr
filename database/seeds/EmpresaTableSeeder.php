<?php

use Illuminate\Database\Seeder;

class EmpresaTableSeeder extends Seeder
{
   
    public function run()
    {
        factory(App\Empresa::class, 20)->create()->each(function(App\Empresa $empresa){

        });
    }
}
