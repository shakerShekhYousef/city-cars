<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_information', function (Blueprint $table) {
            $table->uuid();
            $table->foreignUuid('car_model');
            $table->string('car_color');
            $table->string('front_image');
            $table->string('back_image');
            $table->string('right_image');
            $table->string('left_image');
            $table->foreignUuid('driver_id');
            $table->string('license_plate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_information');
    }
}
