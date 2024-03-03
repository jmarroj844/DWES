<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\Tarea;
use App\Models\Etiqueta;

class TareaEtiquetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $peluquero = Tarea::where('titulo', 'Peluquero')->first();
        $diaADia = Etiqueta::where('nombre', 'Dia a dia')->first();

        $peluquero->etiquetas()->attach($diaADia);
    }
}
