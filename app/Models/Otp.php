<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Otp
 * 
 * @property string $uuid
 * @property string $phone
 * @property string $otpcode
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Otp extends Model
{
	protected $table = 'otps';
	public $incrementing = false;
	protected $primaryKey = 'uuid';

	protected $fillable = [
		'uuid',
		'phone',
		'otpcode',
		'status'
	];
}
