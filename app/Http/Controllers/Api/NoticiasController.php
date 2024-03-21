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
    $noticia = noticias::find($id)->with('media')->get();
    if (!$noticia) {
        return response()->json(['error' => 'Noticia no encontrada'], 404);
    }
    return response()->json($noticia);
}

    public function store(Request $request)
    {

        $request->validate([
            'titulo' => 'required|max:75',
            'subtitulo' => 'required|max:125',
            'contenido' => 'required',
            'publicado' => 'required',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Ajusta los tipos de archivo y el tamaño según tus necesidades
        ]);
        $noticia = $request->all();
        $tarea = noticias::create($noticia);

        if ($request->hasFile('thumbnail')) {
            $tarea->addMediaFromRequest('thumbnail')->preservingOriginal()->toMediaCollection('images-jugadores');
        }
        return response()->json(['success' => true, 'data' => $tarea]);
    }



    public function destroy($id)
    {
        $noticia = noticias::find($id);
        $noticia->delete();

        return response()->json(['success' => true, 'data' => 'Noticia eliminida']);
    }
}
