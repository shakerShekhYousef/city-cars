<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CarType
 * 
 * @property string $uuid
 * @property string $display_name
 * @property string $capacity
 * @property string $image
 * @property float $cost_per_minute
 * @property float $cost_per_km
 * @property float $cancellation_fee
 * @property string $description
 * @property float $initial_fee
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class CarType extends Model
{
	protected $table = 'car_types';
	protected $primaryKey = 'uuid';

	public $incrementing = false;

	protected $fillable = [
		'uuid',
		'display_name',
		'capacity',
		'image',
		'cost_per_minute',
		'cost_per_km',
		'cancellation_fee',
		'description',
		'initial_fee'
	];
}
