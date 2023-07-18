<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Notification
 * 
 * @property string $uuid
 * @property string $title
 * @property string $body
 * @property int $sender
 * @property int $receiver
 * @property string $notification_type
 * @property int $request
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Notification extends Model
{
	protected $table = 'notifications';
	public $incrementing = false;
	protected $primaryKey = 'uuid';

	protected $fillable = [
		'uuid',
		'title',
		'body',
		'sender',
		'receiver',
		'notification_type',
		'request'
	];
}
