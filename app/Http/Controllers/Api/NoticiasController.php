<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\noticias;

class NoticiasController extends Controller
{
    public function index()
    {
        // return "Hola";
        $noticias = noticias::all()->toArray();
        return $noticias;
    }

    public function show($id)
    {
        $noticia = noticias::find($id);
        return response()->json($noticia);
    }
    public function store(Request $request)
    {

        $request->validate([
            'titulo' => 'required|max:75',
            'subtitulo' => 'required|max:125',
            'contenido' => 'required',
            'publicado' => 'required',
            'foto' => 'required',
        ]);
        $noticia = $request->all();
        $tarea = noticias::create($noticia);


        return response()->json(['success' => true, 'data' => $tarea]);
    }



    public function destroy($id)
    {
        $noticia = noticias::find($id);
        $noticia->delete();

        return response()->json(['success' => true, 'data' => 'Noticia eliminida']);
    }
}
