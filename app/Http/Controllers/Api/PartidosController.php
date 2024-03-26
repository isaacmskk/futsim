<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Jugadores;
use App\Models\plantillas;
use App\Models\partidos;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\plantilla_jugadores;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PartidosController extends Controller
{
    public function obtenerJugadoresPorPlantilla($plantillaId, $plantillaSeleccionadaId)
    {
        // Obtener los IDs de los jugadores asociados a ambas plantillas
        $jugadoresPlantilla1Ids = plantilla_jugadores::where('id_plantilla', $plantillaId)
            ->pluck('id_jugador');

        $jugadoresPlantilla2Ids = plantilla_jugadores::where('id_plantilla', $plantillaSeleccionadaId)
            ->pluck('id_jugador');
        $idUsuarioPlantilla2 = plantillas::findOrFail($plantillaSeleccionadaId)->id_usuario;

        // Obtener los jugadores asociados a ambas plantillas
        $jugadoresPlantilla1 = Jugadores::with('media')->whereIn('id', $jugadoresPlantilla1Ids)->get();
        $jugadoresPlantilla2 = Jugadores::with('media')->whereIn('id', $jugadoresPlantilla2Ids)->get();

        // Obtener el nombre de las plantillas seleccionadas
        $nombrePlantilla1 = plantillas::findOrFail($plantillaId)->nombre;
        $nombrePlantilla2 = plantillas::findOrFail($plantillaSeleccionadaId)->nombre;
        // Devolver los jugadores y los nombres de las plantillas en formato JSON
        return response()->json([
            'nombrePlantilla1' => $nombrePlantilla1,
            'nombrePlantilla2' => $nombrePlantilla2,
            'jugadoresPlantilla1' => $jugadoresPlantilla1,
            'jugadoresPlantilla2' => $jugadoresPlantilla2,

        ]);
    }
    public function store($plantillaId, $plantillaSeleccionadaId)
    {
        $usuarioActual = Auth::user();
        $usuarioRival = plantillas::findOrFail($plantillaId)->user;
        // Obtener el usuario asociado a la plantilla seleccionada

        // Crear una nueva instancia de Partidos y asignar los valores recibidos
        $partido = new Partidos();
        $partido->id_plantilla1 = $plantillaId;
        $partido->usuario1 = $usuarioRival->id; // ID del usuario asociado a la plantilla 2
        $partido->goles1 = random_int(0, 5); // Generar goles aleatorios
        $partido->fecha = now(); // Fecha y hora actuales
        $partido->id_plantilla2 = $plantillaSeleccionadaId;
        $partido->usuario2 = $usuarioActual->id; // ID del usuario actual
        $partido->goles2 = random_int(0, 5); // Generar goles aleatorios

        // Guardar el partido en la base de datos
        $partido->save();

        // Devolver una respuesta JSON con el partido creado
        return response()->json($partido, 201);
    }
}
