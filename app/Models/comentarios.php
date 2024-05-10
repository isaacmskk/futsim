<?php

/**
 * Modelo para los comentarios.
 * 
 * Este modelo representa los comentarios realizados por los usuarios en las noticias.
 * Contiene información sobre el comentario, el usuario que lo realizó, la noticia asociada y la fecha y hora de creación.
 */

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

    /**
     * Define la relación con el modelo User, indicando que un comentario pertenece a un usuario.
     */

    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

}
