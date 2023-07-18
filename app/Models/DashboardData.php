<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardData extends Model
{
    use HasFactory;
    protected $table ="dashboard_data";
    protected $guarded=[];
}
