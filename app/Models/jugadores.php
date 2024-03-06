<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class jugadores extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $fillable = [
        'id',
        'nombre',
        'apellido',
        'posicion',
        'nacionalidad',
        'valoracion',
        'carta'
    ];


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('storage/exercises')
            ->useFallbackUrl('/storage/placeholder.jpg')
            ->useFallbackPath(public_path('/storage/placeholder.jpg'));
    }
}
