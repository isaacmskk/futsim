<?php

/**
 * Modelo para las noticias.
 * 
 * Este modelo representa las noticias en la aplicación.
 * Contiene información sobre el título, subtítulo, contenido y estado de publicación de cada noticia.
 * También gestiona las relaciones con las categorías a las que pertenecen las noticias y su contenido multimedia.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class noticias extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $fillable = [
        'id',
        'titulo',
        'subtitulo',
        'contenido',
        'publicado',
    ];

    /**
     * Registra las colecciones multimedia para las noticias.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images/jugadores')
            ->useFallbackUrl('/images/placeholder.jpg')
            ->useFallbackPath(public_path('/images/placeholder.jpg'));
    }

    /**
     * Define la relación con el modelo Categorias, indicando que una noticia puede pertenecer a muchas categorías.
     */
    public function categorias()
    {
        return $this->belongsToMany(categorias::class, 'categoria_noticias', 'id_noticia', 'id_categoria');
    }
}
