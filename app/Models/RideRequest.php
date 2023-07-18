<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RideRequest
 *
 * @property string $uuid
 * @property int $car_type_id
 * @property int $estimate_id
 * @property string $status
 * @property int $driver_id
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class RideRequest extends Model
{
    /*
        status:
        pending, in_progress, completed, accepted, rejected
    */
    protected $table = 'ride_requests';
    public $incrementing = false;
    protected $primaryKey = 'uuid';

    protected $fillable = [
        'uuid',
        'car_type_id',
        'estimate_id',
        'status',
        'driver_id',
        'user_id'
    ];

    public function estimate()
    {
        return $this->hasMany(Estimate::class, 'uuid', 'estimate_id');
    }

    public function carTypeObj()
    {
        return $this->belongsTo(CarType::class, 'car_type_id', 'uuid');
    }

    public function driverObj()
    {
        return $this->belongsTo(User::class, 'driver_id', 'uuid');
    }

    public function userObj()
    {
        return $this->belongsTo(User::class, 'user_id', 'uuid');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'uuid');
    }
}
