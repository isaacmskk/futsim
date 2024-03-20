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


class PartidosController extends Controller 
{
    public function index(Request $request)
    {
        // Recupera los IDs de las plantillas seleccionadas de la ruta o el estado
        $plantillaId = $request->route('plantillaId');
        $plantillaSeleccionadaId = $request->route('plantillaSeleccionadaId');

        // Ejemplo de búsqueda de jugadores de la plantilla 1
        $jugadoresPlantilla1 = Jugadores::where('plantilla_id', $plantillaId)->get();

        // Ejemplo de búsqueda de jugadores de la plantilla 2
        $jugadoresPlantilla2 = Jugadores::where('plantilla_id', $plantillaSeleccionadaId)->get();

        // Luego puedes pasar los jugadores a la vista o realizar cualquier otra acción necesaria
        return view('partidos.indexpartido', [
            'jugadoresPlantilla1' => $jugadoresPlantilla1,
            'jugadoresPlantilla2' => $jugadoresPlantilla2,
        ]);
    }
    public function obtenerJugadoresPorPlantilla($plantillaId)
{
    // Obtener jugadores de la plantilla
    $jugadores = Jugadores::where('plantilla_id', $plantillaId)->get();

    // Devolver los jugadores en formato JSON
    return response()->json($jugadores);
}

}