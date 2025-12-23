<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ReservasEvento
 * 
 * @property int $id_reserva_evento
 * @property int $id_usuario
 * @property int $id_evento
 * @property Carbon $fecha_evento
 * @property int $cantidad_personas
 * @property float $total_pagado
 * @property string|null $estado
 * @property string|null $metodo_pago
 * @property bool|null $pago_confirmado
 * @property Carbon|null $fecha_creacion
 * 
 * @property Usuario $usuario
 * @property Evento $evento
 *
 * @package App\Models
 */
class ReservasEvento extends Model
{
    protected $table = 'reservas_eventos';
    protected $primaryKey = 'id_reserva_evento';
    public $timestamps = false;

    protected $casts = [
        'id_usuario' => 'int',
        'id_evento' => 'int',
        'fecha_evento' => 'datetime',
        'cantidad_personas' => 'int',
        'total_pagado' => 'float',
        'pago_confirmado' => 'bool',
        'fecha_creacion' => 'datetime'
    ];

    protected $fillable = [
        'id_usuario',
        'id_evento',
        'fecha_evento',
        'cantidad_personas',
        'total_pagado',
        'estado',
        'metodo_pago',
        'pago_confirmado',
        'fecha_creacion'
    ];

    /* =========================
       RELACIONES
       ========================= */

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id_evento');
    }
}
