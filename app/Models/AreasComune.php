<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AreasComune
 * 
 * @property int $id_area
 * @property string $nombre
 * @property string|null $descripcion
 * @property string|null $imagen
 * @property Carbon|null $fecha_creacion
 *
 * @package App\Models
 */
class AreasComune extends Model
{
	protected $table = 'areas_comunes';
	protected $primaryKey = 'id_area';
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
