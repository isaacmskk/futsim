<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class plantillas extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'nombre',
        'id_usuario',
    ];
}
