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
    public function usuarios()
{
    return $this->belongsToMany(User::class, 'usuario_partidos', 'id_partido', 'id_usuario')
                ->withPivot('resultado'); // Puedes incluir cualquier otra columna de la tabla pivot que necesites
}
}
