<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\usuario_partido;
use Illuminate\Support\Facades\DB;

class RankingController extends Controller
{
    public function index()
    {
        // Obtener los usuarios con sus puntos totales
        $usuarios = DB::table('usuario_partidos')
                        ->select('id_usuario', DB::raw('SUM(resultado) as total_puntos'))
                        ->groupBy('id_usuario')
                        ->orderByDesc('total_puntos')
                        ->get();

        // Añadir la posición de cada usuario
        $posicion = 1;
        foreach ($usuarios as $usuario) {
            $usuario->posicion = $posicion++;
        }

        return response()->json($usuarios);
    }
}

