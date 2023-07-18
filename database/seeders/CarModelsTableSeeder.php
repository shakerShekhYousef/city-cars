<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CarModelsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('car_models')->delete();
        
        \DB::table('car_models')->insert(array (
            0 => 
            array (
                'uuid' => 'd89e08a7-82bd-4919-afe3-d75510f973c5',
                'name' => 'Mazda3',
                'car_type' => '55300e4c-0820-44b4-b512-37461deb6013',
                'created_at' => '2022-04-05 18:48:19',
                'updated_at' => '2022-04-06 21:54:58',
            ),
            1 => 
            array (
                'uuid' => 'c6e4bdd7-4ea8-4df6-8c80-7d77b7b6bc63',
                'name' => 'Honda Pilot',
                'car_type' => 'a8d2057c-6cc2-4839-9da9-fea12f69ff4d',
                'created_at' => '2022-04-05 18:48:19',
                'updated_at' => '2022-04-06 21:54:45',
            ),
            2 => 
            array (
                'uuid' => 'bbed1431-df15-4cae-94a1-a1a13af4fe16',
                'name' => 'Infiniti QX80',
                'car_type' => 'd74350ec-ffb8-40cf-b920-3898149aedc7',
                'created_at' => '2022-04-05 18:48:19',
                'updated_at' => '2022-04-06 21:54:29',
            ),
            3 => 
            array (
                'uuid' => '9534eba5-123c-4ece-a1bc-5a363c03ae51',
                'name' => 'Mercedes-Benz S-Class',
                'car_type' => 'a5817661-5f04-4ccc-a341-94f7387a6dd2',
                'created_at' => '2022-04-05 18:48:19',
                'updated_at' => '2022-04-06 21:53:53',
            ),
        ));
        
        
    }
}