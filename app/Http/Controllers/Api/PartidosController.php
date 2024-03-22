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
use User;

class PartidosController extends Controller 
{
    public function obtenerJugadoresPorPlantilla($plantillaId, $plantillaSeleccionadaId)
    {
        // Obtener los IDs de los jugadores asociados a ambas plantillas
        $jugadoresPlantilla1Ids = plantilla_jugadores::where('id_plantilla', $plantillaId)
            ->pluck('id_jugador');
    
        $jugadoresPlantilla2Ids = plantilla_jugadores::where('id_plantilla', $plantillaSeleccionadaId)
            ->pluck('id_jugador');
    
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
            'jugadoresPlantilla2' => $jugadoresPlantilla2
        ]);
    }
    
}
