<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CarModel
 *
 * @property string $uuid
 * @property string $name
 * @property string $car_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class CarModel extends Model
{
    protected $table = 'car_models';
    protected $primaryKey = 'uuid';

    public $incrementing = false;

    protected $fillable = [
        'uuid',
        'name',
        'car_type'
    ];

    public function car_type_obj()
    {
        return $this->belongsTo(CarType::class, 'car_type', 'uuid');
    }

    public function car_type_name()
    {
        $car_type = $this->belongsTo(CarType::class, 'car_type', 'uuid')->first();
        if ($car_type == null)
            return null;
        else
            return $car_type->display_name;
    }
}
