<?php


namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Card
 *
 * @property string $code
 * @property string $price
 * @property int $driver_id
 * @property string $is_used

 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Card extends Model
{
 
    protected $table = 'cards';
    public $incrementing = false;
    protected $primaryKey = 'code';

    protected $fillable = [
        'code',
        'price',
        'is_used',
        'driver_id',
        
    ];
    
    // public function driver()
    // {
    //     return $this->belongsto(DriverInformation::class, 'driver_id', 'code');
    // }
}
