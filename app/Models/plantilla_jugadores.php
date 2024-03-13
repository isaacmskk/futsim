<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class plantilla_jugadores extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_plantilla',
        'id_jugador',
    ];
}
