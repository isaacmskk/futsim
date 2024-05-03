<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use App\Models\Jugadores;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class JugadoresController extends Controller implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    public function index()
    {
        $jugadores = jugadores::with('media')->get();
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
            'valoracion' => 'required|max:2',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Ajusta los tipos de archivo y el tamaño según tus necesidades
        ]);

        $jugador = $request->all();
        $nuevoJugador = Jugadores::create($jugador);

        if ($request->hasFile('thumbnail')) {
            $nuevoJugador->addMediaFromRequest('thumbnail')->preservingOriginal()->toMediaCollection('images-jugadores');
        }

        return response()->json(['success' => true, 'data' => $nuevoJugador]);
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
