<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Models\Jugadores;
use Illuminate\Http\Request;
use App\Models\plantillas;
use App\Models\partidos;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\plantilla_jugadores;



class PartidosController extends Controller 
{
    public function obtenerJugadoresPorPlantilla($plantillaId, $plantillaSeleccionadaId)
    {
        // Obtener los IDs de los jugadores asociados a la plantilla seleccionada
        $jugadoresPlantillaSeleccionadaIds = plantilla_jugadores::where('id_plantilla', $plantillaSeleccionadaId)
            ->pluck('id_jugador');

        // Obtener los jugadores asociados a la plantilla seleccionada
        $jugadoresPlantillaSeleccionada = Jugadores::whereIn('id', $jugadoresPlantillaSeleccionadaIds)->get();

        // Devolver los jugadores en formato JSON
        return response()->json($jugadoresPlantillaSeleccionada);
    }
}
