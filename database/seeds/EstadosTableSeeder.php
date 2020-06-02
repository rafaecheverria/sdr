<?php

use Illuminate\Database\Seeder;

class EstadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            $now = \Carbon\Carbon::now();
            $estados = [
                [1,'En Proceso'],
                [2,'Por Recibir'],
                [3,'Archivado'],
                
            ];
            $estados = array_map(function($estado) use ($now){
               return [
                   'id' => $estado[0],
                   'estado' => $estado[1],
                   'updated_at' => $now,
                   'created_at' => $now,
               ];
            }, $estados);
            \DB::table('estados')->insert($estados);
        }
    }
}
