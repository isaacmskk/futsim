<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\comentarios;
use App\Models\noticias;

class ComentariosController extends Controller
{
    public function index()
{
    $comentarios = comentarios::with('user')->get()->toArray();
    return $comentarios;
}


    public function show($id)
    {
        $comentario = comentarios::find($id);
        return response()->json($comentario);
    }

    public function store(Request $request)
{
    $request->validate([
        'comentario' => 'required',
        'id_noticia' => 'required|exists:noticias,id', // Asegurar que la noticia exista
    ]);

    // Obtener el usuario autenticado
    $usuario = auth()->user();

    // Asociar la noticia actual
    $noticiaId = $request->input('id_noticia');

    // Crear el comentario
    $comentario = comentarios::create([
        'comentario' => $request->input('comentario'),
        'id_usuario' => $usuario->id,
        'id_noticia' => $noticiaId,
        'time' => now(),
    ]);

    // Obtener la noticia asociada al comentario
    $noticia = noticias::find($noticiaId);

    return response()->json(['success' => true, 'data' => $comentario, 'noticia' => $noticia]);
}


}
