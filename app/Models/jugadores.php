<?php

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
    public function plantillas()
    {
        return $this->belongsToMany(plantillas::class, 'plantilla_jugadores', 'id_jugador', 'id_plantilla');
    }
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images/jugadores')
            ->useFallbackUrl('/images/placeholder.jpg')
            ->useFallbackPath(public_path('/images/placeholder.jpg'));
    }
}
