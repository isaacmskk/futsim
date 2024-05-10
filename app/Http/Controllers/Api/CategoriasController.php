<?php

/**
 * Controlador para manejar las categorías en la API.
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\categorias;

class CategoriasController extends Controller
{
    public function index()
    {
        $categorias = categorias::all(); // Obtiene todas las categorías
        return response()->json($categorias);
    }
}
