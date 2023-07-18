<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_datas', function (Blueprint $table) {
            $table->id();
            $table->text('about_en');
            $table->text('about_ar');
            $table->text('terms_en');
            $table->text('terms_ar');
            $table->text('privacy_policy_en');
            $table->text('privacy_policy_ar');
            $table->text('contact_us_en');
            $table->text('contact_us_ar');
            $table->text('email_us_en');
            $table->text('email_us_ar');
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
        Schema::dropIfExists('home_datas');
    }
};
