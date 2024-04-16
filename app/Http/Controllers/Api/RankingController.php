<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RankingController extends Controller
{
    public function index()
    {
        // Obtener el ID del usuario logueado actualmente
        $userId = Auth::id();

        // Obtener los usuarios con sus puntos totales y nombres
        $usuarios = DB::table('usuario_partidos')
            ->select('usuario_partidos.id_usuario', 'users.name', DB::raw('SUM(resultado) as total_puntos'))
            ->join('users', 'usuario_partidos.id_usuario', '=', 'users.id')
            ->groupBy('usuario_partidos.id_usuario', 'users.name')
            ->orderByDesc('total_puntos')
            ->get();

        // Añadir la posición de cada usuario
        $posicion = 1;
        foreach ($usuarios as $usuario) {
            $usuario->posicion = $posicion++;
            // Marcar al usuario logueado actualmente
            $usuario->isLoggedUser = $usuario->id_usuario === $userId;
        }

        return response()->json($usuarios);
    }
}
