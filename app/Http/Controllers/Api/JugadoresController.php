<?php

/**
 * Controlador para administrar jugadores en la API.
 * 
 * Este controlador maneja las operaciones CRUD para los jugadores, incluyendo la creación, 
 * lectura, actualización y eliminación de jugadores. También se encarga de manejar las 
 * imágenes asociadas a los jugadores.
 */

namespace App\Http\Controllers\Api;

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

    /**
     * Obtiene todos los jugadores con sus imágenes asociadas.
     */
    public function index()
    {
        $jugadores = Jugadores::with('media')->get();
        return $jugadores;
    }

    /**
     * Obtiene un jugador específico por su ID.
     */
    public function show($id)
    {
        $jugador = Jugadores::find($id);
        return response()->json($jugador);
    }

    /**
     * Crea un nuevo jugador.
     */
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

    /**
     * Actualiza un jugador existente por su ID.
     */
    public function update($id, Request $request)
    {
        $jugador = Jugadores::find($id);

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

    /**
     * Elimina un jugador existente por su ID.
     */
    public function destroy($id)
    {
        $jugador = Jugadores::find($id);
        $jugador->delete();

        return response()->json(['success' => true, 'data' => 'Jugador eliminado']);
    }
}
