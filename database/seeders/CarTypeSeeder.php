<?php

namespace Database\Seeders;

use App\Models\CarType;
use App\Models\VehicleInformation;
use Faker\Provider\Uuid;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid as UuidUuid;

class CarTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CarType::updateOrCreate(

            [
                'uuid' => UuidUuid::uuid4()->toString(),
                'display_name' => "Display Name1",
                'capacity' => "Capacity1",
                'image' => "storage/data/car_types/type1.png",
                'cost_per_minute' => "1",
                'cost_per_km' => "1.5",
                'cancellation_fee' => "1",
                'description' => "description1",
                'initial_fee' => "1",
            ]
        );
        CarType::updateOrCreate(

            [
                'uuid' => UuidUuid::uuid4()->toString(),
                'display_name' => "Display Name2",
                'capacity' => "Capacity2",
                'image' => "storage/data/car_types/type2.png",
                'cost_per_minute' => "2",
                'cost_per_km' => "2",
                'cancellation_fee' => "2",
                'description' => "description2",
                'initial_fee' => "2",
            ]
        );
        CarType::updateOrCreate(
            [
                'uuid' => UuidUuid::uuid4()->toString(),
                'display_name' => "Display Name3",
                'capacity' => "Capacity3",
                'image' => "storage/data/car_types/type3.png",
                'cost_per_minute' => "3",
                'cost_per_km' => "2.6",
                'cancellation_fee' => "3",
                'description' => "description3",
                'initial_fee' => "3",
            ]
        );
        CarType::updateOrCreate(
            [
                'uuid' => UuidUuid::uuid4()->toString(),
                'display_name' => "Display Name4",
                'capacity' => "Capacity4",
                'image' => "storage/data/car_types/type4.png",
                'cost_per_minute' => "4",
                'cost_per_km' => "3.6",
                'cancellation_fee' => "4",
                'description' => "description4",
                'initial_fee' => "4",
            ]
        );
    }
}
