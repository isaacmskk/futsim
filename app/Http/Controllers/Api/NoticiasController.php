<?php

/**
 * Controlador para gestionar noticias en la API.
 * 
 * Este controlador maneja las operaciones CRUD para las noticias, incluyendo la creación, 
 * lectura, actualización y eliminación de noticias. También se encarga de manejar las 
 * imágenes asociadas a las noticias y filtrar noticias por categoría.
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Noticias;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Models\Categorias;

class NoticiasController extends Controller implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * Obtiene todas las noticias con sus imágenes asociadas.
     */
    public function index()
    {
        $noticias = Noticias::with('media')->get();
        return $noticias;
    }

    /**
     * Obtiene una noticia específica por su ID.
     */
    public function show($id)
    {
        $noticia = Noticias::find($id);
        $noticia['media'] = $noticia->media;

        if (!$noticia) {
            return response()->json(['error' => 'Noticia no encontrada'], 404);
        }
        return response()->json([$noticia]);
    }

    /**
     * Crea una nueva noticia.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:75',
            'subtitulo' => 'required|max:125',
            'contenido' => 'required',
            'publicado' => 'required',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'categorias' => 'required|string', // Cambia el tipo a 'string'
            'categorias.*' => 'exists:categorias,id',
        ]);
        $categoriasIds = explode(',', $request->categorias);
        $noticia = Noticias::create($request->except('categorias')); 

        // Guarda las categorías asociadas
        $noticia->categorias()->sync($categoriasIds);

        // Agregar la imagen asociada si se proporciona
        if ($request->hasFile('thumbnail')) {
            $noticia->addMediaFromRequest('thumbnail')->preservingOriginal()->toMediaCollection('images-jugadores');
        }

        return response()->json(['success' => true, 'data' => $noticia]);
    }

    /**
     * Filtra noticias por categoría.
     */
    public function filtrarPorCategoria($categoria)
    {
        $noticias = Noticias::whereHas('categorias', function ($query) use ($categoria) {
            $query->where('categoria', $categoria);
        })->with('media')->get();

        return response()->json($noticias);
    }

    /**
     * Elimina una noticia existente por su ID.
     */
    public function destroy($id)
    {
        $noticia = Noticias::find($id);
        $noticia->delete();

        return response()->json(['success' => true, 'data' => 'Noticia eliminada']);
    }
}
