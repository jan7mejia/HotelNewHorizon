<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservasPromocione extends Model
{
    protected $table = 'reservas_promociones';
    protected $primaryKey = 'id_reserva_promocion';
    public $timestamps = false;

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'pago_confirmado' => 'boolean'
    ];

    protected $fillable = [
        'id_usuario',
        'id_promocion',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'metodo_pago',
        'pago_confirmado',
        'total_pagado' // Agregado para evitar error SQL
    ];

    public function promocione()
    {
        return $this->belongsTo(Promocione::class, 'id_promocion');
    }
}