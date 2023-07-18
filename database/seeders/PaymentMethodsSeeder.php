<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class PaymentMethodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // 'uuid',
        // 'type',
        // 'name',
        // 'icon',
        // 'description'
        PaymentMethod::updateOrCreate([
            'type' => 'cash',
            'name' => 'Cash'
        ], [
            'type' => 'cash',
            'name' => 'Cash',
            'icon' => 'storage/data/icons/cash.png',
            'description' => ''
        ]);

        PaymentMethod::updateOrCreate([
            'type' => 'paypal',
            'name' => 'Paypal'
        ], [
            'type' => 'paypal',
            'name' => 'Paypal',
            'icon' => 'storage/data/icons/paypal.png',
            'description' => 'c**@start_tech.ae'
        ]);

        PaymentMethod::updateOrCreate([
            'type' => 'credit',
            'name' => 'Credit'
        ], [
            'type' => 'credit',
            'name' => 'Credit',
            'icon' => 'storage/data/icons/credit.png',
            'description' => '*******045'
        ]);

    }
}
