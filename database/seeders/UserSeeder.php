<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Provider\Uuid;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid as UuidUuid;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate(
            [
                'email' => "admin@city-cars.ae"
            ],
            [
                'uuid' => UuidUuid::uuid4()->toString(),
                // 'name' => "Admin",
                'email' => "admin@city-cars.ae",
                // 'country_code' => "+963",
                // 'phone_number' => "936488445",
                'role' => "Admin",
                'password' => Hash::make("12345")
            ]
        );
        User::updateOrCreate(
            [
                'email' => "driver@city-cars.ae"
            ],
            [
                'uuid' => UuidUuid::uuid4()->toString(),
                'name' => "Driver",
                'email' => "drive@city-cars.ae",
                'country_code' => "+963",
                'phone_number' => "936488445",
                'role' => "Driver",
                'password' => Hash::make("12345"),
                'lat' => '25.18791008',
                'long' => '55.26217270'
            ]
        );
        User::updateOrCreate(
            [
                'email' => "user@city-cars.ae"
            ],
            [
                'uuid' => UuidUuid::uuid4()->toString(),
                'name' => "User",
                'email' => "user@city-cars.ae",
                'country_code' => "+963",
                'phone_number' => "936488445",
                'role' => "User",
                'password' => Hash::make("12345")
            ]
        );
    }
}
