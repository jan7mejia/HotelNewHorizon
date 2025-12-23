<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ReservasHabitacion extends Model
{
    protected $table = 'reservas_habitacion';
    protected $primaryKey = 'id_reserva';
    public $timestamps = false;

    protected $casts = [
       'id_usuario' => 'int',
        'id_habitacion' => 'int',
        'fecha_llegada' => 'date',
        'fecha_salida' => 'date',
        'cantidad_huespedes' => 'int',
        'cantidad_habitaciones' => 'int',
        'total_pagado' => 'float',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'pago_confirmado' => 'bool',
        'fecha_creacion' => 'datetime'
    ];

    protected $fillable = [
        'id_usuario',
        'id_habitacion',
        'fecha_llegada',
        'fecha_salida',
        'cantidad_huespedes',
        'cantidad_habitaciones',
        'total_pagado',
        'check_in',
        'check_out',
        'estado',
        'metodo_pago',
        'pago_confirmado',
        'fecha_creacion'
    ];

    /* ================= RELACIONES ================= */

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function habitacione()
    {
        return $this->belongsTo(Habitacione::class, 'id_habitacion');
    }

    public function consumos_extras()
    {
        return $this->hasMany(ConsumosExtra::class, 'id_reserva');
    }
}
