<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Atraccione
 * 
 * @property int $id_atraccion
 * @property string $nombre
 * @property string|null $descripcion
 * @property string|null $imagen
 * @property Carbon|null $fecha_creacion
 *
 * @package App\Models
 */
class Atraccione extends Model
{
	protected $table = 'atracciones';
	protected $primaryKey = 'id_atraccion';
	public $timestamps = false;

	protected $casts = [
		'fecha_creacion' => 'datetime'
	];

	protected $fillable = [
		'nombre',
		'descripcion',
		'imagen',
		'fecha_creacion'
	];
}
