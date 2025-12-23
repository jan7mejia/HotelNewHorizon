<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ConsumosExtra
 * 
 * @property int $id_consumo
 * @property int $id_reserva
 * @property string $descripcion
 * @property float $monto
 * @property Carbon|null $fecha
 * 
 * @property ReservasHabitacion $reservas_habitacion
 *
 * @package App\Models
 */
class ConsumosExtra extends Model
{
	protected $table = 'consumos_extras';
	protected $primaryKey = 'id_consumo';
	public $timestamps = false;

	protected $casts = [
		'id_reserva' => 'int',
		'monto' => 'float',
		'fecha' => 'datetime'
	];

	protected $fillable = [
		'id_reserva',
		'descripcion',
		'monto',
		'fecha'
	];

	public function reservas_habitacion()
	{
		return $this->belongsTo(ReservasHabitacion::class, 'id_reserva');
	}
}
