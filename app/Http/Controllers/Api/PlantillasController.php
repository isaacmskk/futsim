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
            'id_usuario' => 'required',
            'grl' => 'required',

        ]);
        $plantilla = $request->all();
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
