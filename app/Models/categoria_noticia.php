<?php

/**
 * Modelo para la relación entre categorías y noticias.
 * 
 * Este modelo representa la relación entre las categorías y las noticias, permitiendo
 * asociar una noticia con una o varias categorías.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categoria_noticia extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_noticia',
        'id_categoria'
    ];
}
