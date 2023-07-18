<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Contracts\Auth\MustVerifyEmail;

/**
 * Class User
 *
 * @property string $uuid
 * @property string $name
 * @property string $email
 * @property string $password
 * @property Carbon|null $email_verified_at
 * @property string|null $country_code
 * @property string|null $phone_number
 * @property string|null $role
 * @property string|null $image
 * @property string|null $account_id
 * @property string|null $account_type
 * @property string|null $long
 * @property string|null $lat
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'uuid';
    public $incrementing = false;

    protected $dates = [
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'email_verified_at',
        'country_code',
        'phone_number',
        'role',
        'image',
        'account_id',
        'account_type',
        'long',
        'lat',
        'remember_token',
        'rate',
        'language',
        'user_verified'
    ];

    public function vehicleInformation()
    {
        return $this->hasOne(VehicleInformation::class, 'driver_id', 'uuid');
    }

    public function isDriver()
    {
        return $this->role == "Driver" ? true : false;
    }

    public function isUser()
    {
        return $this->role == "User" ? true : false;
    }

    public function isAdmin()
    {
        return $this->role == "Admin" ? true : false;
    }
    public function ride()
    {
        return $this->hasMany(RideRequest::class, 'user_id', 'uuid');
    }
}
