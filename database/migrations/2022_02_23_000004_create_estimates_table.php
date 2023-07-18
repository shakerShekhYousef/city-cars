<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimates', function (Blueprint $table) {
            $table->uuid();
            $table->string('pickup_name');
            $table->string('pickup_lat');
            $table->string('pickup_long');
            $table->string('pickup_eta')->nullable();
            $table->string('dropoff_name');
            $table->string('dropoff_lat');
            $table->string('dropoff_long');
            $table->string('dropoff_eta')->nullable();
            $table->string('duration_estimate')->nullable();
            $table->string('estimated_value')->nullable();
            $table->string('distance_estimate')->nullable();
            $table->foreignUuid('user_id');
            $table->foreignUuid('car_type_id');
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
        Schema::dropIfExists('estimates');
    }
}
