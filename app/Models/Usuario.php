<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false; // No hay created_at ni updated_at

    protected $casts = [
        'fecha_creacion' => 'datetime',
    ];

    protected $fillable = [
        'nombre',
        'correo',
        'contraseña',
        'rol',
        'fecha_creacion'
    ];

    protected $hidden = [
        'contraseña',
    ];

    // Laravel usará esta columna como password
    public function getAuthPassword()
    {
        return $this->contraseña;
    }

    public function reservas_eventos()
    {
        return $this->hasMany(ReservasEvento::class, 'id_usuario');
    }

    public function reservas_habitacions()
    {
        return $this->hasMany(ReservasHabitacion::class, 'id_usuario');
    }
}
