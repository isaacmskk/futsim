<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\jugadores;


class JugadoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jugadores =  [
            [
            'nombre' => 'nombre',
            'apellido' => 'apellido',
            'posicion' => 'adada',
            'nacionalidad' => 'nacionalidad',
            'valoracion' => 5
            ],
            [
                'nombre' => 'aaa',
                'apellido' => 'apellido',
                'posicion' => 'posicion',
                'nacionalidad' => 'nacionalidad',
                'valoracion' => 4
            ]
        ];


        foreach ($jugadores as $jugador) {
            jugadores::create($jugador);
        }
    }
}