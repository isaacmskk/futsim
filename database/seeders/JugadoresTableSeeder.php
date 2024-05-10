<?php
// Seeder para agregar datos de ejemplo a la tabla de jugadores

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Jugadores;

class JugadoresTableSeeder extends Seeder
{
    public function run()
    {
        // Datos de ejemplo para los jugadores
        $jugadores =  [
            [
                'nombre' => 'Alphonso',
                'apellido' => 'Davies',
                'posicion' => 'LI',
                'nacionalidad' => 'CND',
                'valoracion' => 94,
                'imagen_path' => 'images\davies.png' // Ruta de la imagen
            ],
            [
                'nombre' => 'Merle',
                'apellido' => 'Frohms',
                'posicion' => 'POR',
                'nacionalidad' => 'ALE',
                'valoracion' => 90,
                'imagen_path' => 'images\Frohms.png' // Ruta de la imagen
            ],
            [
                'nombre' => 'Ngolo',
                'apellido' => 'Kante',
                'posicion' => 'MCD',
                'nacionalidad' => 'FR',
                'valoracion' => 94,
                'imagen_path' => 'images\kante.png' // Ruta de la imagen
            ],
            [
                'nombre' => 'Florian',
                'apellido' => 'Wirtz',
                'posicion' => 'MCO',
                'nacionalidad' => 'ALE',
                'valoracion' => 96,
                'imagen_path' => 'images\wirtz.png' // Ruta de la imagen
            ]
        ];

        // Crear jugadores en la base de datos
        foreach ($jugadores as $jugador) {
            $nuevoJugador = Jugadores::create([
                'nombre' => $jugador['nombre'],
                'apellido' => $jugador['apellido'],
                'posicion' => $jugador['posicion'],
                'nacionalidad' => $jugador['nacionalidad'],
                'valoracion' => $jugador['valoracion'],
            ]);

            // Agregar imagen a la colección de medios del jugador
            $nuevoJugador->addMedia(public_path($jugador['imagen_path']))->preservingOriginal()->toMediaCollection('photo');
        }
    }
}