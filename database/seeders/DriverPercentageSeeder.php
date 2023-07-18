<?php

namespace Database\Seeders;

use App\Models\DashboardData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DriverPercentageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DashboardData::create([
            'percentage' => '8'
        ]);
    }
}
