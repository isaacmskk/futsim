<?php

/**
 * Modelo para los jugadores.
 * 
 * Este modelo representa a los jugadores de un equipo.
 * Contiene información básica sobre cada jugador, como su nombre, apellido, posición, nacionalidad y valoración.
 * También gestiona las relaciones con las plantillas a las que pertenecen los jugadores y su contenido multimedia.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Jugadores extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'nombre',
        'apellido',
        'posicion',
        'nacionalidad',
        'valoracion',
        // Agrega otros campos si es necesario
    ];

    /**
     * Define la relación con el modelo Plantillas, indicando que un jugador puede pertenecer a muchas plantillas.
     */
    public function plantillas()
    {
        return $this->belongsToMany(plantillas::class, 'plantilla_jugadores', 'id_jugador', 'id_plantilla');
    }

    /**
     * Registra las colecciones multimedia para los jugadores.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images/jugadores')
            ->useFallbackUrl('/images/placeholder.jpg')
            ->useFallbackPath(public_path('/images/placeholder.jpg'));
    }
}
