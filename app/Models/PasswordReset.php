<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PasswordReset
 * 
 * @property int $id
 * @property string|null $email
 * @property string|null $token
 *
 * @package App\Models
 */
class PasswordReset extends Model
{
	protected $table = 'password_resets';
	// public $incrementing = false;
	public $timestamps = true;

	protected $hidden = [
		'token'
	];

	protected $fillable = [
		'email',
		'token'
	];
}
