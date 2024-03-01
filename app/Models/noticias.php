<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class noticias extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'titulo',
        'subtitulo',
        'contenido',
        'publicado',
        'foto'
    ];

}
