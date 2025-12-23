<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promocione extends Model
{
    protected $table = 'promociones';
    protected $primaryKey = 'id_promocion';
    public $timestamps = false;

    protected $casts = [
        'precio' => 'float',
        'duracion_noches' => 'integer',
        'stock' => 'integer',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date'
    ];

    protected $fillable = [
        'nombre', 'tipo', 'descripcion', 'precio', 'duracion_noches', 'stock', 'fecha_inicio', 'fecha_fin', 'imagen'
    ];

    public function reservasConfirmadas()
    {
        return $this->hasMany(ReservasPromocione::class, 'id_promocion')
                    ->whereIn('estado', ['confirmada', 'pendiente']);
    }

    public function getStockActualAttribute()
    {
        $reservadas = $this->reservasConfirmadas()->count();
        return max(0, $this->stock - $reservadas);
    }
}