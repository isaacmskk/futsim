<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Jugadores;
use Illuminate\Http\Request;
use App\Models\plantillas;

class PlantillasController extends Controller
{
    public function index()
    {
        // return "Hola";
        $plantillas = plantillas::all()->toArray();
        return $plantillas;
    }
    public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required',
        'jugadores' => 'array',
        'jugadores.*' => 'exists:jugadores,id', // Ensure players exist in the database
    ]);

    // Get the authenticated user
    $usuario = auth()->user();

    // Create the plantilla
    $plantilla = $request->all();
    $plantilla['id_usuario'] = $usuario->id;

    $nuevaPlantilla = plantillas::create($plantilla);

    // Sync jugadores with the newly created plantilla
    $nuevaPlantilla->jugadores()->sync($request->input('jugadores'));

    return response()->json(['success' => true, 'data' => $nuevaPlantilla]);
}
    

    public function show($id)
{
    $plantilla = plantillas::with('jugadores')->find($id);
    return response()->json($plantilla);
}
    
    public function destroy($id)
    {
        $plantilla = plantillas::find($id);
        $plantilla->delete();

        return response()->json(['success' => true, 'data' => 'Plantilla eliminida']);
    }
}
