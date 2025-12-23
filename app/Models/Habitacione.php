<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Habitacione
 * 
 * @property int $id_habitacion
 * @property string $nombre
 * @property string|null $descripcion
 * @property float $precio
 * @property int $stock
 * @property string|null $imagen
 * @property string|null $tipo
 * @property int $capacidad
 * @property Carbon|null $fecha_creacion
 * 
 * @property Collection|ReservasHabitacion[] $reservas_habitacions
 *
 * @package App\Models
 */
class Habitacione extends Model
{
	protected $table = 'habitaciones';
	protected $primaryKey = 'id_habitacion';
	public $timestamps = false;

	protected $casts = [
		'precio' => 'float',
		'stock' => 'int',
		'capacidad' => 'int',
		'fecha_creacion' => 'datetime'
	];

	protected $fillable = [
		'nombre',
		'descripcion',
		'precio',
		'stock',
		'imagen',
		'tipo',
		'capacidad',
		'fecha_creacion'
	];

	public function reservas_habitacions()
	{
		return $this->hasMany(ReservasHabitacion::class, 'id_habitacion');
	}
}
