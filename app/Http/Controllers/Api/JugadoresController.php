<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use App\Models\jugadores;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class JugadoresController extends Controller implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    public function index()
    {
        // return "Hola";
        $jugadores = jugadores::all()->toArray();
        return $jugadores;
    }

    public function show($id)
    {
        $jugador = jugadores::find($id);
        return response()->json($jugador);
    }

    public function store(Request $request)
    {

        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'posicion' => 'required',
            'nacionalidad' => 'required',
            'valoracion' => 'required|max:2'
        ]);
        $jugador = $request->all();
        $tarea = jugadores::create($jugador);

        if ($request->hasFile('thumbnail')) {
            $tarea->addMediaFromRequest('thumbnail')->preservingOriginal()->toMediaCollection('images-jugadores');
        }
        return response()->json(['success' => true, 'data' => $tarea]);
    }

    public function update($id, Request $request)
    {
        $jugador = jugadores::find($id);

        $request->validate([
            'posicion',
            'nacionalidad',
            'valoracion',
            'carta',
        ]);

        $dataToUpdate = $request->all();
        $jugador->update($dataToUpdate);


        return response()->json(['success' => true, 'data' => $jugador]);
    }

    public function destroy($id)
    {
        $jugador = jugadores::find($id);
        $jugador->delete();

        return response()->json(['success' => true, 'data' => 'Tarea eliminida']);
    }
}
