<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EstimatesTemp
 *
 * @property string $uuid
 * @property string $pickup_name
 * @property string $pickup_lat
 * @property string $pickup_long
 * @property string|null $pickup_eta
 * @property string $dropoff_name
 * @property string $dropoff_lat
 * @property string $dropoff_long
 * @property string|null $dropoff_eta
 * @property string|null $duration_estimate
 * @property string|null $estimated_value
 * @property string|null $distance_estimate
 * @property int $user_id
 * @property int $car_type_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EstimatesTemp extends Model
{
	protected $table = 'estimates_temp';
	public $incrementing = false;

	protected $casts = [
		'user_id' => 'int',
		'car_type_id' => 'int'
	];

	protected $fillable = [
		'uuid',
		'pickup_name',
		'pickup_lat',
		'pickup_long',
		'pickup_eta',
		'dropoff_name',
		'dropoff_lat',
		'dropoff_long',
		'dropoff_eta',
		'duration_estimate',
		'estimated_value',
		'distance_estimate',
		'user_id',
		'car_type_id'
	];

}
