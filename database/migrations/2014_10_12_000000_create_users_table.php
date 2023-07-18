<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('country_code')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('role')->nullable();
            $table->string('image')->nullable();
            $table->string('account_id')->nullable();
            $table->string('account_type')->nullable();
            $table->string('long')->nullable();
            $table->string('lat')->nullable();
            $table->string('user_verified')->default('0');

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
