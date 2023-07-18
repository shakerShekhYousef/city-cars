<?php



namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PromoCode
 *  @property int $id
 * @property string $promo_code
 * @property string $type
 * @property int $expiry_date
 * @property string $usage_limit
 * @property string $value
* @property string $status
 * @property string $users_number
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */

class PromoCode extends Model
{
    
    protected $table = 'promo_codes';
    public $incrementing = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'promo_code',
        'type',
        'value',
        'expiry_date',
        'usage_limit',
        'status',
        'users_number'
        
    ];

    protected $casts=[
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d'
    ];
}
