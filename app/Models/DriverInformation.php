<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DriverInformation
 *
 * @property string $uuid
 * @property int $driver_id
 * @property string $drive_license_front_photo
 * @property string $drive_license_back_photo
 * @property string $no_criminal_record
 * @property string $health_certificate
 * @property string $id_photo
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class DriverInformation extends Model
{
	protected $table = 'driver_information';
	public $incrementing = false;
	protected $primaryKey = 'uuid';

	protected $fillable = [
		'uuid',
		'driver_id',
		'drive_license_front_photo',
		'drive_license_back_photo',
		'no_criminal_record',
		'health_certificate',
		'id_photo'
	];

	// public function cards()
    // {
    //     return $this->hasMany(Card::class, 'driver_id', 'uuid');
    // }
}


