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
        'valoracion'
    ];


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images/jugadores')
            ->useFallbackUrl('/images/placeholder.jpg')
            ->useFallbackPath(public_path('/images/placeholder.jpg'));
    }

    // public function registerMediaConversions(Media $media = null): void
    // {
    //     if (env('RESIZE_IMAGE') === true) {

    //         $this->addMediaConversion('resized-image')
    //             ->width(env('IMAGE_WIDTH', 300))
    //             ->height(env('IMAGE_HEIGHT', 300));
    //     }
    // }
}
