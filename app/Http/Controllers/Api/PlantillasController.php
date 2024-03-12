<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
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
            'grl' => 'required',
            'jugadores' => 'array',
            'jugadores.*' => 'exists:jugadores,id', // Ensure players exist in the database
        ]);
    
        // Get the authenticated user
        $usuario = auth()->user();
    
        // Create the plantilla
        $plantilla = $request->all();
        $plantilla['id_usuario'] = $usuario->id;
    
        $tarea = plantillas::create($plantilla);
    
        return response()->json(['success' => true, 'data' => $tarea]);
    }
    

    public function show($id)
    {
        $plantilla = plantillas::find($id);
        return response()->json($plantilla);
    }
    public function destroy($id)
    {
        $plantilla = plantillas::find($id);
        $plantilla->delete();

        return response()->json(['success' => true, 'data' => 'Plantilla eliminida']);
    }
}
