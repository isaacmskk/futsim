<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jugadores extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'nombre',
        'apellido',
        'posicion',
        'nacionalidad',
        'valoracion',
        'carta'
    ];
}
