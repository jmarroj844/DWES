<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TareaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tareas')->insert([
            'titulo'=>'Peluquero',
            'descripcion'=>'Ir mañana a las 11:00 a cortarme el pelo'
        ]);

        DB::table('tareas')->insert([
            'titulo'=>'Recoger pasaporte',
            'descripcion'=>'Ir al ayuntamiento a por el pasaporte por la mañana'
        ]);
    }
}
