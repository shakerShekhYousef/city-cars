<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class home_data extends Model
{
    use HasFactory;
    protected $table = 'home_datas';
    protected $fillable = [
        'about_en',
        'about_ar',
        'terms_en',
        'terms_ar',
        'privacy_policy_en',
        'privacy_policy_ar',
        'contact_us_en',
        'contact_us_ar',
        'email_us_en',
        'email_us_ar',
    ];
}
