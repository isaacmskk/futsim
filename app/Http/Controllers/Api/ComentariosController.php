<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\comentarios;

class ComentariosController extends Controller
{
    public function index()
    {
        $comentarios = comentarios::all()->toArray();
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

    return response()->json(['success' => true, 'data' => $comentario]);
}

}
