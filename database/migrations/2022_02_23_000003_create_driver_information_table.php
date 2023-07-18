<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_information', function (Blueprint $table) {
            $table->uuid();
            $table->foreignUuid('driver_id');
            $table->string('drive_license_front_photo');
            $table->string('drive_license_back_photo');
            $table->string('no_criminal_record');
            $table->string('health_certificate');
            $table->string('id_photo');
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
        Schema::dropIfExists('driver_information');
    }
}
