<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class partidos extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'id_plantilla1',
        'usuario1',
        'goles1',
        'fecha',
        'goles2',
        'usuario2',
        'id_plantilla2'

    ];

}
