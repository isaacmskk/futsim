<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\noticias;
use Illuminate\Http\Request;

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
            'nombre' => 'required',
            'apellido' => 'required',
            'posicion' => 'required',
            'nacionalidad' => 'required',
            'valoracion' => 'required|max:2',
            'carta' => 'required',
        ]);
        $jugador = $request->all();
        $tarea = jugadores::create($jugador);


        return response()->json(['success' => true, 'data' => $tarea]);
    }



    public function destroy($id)
    {
        $jugador = jugadores::find($id);
        $jugador->delete();

        return response()->json(['success' => true, 'data' => 'Tarea eliminida']);
    }
}
