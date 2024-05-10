<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usuario_partido extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_partido',
        'id_usuario',
        'resultado'
    ];
}
