<?php

/**
 * Modelo para los usuarios del sistema.
 * 
 * Este modelo gestiona la información de los usuarios, incluyendo su nombre, apellido,
 * dirección de correo electrónico, contraseña y otros atributos relevantes. También define
 * las relaciones con otras entidades, como las plantillas asociadas a un usuario.
 */

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\UserResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'apellido',
        'email',
        'password',
        'wins',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new UserResetPasswordNotification($token));
    }
    public function misPlantillas(): HasMany
{
    return $this->hasMany(plantillas::class, 'id_usuario');
}
public function partidos()
{
    return $this->belongsToMany(Partidos::class, 'usuario_partidos', 'id_partido', 'id_usuario')
                ->withPivot('resultado');
}

}
