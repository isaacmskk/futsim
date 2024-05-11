<?php

namespace Database\Seeders;

use App\Models\categorias;
use Illuminate\Database\Seeder;

class CategoriasTableSeeder extends Seeder
{
    public function run()
    {
        // Datos de ejemplo para los jugadores
        $categorias =  [
            [
                'id' => '1',
                'categoria' => 'FUTBOL',
            ],
            [
                'id' => '2',

                'categoria' => 'COMPETICIONES',
            ],
            [
                'id' => '3',

                'categoria' => 'JUGADORES',
            ],
            [
                'id' => '4',

                'categoria' => 'EQUIPOS',
            ],
            [
                'id' => '5',

                'categoria' => 'FINANZAS',
            ]
        ];

        // Crear jugadores en la base de datos
        foreach ($categorias as $categoria) {
            categorias::create([
                'id' => $categoria['id'],
                'categoria' => $categoria['categoria'],
            ]);
        }
    }
}
