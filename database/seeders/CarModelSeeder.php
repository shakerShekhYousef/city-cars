<?php

namespace Database\Seeders;

use App\Models\CarModel;
use App\Models\CarType;
use App\Models\User;
use App\Models\VehicleInformation;
use Faker\Provider\Uuid;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid as UuidUuid;

class CarModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CarModel::updateOrCreate(

            [
                'uuid' => UuidUuid::uuid4()->toString(),
                'name' => "Name1",
                'car_type' => CarType::first()->skip(0)->take(1)->first()->uuid
            ]
        );
        CarModel::updateOrCreate(
            [
                'uuid' => UuidUuid::uuid4()->toString(),
                'name' => "Name2",
                'car_type' => CarType::orderBy('created_at','desc')->skip(1)->take(1)->first()->uuid
            ]
        );
        CarModel::updateOrCreate(

            [
                'uuid' => UuidUuid::uuid4()->toString(),
                'name' => "Name3",
                'car_type' => CarType::orderBy('created_at','desc')->skip(2)->take(1)->first()->uuid
            ]
        );
        CarModel::updateOrCreate(

            [
                'uuid' => UuidUuid::uuid4()->toString(),
                'name' => "Name4",
                'car_type' => CarType::orderBy('created_at','desc')->skip(3)->take(1)->first()->uuid
            ]
        );

    }
}
