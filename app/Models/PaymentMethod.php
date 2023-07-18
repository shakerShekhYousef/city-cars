<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PaymentMethod
 * 
 * @property string $uuid
 * @property string $type
 * @property string $name
 * @property string|null $icon
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class PaymentMethod extends Model
{
	protected $table = 'payment_methods';
	public $incrementing = false;

	protected $fillable = [
		'uuid',
		'type',
		'name',
		'icon',
		'description'
	];
}
