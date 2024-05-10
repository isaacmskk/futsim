<?php

/**
 * Modelo para la relación entre plantillas y jugadores.
 * 
 * Este modelo gestiona la relación muchos a muchos entre las plantillas y los jugadores.
 * Almacena información sobre la asignación de jugadores a plantillas y la fecha de fichaje.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class plantilla_jugadores extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_plantilla',
        'id_jugador',
        'fichaje'
    ];
}
