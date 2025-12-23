<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $table = 'eventos';
    protected $primaryKey = 'id_evento';
    public $timestamps = false;

    protected $casts = [
        'precio' => 'float',
        'capacidad' => 'int',
        'fecha_creacion' => 'datetime'
    ];

    protected $fillable = [
        'nombre',
        'tipo',
        'descripcion',
        'precio',
        'capacidad',
        'imagen',
        'estado',
        'fecha_creacion'
    ];

    public function reservas_eventos()
    {
        return $this->hasMany(ReservasEvento::class, 'id_evento');
    }

    public function reservasConfirmadas()
    {
        return $this->hasMany(ReservasEvento::class, 'id_evento')
                    ->where('pago_confirmado', 1);
    }

    /* ================= ATRIBUTOS CALCULADOS ================= */

    public function getPersonasOcupadasAttribute()
    {
        // Sumamos las personas de reservas confirmadas
        return $this->reservasConfirmadas()->sum('cantidad_personas');
    }

    public function getCuposDisponiblesAttribute()
    {
        if ($this->tipo !== 'buffet') return null;
        return max(0, $this->capacidad - $this->personas_ocupadas);
    }

    public function getDisponibleAttribute()
    {
        // El botón se muestra si el estado general es 'disponible'
        if ($this->tipo === 'salon') {
            return $this->estado === 'disponible';
        }

        // Para buffet, además debe haber cupos
        return $this->estado === 'disponible' && $this->cupos_disponibles > 0;
    }
}