<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_types', function (Blueprint $table) {
            $table->uuid();
            $table->string('display_name');
            $table->string('capacity');
            $table->string('image');
            $table->double('cost_per_minute');
            $table->double('cost_per_km');
            $table->double('cancellation_fee');
            $table->string('description');
            $table->double('initial_fee');
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
        Schema::dropIfExists('car_types');
    }
}
