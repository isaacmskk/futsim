<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\noticias;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Models\categorias;

class NoticiasController extends Controller implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public function index()
    {
        // return "Hola";
        $noticias = noticias::with('media')->get();
        return $noticias;
    }
    public function show($id)
{
   
    $noticia = noticias::find($id);
    $noticia['media'] = $noticia->media;

    if (!$noticia) {
        return response()->json(['error' => 'Noticia no encontrada'], 404);
    }
    return response()->json([$noticia]);
}

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
    $noticia = noticias::create($request->except('categorias')); 

    // Guarda las categorías asociadas
    $noticia->categorias()->sync($categoriasIds);

    // Agregar la imagen asociada si se proporciona
    if ($request->hasFile('thumbnail')) {
        $noticia->addMediaFromRequest('thumbnail')->preservingOriginal()->toMediaCollection('images-jugadores');
    }

    return response()->json(['success' => true, 'data' => $noticia]);
}



public function filtrarPorCategoria($categoria)
{
    $noticias = noticias::whereHas('categorias', function ($query) use ($categoria) {
        $query->where('categoria', $categoria);
    })->with('media')->get();

    return response()->json($noticias);
}


    public function destroy($id)
    {
        $noticia = noticias::find($id);
        $noticia->delete();

        return response()->json(['success' => true, 'data' => 'Noticia eliminida']);
    }
}
