<?php

namespace Database\Seeders;

use App\Models\CarModel;
use App\Models\User;
use App\Models\VehicleInformation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class TestDriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // emirates drivers
        $driver = User::updateOrCreate(
            [
                'email' => "driver1@city-cars.ae"
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'name' => "Driver1",
                'email' => "drive1@city-cars.ae",
                'country_code' => "+963",
                'phone_number' => "936488445",
                'role' => "Driver",
                'password' => Hash::make("12345"),
                'lat' => '25.20771217',
                'long' => '55.27418900',
            ]
        );

        VehicleInformation::updateOrCreate(
            [
                'car_model' => CarModel::skip(0)->take(1)->first()->uuid,
                'car_color' => 'yellow',
                'front_image' => 'storage/documents/driver/cars_images/front-img.png',
                'back_image' => 'storage/documents/driver/cars_images/back-img.png',
                'right_image' => 'storage/documents/driver/cars_images/right-img.png',
                'left_image' => 'storage/documents/driver/cars_images/left-img.png',
                'driver_id' => User::where('role', 'Driver')->skip(0)->take(1)->first()->uuid,
                'license_plate' => 'storage/documents/driver/drive_licenses/driver-licence-front.png'
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'car_model' => CarModel::skip(0)->take(1)->first()->uuid,
                'car_color' => 'yellow',
                'front_image' => 'storage/documents/driver/cars_images/front-img.png',
                'back_image' => 'storage/documents/driver/cars_images/back-img.png',
                'right_image' => 'storage/documents/driver/cars_images/right-img.png',
                'left_image' => 'storage/documents/driver/cars_images/left-img.png',
                'driver_id' => $driver->uuid,
                'license_plate' => 'Licence plate test data'
            ]
        );

        $driver = User::updateOrCreate(
            [
                'email' => "driver2@city-cars.ae"
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'name' => "Driver2",
                'email' => "drive2@city-cars.ae",
                'country_code' => "+963",
                'phone_number' => "936488445",
                'role' => "Driver",
                'password' => Hash::make("12345"),
                'lat' => '24.9873467',
                'long' => '55.2144505',
            ]
        );

        VehicleInformation::updateOrCreate(
            [
                'car_model' => CarModel::skip(1)->take(1)->first()->uuid,
                'car_color' => 'yellow',
                'front_image' => 'storage/documents/driver/cars_images/front-img.png',
                'back_image' => 'storage/documents/driver/cars_images/back-img.png',
                'right_image' => 'storage/documents/driver/cars_images/right-img.png',
                'left_image' => 'storage/documents/driver/cars_images/left-img.png',
                'driver_id' => User::where('role', 'Driver')->skip(0)->take(1)->first()->uuid,
                'license_plate' => 'storage/documents/driver/drive_licenses/driver-licence-front.png'
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'car_model' => CarModel::skip(1)->take(1)->first()->uuid,
                'car_color' => 'yellow',
                'front_image' => 'storage/documents/driver/cars_images/front-img.png',
                'back_image' => 'storage/documents/driver/cars_images/back-img.png',
                'right_image' => 'storage/documents/driver/cars_images/right-img.png',
                'left_image' => 'storage/documents/driver/cars_images/left-img.png',
                'driver_id' => $driver->uuid,
                'license_plate' => 'Licence plate test data'
            ]
        );

        $driver =  User::updateOrCreate(
            [
                'email' => "driver3@city-cars.ae"
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'name' => "Driver3",
                'email' => "drive3@city-cars.ae",
                'country_code' => "+963",
                'phone_number' => "936488445",
                'role' => "Driver",
                'password' => Hash::make("12345"),
                'lat' => '24.9740863',
                'long' => '55.2072001',
            ]
        );

        VehicleInformation::updateOrCreate(
            [
                'car_model' => CarModel::skip(2)->take(1)->first()->uuid,
                'car_color' => 'yellow',
                'front_image' => 'storage/documents/driver/cars_images/front-img.png',
                'back_image' => 'storage/documents/driver/cars_images/back-img.png',
                'right_image' => 'storage/documents/driver/cars_images/right-img.png',
                'left_image' => 'storage/documents/driver/cars_images/left-img.png',
                'driver_id' => User::where('role', 'Driver')->skip(2)->take(1)->first()->uuid,
                'license_plate' => 'storage/documents/driver/drive_licenses/driver-licence-front.png'
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'car_model' => CarModel::skip(2)->take(1)->first()->uuid,
                'car_color' => 'yellow',
                'front_image' => 'storage/documents/driver/cars_images/front-img.png',
                'back_image' => 'storage/documents/driver/cars_images/back-img.png',
                'right_image' => 'storage/documents/driver/cars_images/right-img.png',
                'left_image' => 'storage/documents/driver/cars_images/left-img.png',
                'driver_id' => User::where('role', 'Driver')->skip(2)->take(1)->first()->uuid,
                'license_plate' => 'Licence plate test data'
            ]
        );

        $driver = User::updateOrCreate(
            [
                'email' => "driver4@city-cars.ae"
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'name' => "Driver4",
                'email' => "drive4@city-cars.ae",
                'country_code' => "+963",
                'phone_number' => "936488445",
                'role' => "Driver",
                'password' => Hash::make("12345"),
                'lat' => '24.9314366',
                'long' => '55.0909501'
            ]
        );

        VehicleInformation::updateOrCreate(
            [
                'car_model' => CarModel::skip(3)->take(1)->first()->uuid,
                'car_color' => 'yellow',
                'front_image' => 'storage/documents/driver/cars_images/front-img.png',
                'back_image' => 'storage/documents/driver/cars_images/back-img.png',
                'right_image' => 'storage/documents/driver/cars_images/right-img.png',
                'left_image' => 'storage/documents/driver/cars_images/left-img.png',
                'driver_id' => User::where('role', 'Driver')->skip(3)->take(1)->first()->uuid,
                'license_plate' => 'storage/documents/driver/drive_licenses/driver-licence-front.png'
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'car_model' => CarModel::skip(3)->take(1)->first()->uuid,
                'car_color' => 'yellow',
                'front_image' => 'storage/documents/driver/cars_images/front-img.png',
                'back_image' => 'storage/documents/driver/cars_images/back-img.png',
                'right_image' => 'storage/documents/driver/cars_images/right-img.png',
                'left_image' => 'storage/documents/driver/cars_images/left-img.png',
                'driver_id' => User::where('role', 'Driver')->skip(3)->take(1)->first()->uuid,
                'license_plate' => 'Licence plate test data'
            ]
        );

        // jordan drivers
        $driver = User::updateOrCreate(
            [
                'email' => "driver5@city-cars.ae"
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'name' => "Driver5",
                'email' => "drive5@city-cars.ae",
                'country_code' => "+963",
                'phone_number' => "936488445",
                'role' => "Driver",
                'password' => Hash::make("12345"),
                'lat' => '31.9279522',
                'long' => '35.9183119'
            ]
        );

        VehicleInformation::updateOrCreate(
            [
                'car_model' => CarModel::skip(3)->take(1)->first()->uuid,
                'car_color' => 'yellow',
                'front_image' => 'storage/documents/driver/cars_images/front-img.png',
                'back_image' => 'storage/documents/driver/cars_images/back-img.png',
                'right_image' => 'storage/documents/driver/cars_images/right-img.png',
                'left_image' => 'storage/documents/driver/cars_images/left-img.png',
                'driver_id' => User::where('role', 'Driver')->skip(4)->take(1)->first()->uuid,
                'license_plate' => 'storage/documents/driver/drive_licenses/driver-licence-front.png'
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'car_model' => CarModel::skip(3)->take(1)->first()->uuid,
                'car_color' => 'yellow',
                'front_image' => 'storage/documents/driver/cars_images/front-img.png',
                'back_image' => 'storage/documents/driver/cars_images/back-img.png',
                'right_image' => 'storage/documents/driver/cars_images/right-img.png',
                'left_image' => 'storage/documents/driver/cars_images/left-img.png',
                'driver_id' => User::where('role', 'Driver')->skip(4)->take(1)->first()->uuid,
                'license_plate' => 'Licence plate test data'
            ]
        );

        $driver = User::updateOrCreate(
            [
                'email' => "driver6@city-cars.ae"
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'name' => "Driver6",
                'email' => "drive6@city-cars.ae",
                'country_code' => "+963",
                'phone_number' => "936488445",
                'role' => "Driver",
                'password' => Hash::make("12345"),
                'lat' => '31.9300565',
                'long' => '35.909629'
            ]
        );

        VehicleInformation::updateOrCreate(
            [
                'car_model' => CarModel::skip(3)->take(1)->first()->uuid,
                'car_color' => 'yellow',
                'front_image' => 'storage/documents/driver/cars_images/front-img.png',
                'back_image' => 'storage/documents/driver/cars_images/back-img.png',
                'right_image' => 'storage/documents/driver/cars_images/right-img.png',
                'left_image' => 'storage/documents/driver/cars_images/left-img.png',
                'driver_id' => User::where('role', 'Driver')->skip(5)->take(1)->first()->uuid,
                'license_plate' => 'storage/documents/driver/drive_licenses/driver-licence-front.png'
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'car_model' => CarModel::skip(3)->take(1)->first()->uuid,
                'car_color' => 'yellow',
                'front_image' => 'storage/documents/driver/cars_images/front-img.png',
                'back_image' => 'storage/documents/driver/cars_images/back-img.png',
                'right_image' => 'storage/documents/driver/cars_images/right-img.png',
                'left_image' => 'storage/documents/driver/cars_images/left-img.png',
                'driver_id' => User::where('role', 'Driver')->skip(5)->take(1)->first()->uuid,
                'license_plate' => 'Licence plate test data'
            ]
        );

        $driver = User::updateOrCreate(
            [
                'email' => "driver7@city-cars.ae"
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'name' => "Driver7",
                'email' => "drive7@city-cars.ae",
                'country_code' => "+963",
                'phone_number' => "936488445",
                'role' => "Driver",
                'password' => Hash::make("12345"),
                'lat' => '31.9195128',
                'long' => '35.9225685'
            ]
        );

        VehicleInformation::updateOrCreate(
            [
                'car_model' => CarModel::skip(3)->take(1)->first()->uuid,
                'car_color' => 'yellow',
                'front_image' => 'storage/documents/driver/cars_images/front-img.png',
                'back_image' => 'storage/documents/driver/cars_images/back-img.png',
                'right_image' => 'storage/documents/driver/cars_images/right-img.png',
                'left_image' => 'storage/documents/driver/cars_images/left-img.png',
                'driver_id' => User::where('role', 'Driver')->skip(6)->take(1)->first()->uuid,
                'license_plate' => 'storage/documents/driver/drive_licenses/driver-licence-front.png'
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'car_model' => CarModel::skip(3)->take(1)->first()->uuid,
                'car_color' => 'yellow',
                'front_image' => 'storage/documents/driver/cars_images/front-img.png',
                'back_image' => 'storage/documents/driver/cars_images/back-img.png',
                'right_image' => 'storage/documents/driver/cars_images/right-img.png',
                'left_image' => 'storage/documents/driver/cars_images/left-img.png',
                'driver_id' => User::where('role', 'Driver')->skip(6)->take(1)->first()->uuid,
                'license_plate' => 'Licence plate test data'
            ]
        );

        $driver = User::updateOrCreate(
            [
                'email' => "driver8@city-cars.ae"
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'name' => "Driver8",
                'email' => "drive8@city-cars.ae",
                'country_code' => "+963",
                'phone_number' => "936488445",
                'role' => "Driver",
                'password' => Hash::make("12345"),
                'lat' => '25.32049504063907',
                'long' => '55.38141489553805'
            ]
        );

        VehicleInformation::updateOrCreate(
            [
                'car_model' => CarModel::skip(0)->take(1)->first()->uuid,
                'car_color' => 'yellow',
                'front_image' => 'storage/documents/driver/cars_images/front-img.png',
                'back_image' => 'storage/documents/driver/cars_images/back-img.png',
                'right_image' => 'storage/documents/driver/cars_images/right-img.png',
                'left_image' => 'storage/documents/driver/cars_images/left-img.png',
                'driver_id' => User::where('role', 'Driver')->skip(7)->take(1)->first()->uuid,
                'license_plate' => 'storage/documents/driver/drive_licenses/driver-licence-front.png'
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'car_model' => CarModel::skip(0)->take(1)->first()->uuid,
                'car_color' => 'yellow',
                'front_image' => 'storage/documents/driver/cars_images/front-img.png',
                'back_image' => 'storage/documents/driver/cars_images/back-img.png',
                'right_image' => 'storage/documents/driver/cars_images/right-img.png',
                'left_image' => 'storage/documents/driver/cars_images/left-img.png',
                'driver_id' => User::where('role', 'Driver')->skip(7)->take(1)->first()->uuid,
                'license_plate' => 'Licence plate test data'
            ]
        );


        $driver = User::updateOrCreate(
            [
                'email' => "driver9@city-cars.ae"
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'name' => "Driver9",
                'email' => "drive9@city-cars.ae",
                'country_code' => "+963",
                'phone_number' => "936488445",
                'role' => "Driver",
                'password' => Hash::make("12345"),
                'lat' => '25.324318753207383',
                'long' => '55.377792539718314'
            ]
        );

        VehicleInformation::updateOrCreate(
            [
                'car_model' => CarModel::skip(1)->take(1)->first()->uuid,
                'car_color' => 'yellow',
                'front_image' => 'storage/documents/driver/cars_images/front-img.png',
                'back_image' => 'storage/documents/driver/cars_images/back-img.png',
                'right_image' => 'storage/documents/driver/cars_images/right-img.png',
                'left_image' => 'storage/documents/driver/cars_images/left-img.png',
                'driver_id' => User::where('role', 'Driver')->skip(8)->take(1)->first()->uuid,
                'license_plate' => 'storage/documents/driver/drive_licenses/driver-licence-front.png'
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'car_model' => CarModel::skip(1)->take(1)->first()->uuid,
                'car_color' => 'yellow',
                'front_image' => 'storage/documents/driver/cars_images/front-img.png',
                'back_image' => 'storage/documents/driver/cars_images/back-img.png',
                'right_image' => 'storage/documents/driver/cars_images/right-img.png',
                'left_image' => 'storage/documents/driver/cars_images/left-img.png',
                'driver_id' => User::where('role', 'Driver')->skip(8)->take(1)->first()->uuid,
                'license_plate' => 'Licence plate test data'
            ]
        );

        $driver = User::updateOrCreate(
            [
                'email' => "driver10@city-cars.ae"
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'name' => "Driver10",
                'email' => "drive10@city-cars.ae",
                'country_code' => "+963",
                'phone_number' => "936488445",
                'role' => "Driver",
                'password' => Hash::make("12345"),
                'lat' => '25.332556807074436',
                'long' => '55.375025828078336'
            ]
        );

        VehicleInformation::updateOrCreate(
            [
                'car_model' => CarModel::skip(2)->take(1)->first()->uuid,
                'car_color' => 'yellow',
                'front_image' => 'storage/documents/driver/cars_images/front-img.png',
                'back_image' => 'storage/documents/driver/cars_images/back-img.png',
                'right_image' => 'storage/documents/driver/cars_images/right-img.png',
                'left_image' => 'storage/documents/driver/cars_images/left-img.png',
                'driver_id' => User::where('role', 'Driver')->skip(9)->take(1)->first()->uuid,
                'license_plate' => 'storage/documents/driver/drive_licenses/driver-licence-front.png'
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'car_model' => CarModel::skip(2)->take(1)->first()->uuid,
                'car_color' => 'yellow',
                'front_image' => 'storage/documents/driver/cars_images/front-img.png',
                'back_image' => 'storage/documents/driver/cars_images/back-img.png',
                'right_image' => 'storage/documents/driver/cars_images/right-img.png',
                'left_image' => 'storage/documents/driver/cars_images/left-img.png',
                'driver_id' => User::where('role', 'Driver')->skip(9)->take(1)->first()->uuid,
                'license_plate' => 'Licence plate test data'
            ]
        );

        $driver = User::updateOrCreate(
            [
                'email' => "driver11@city-cars.ae"
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'name' => "Driver11",
                'email' => "drive11@city-cars.ae",
                'country_code' => "+963",
                'phone_number' => "936488445",
                'role' => "Driver",
                'password' => Hash::make("12345"),
                'lat' => '31.891399973880308',
                'long' => '35.91253324802991'
            ]
        );

        VehicleInformation::updateOrCreate(
            [
                'car_model' => CarModel::skip(3)->take(1)->first()->uuid,
                'car_color' => 'yellow',
                'front_image' => 'storage/documents/driver/cars_images/front-img.png',
                'back_image' => 'storage/documents/driver/cars_images/back-img.png',
                'right_image' => 'storage/documents/driver/cars_images/right-img.png',
                'left_image' => 'storage/documents/driver/cars_images/left-img.png',
                'driver_id' => User::where('role', 'Driver')->skip(10)->take(1)->first()->uuid,
                'license_plate' => 'storage/documents/driver/drive_licenses/driver-licence-front.png'
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'car_model' => CarModel::skip(3)->take(1)->first()->uuid,
                'car_color' => 'yellow',
                'front_image' => 'storage/documents/driver/cars_images/front-img.png',
                'back_image' => 'storage/documents/driver/cars_images/back-img.png',
                'right_image' => 'storage/documents/driver/cars_images/right-img.png',
                'left_image' => 'storage/documents/driver/cars_images/left-img.png',
                'driver_id' => User::where('role', 'Driver')->skip(10)->take(1)->first()->uuid,
                'license_plate' => 'Licence plate test data'
            ]
        );

        $driver = User::updateOrCreate(
            [
                'email' => "driver12@city-cars.ae"
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'name' => "Driver12",
                'email' => "drive12@city-cars.ae",
                'country_code' => "+963",
                'phone_number' => "936488445",
                'role' => "Driver",
                'password' => Hash::make("12345"),
                'lat' => '31.91441908248124',
                'long' => '35.96179580680027'
            ]
        );

        VehicleInformation::updateOrCreate(
            [
                'car_model' => CarModel::skip(0)->take(1)->first()->uuid,
                'car_color' => 'yellow',
                'front_image' => 'storage/documents/driver/cars_images/front-img.png',
                'back_image' => 'storage/documents/driver/cars_images/back-img.png',
                'right_image' => 'storage/documents/driver/cars_images/right-img.png',
                'left_image' => 'storage/documents/driver/cars_images/left-img.png',
                'driver_id' => User::where('role', 'Driver')->skip(11)->take(1)->first()->uuid,
                'license_plate' => 'storage/documents/driver/drive_licenses/driver-licence-front.png'
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'car_model' => CarModel::skip(0)->take(1)->first()->uuid,
                'car_color' => 'yellow',
                'front_image' => 'storage/documents/driver/cars_images/front-img.png',
                'back_image' => 'storage/documents/driver/cars_images/back-img.png',
                'right_image' => 'storage/documents/driver/cars_images/right-img.png',
                'left_image' => 'storage/documents/driver/cars_images/left-img.png',
                'driver_id' => User::where('role', 'Driver')->skip(11)->take(1)->first()->uuid,
                'license_plate' => 'Licence plate test data'
            ]
        );

        $driver = User::updateOrCreate(
            [
                'email' => "driver13@city-cars.ae"
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'name' => "Driver13",
                'email' => "drive13@city-cars.ae",
                'country_code' => "+963",
                'phone_number' => "936488445",
                'role' => "Driver",
                'password' => Hash::make("12345"),
                'lat' => '31.79647902308683',
                'long' => '36.018402643258185'
            ]
        );

        VehicleInformation::updateOrCreate(
            [
                'car_model' => CarModel::skip(1)->take(1)->first()->uuid,
                'car_color' => 'yellow',
                'front_image' => 'storage/documents/driver/cars_images/front-img.png',
                'back_image' => 'storage/documents/driver/cars_images/back-img.png',
                'right_image' => 'storage/documents/driver/cars_images/right-img.png',
                'left_image' => 'storage/documents/driver/cars_images/left-img.png',
                'driver_id' => User::where('role', 'Driver')->skip(12)->take(1)->first()->uuid,
                'license_plate' => 'storage/documents/driver/drive_licenses/driver-licence-front.png'
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'car_model' => CarModel::skip(1)->take(1)->first()->uuid,
                'car_color' => 'yellow',
                'front_image' => 'storage/documents/driver/cars_images/front-img.png',
                'back_image' => 'storage/documents/driver/cars_images/back-img.png',
                'right_image' => 'storage/documents/driver/cars_images/right-img.png',
                'left_image' => 'storage/documents/driver/cars_images/left-img.png',
                'driver_id' => User::where('role', 'Driver')->skip(12)->take(1)->first()->uuid,
                'license_plate' => 'Licence plate test data'
            ]
        );
    }
}
