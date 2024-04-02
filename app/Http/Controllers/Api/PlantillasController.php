<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Models\Jugadores;
use Illuminate\Http\Request;
use App\Models\plantillas;
use App\Models\plantilla_jugadores;
use App\Models\User;

class PlantillasController extends Controller
{
    public function index()
    {
        $plantillas = plantillas::with('jugadores.media', 'user')->get(); // Cargar también la relación con el usuario
        return $plantillas;
    }

    public function plantillaJugador()
    {
        $usuario = auth()->user();
        $plantillas = plantillas::with('jugadores.media')->where('id_usuario', $usuario->id)->get();
        return $plantillas;
    }
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'jugadores' => 'array',
            'jugadores.*' => 'exists:jugadores,id',
            'fichaje' => 'required' // Verifica que esto esté presente
        ]);
    
        // Obtener el usuario autenticado
        $usuario = auth()->user();
    
        // Crear la plantilla
        $plantilla = $request->all();
        $plantilla['id_usuario'] = $usuario->id;
    
        // Asignar la fecha de fichaje
        $plantilla['fichaje'] = $request->fichaje; // Asegúrate de asignar correctamente el valor de 'fichaje'
    
        // Crear la nueva plantilla_jugadores
        $nuevaPlantilla = plantillas::create($plantilla);
        $nuevaPlantilla->jugadores()->sync($request->input('jugadores'));
    
        return response()->json(['success' => true, 'data' => $nuevaPlantilla]);
    }
    
    
    public function show($id)
    {
        $plantilla = plantillas::with('jugadores')->find($id);
        return response()->json($plantilla);
    }

    public function obtenerJugadoresSeleccionados($idPlantilla)
    {
        $jugadoresSeleccionados = plantilla_jugadores::where('id_plantilla', $idPlantilla)
            ->join('jugadores', 'plantilla_jugadores.id_jugador', '=', 'jugadores.id')
            ->select('jugadores.*')
            ->get();

        return response()->json($jugadoresSeleccionados);
    }
    public function destroyByIndex($index) {
        $plantilla = plantillas::all()->get($index);
        if($plantilla) {
            $plantilla->delete();
            return response()->json(['message' => 'Plantilla eliminada correctamente'], 200);
        } else {
            return response()->json(['message' => 'No se encontró la plantilla'], 404);
        }
    }
    
    public function update(Request $request, $id)
{
    $plantilla = plantillas::find($id);
    
    if(!$plantilla) {
        return response()->json(['message' => 'No se encontró la plantilla'], 404);
    }
    
    $request->validate([
        'nombre' => 'required',
        'jugadores' => 'array',
        'jugadores.*' => 'exists:jugadores,id',
        'fichaje' => now() // Verifica que esto esté presente

    ]);

    $plantilla->nombre = $request->nombre;
    $plantilla->save();
    
    // Si necesitas actualizar los jugadores asociados a la plantilla, puedes hacerlo aquí
    
    return response()->json(['success' => true, 'data' => $plantilla]);
}

}
