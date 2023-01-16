<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('business_no');
            $table->string('business_name');
            $table->string('business_type');
            $table->string('business_category');
            $table->string('zonal_id')->nullable();
            $table->string('tas_id')->nullable();
            $table->string('electoral_id')->nullable();
            $table->string('street_id')->nullable();
            $table->string('community_id')->nullable();


            $table->string('business_owner')->nullable();
            $table->string('tin_number')->nullable();
            $table->string('vat_no')->nullable();
            $table->string('industry')->nullable();
            $table->string('reg_no')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('employee_no')->nullable();
            $table->string('male_employed')->nullable();
            $table->string('female_employed')->nullable();

            $table->text('image')->nullable();
            $table->string('loc_longitude')->nullable();
            $table->string('loc_latitude')->nullable();

            $table->string('property_no')->nullable();
            $table->string('valuation_no')->nullable();
            $table->string('gps_code')->nullable();
            $table->string('client')->nullable();


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
        Schema::dropIfExists('businesses');
    }
}
