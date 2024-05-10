<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'categoria'
    ];

    public function noticias()
    {
        return $this->belongsToMany(Noticias::class, 'categoria_noticias', 'id_categoria', 'id_noticia');
    }
    public function plantillas()
    {
        return $this->belongsToMany(plantillas::class, 'plantilla_jugadores', 'id_jugador', 'id_plantilla');
    }
}
