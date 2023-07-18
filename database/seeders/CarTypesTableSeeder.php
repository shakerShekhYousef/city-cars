<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CarTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('car_types')->delete();
        
        \DB::table('car_types')->insert(array (
            0 => 
            array (
                'uuid' => '55300e4c-0820-44b4-b512-37461deb6013',
                'display_name' => 'CityX',
                'capacity' => '4',
                'image' => 'storage/cartypes/D0Ciu6wtDh82t7HWtuMUuShNzK9c3pPg9tXc7bib.webp',
                'cost_per_minute' => 1.0,
                'cost_per_km' => 1.5,
                'cancellation_fee' => 1.0,
                'description' => 'CityX is the standard Uber ride and the most popular rideshare option for riders. The cars under this service are typically sedans, such as Honda Accord, the Mazda3, Chevy Impala, Ford Fusion, et cetera.',
                'initial_fee' => 1.0,
                'created_at' => '2022-04-05 18:48:19',
                'updated_at' => '2022-04-06 21:42:31',
            ),
            1 => 
            array (
                'uuid' => 'a8d2057c-6cc2-4839-9da9-fea12f69ff4d',
                'display_name' => 'CityXL',
                'capacity' => '6',
                'image' => 'storage/cartypes/y767Rrvy2EkVwTrX5XfSA1ojyV5dVV7EUXjpqFPb.webp',
                'cost_per_minute' => 2.0,
                'cost_per_km' => 2.0,
                'cancellation_fee' => 2.0,
                'description' => 'If you need transportation for five to six people, CityXL is the ride for you. Should you request this ride, expect your driver to be driving a minivan or SUV, such as Ford Explorer, Honda Pilot, Hyundai Santa Fe, among others.',
                'initial_fee' => 2.0,
                'created_at' => '2022-04-05 18:48:19',
                'updated_at' => '2022-04-06 21:51:06',
            ),
            2 => 
            array (
                'uuid' => 'd74350ec-ffb8-40cf-b920-3898149aedc7',
                'display_name' => 'CitySUV',
                'capacity' => 'Capacity3',
                'image' => 'storage/cartypes/5wqB98p7ArmKH8IVaCUWHaWj8bpvpGETh6kZSfiu.webp',
                'cost_per_minute' => 3.0,
                'cost_per_km' => 2.6,
                'cancellation_fee' => 3.0,
                'description' => 'Not every day is a carpool day. Sometimes you want space and a dash of style. If you wake up feeling like a rock star, then the City Black SUVs are the way to go. This fancy version of the CityXL uses luxury SUVs to get your whole crew wherever you need t',
                'initial_fee' => 3.0,
                'created_at' => '2022-04-05 18:48:19',
                'updated_at' => '2022-04-06 21:52:12',
            ),
            3 => 
            array (
                'uuid' => 'a5817661-5f04-4ccc-a341-94f7387a6dd2',
                'display_name' => 'City Lux',
                'capacity' => 'Capacity4',
                'image' => 'storage/cartypes/onwO5AItANHv5pOzNoSfMWag58MgiFovL6suk1CW.webp',
                'cost_per_minute' => 4.0,
                'cost_per_km' => 3.6,
                'cancellation_fee' => 4.0,
                'description' => 'The City Lux is the most expensive City ride that you could request. The ride option features only the crème de la crème of the luxury cars in the market. Vehicles such as Mercedes-Benz S-Class, Audi A8, Porsche Panamera, Lexus LS, among others. All vehic',
                'initial_fee' => 4.0,
                'created_at' => '2022-04-05 18:48:19',
                'updated_at' => '2022-04-06 21:53:22',
            ),
        ));
        
        
    }
}