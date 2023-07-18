<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VehicleInformation
 *
 * @property string $uuid
 * @property int $car_model
 * @property string $car_color
 * @property string $front_image
 * @property string $back_image
 * @property string $right_image
 * @property string $left_image
 * @property int $driver_id
 * @property string $license_plate
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class VehicleInformation extends Model
{
	protected $table = 'vehicle_information';
	protected $primaryKey = 'uuid';
	public $incrementing = false;

	protected $fillable = [
		'uuid',
		'car_model',
		'car_color',
		'front_image',
		'back_image',
		'right_image',
		'left_image',
		'driver_id',
		'license_plate'
	];

	public function carModel()
	{
		return $this->belongsTo(CarModel::class, 'car_model', 'uuid');
	}
	public function driverinformation()
    {
        return $this->hasOne(DriverInformation::class, 'driver_id', 'uuid');
    }
}
