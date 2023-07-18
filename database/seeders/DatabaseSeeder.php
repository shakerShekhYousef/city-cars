<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(UserSeeder::class);
        // $this->call(VehicleInformationSeeder::class);
        // $this->call(CarTypeSeeder::class);
        // $this->call(CarModelSeeder::class);
        $this->call(CarModelsTableSeeder::class);
        $this->call(CarTypesTableSeeder::class);
        $this->call(PaymentMethodsSeeder::class);
        $this->call(TestDriverSeeder::class);
        $this->call(NotificationsSeeder::class);
        $this->call(DriverPercentageSeeder::class);
    }
}
