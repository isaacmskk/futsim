<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comentarios extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'comentario',
        'id_usuario',
        'time',
        'id_noticia'
    ];

}
