<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->increments('id');
            $table->string('property_no');
            $table->string('property_type');
            $table->string('property_category');
            $table->string('zonal_id')->nullable();
            $table->string('tas_id')->nullable();
            $table->string('electoral_id')->nullable();
            $table->string('street_id')->nullable();
            
            
            $table->string('property_owner')->nullable();
            $table->string('rateable_value')->nullable();
            $table->string('address')->nullable();
            $table->string('division')->nullable();
            $table->string('serial_no')->nullable();
            $table->string('building_permit_no')->nullable();
            $table->dateTime('permit_date')->nullable();
            $table->string('house_no')->nullable();
            $table->string('assessment_no')->nullable();
            $table->dateTime('assessment_date')->nullable();
            $table->string('unit_id')->nullable();
            $table->string('community_id')->nullable();
            $table->string('use_code')->nullable();
            $table->string('occupancy')->nullable();
            $table->string('valuation_no')->nullable();

            $table->text('image')->nullable();
            $table->string('loc_longitude')->nullable();
            $table->string('loc_latitude')->nullable();


            $table->string('construction_material')->nullable();
            $table->string('construction_year')->nullable();
            $table->string('roofing_material')->nullable();
            $table->string('households')->nullable();
            $table->string('bedrooms')->nullable();
            $table->string('wcs')->nullable();
            $table->string('other_toilets')->nullable();
            $table->string('bathrooms')->nullable();
            $table->string('kitchen')->nullable();
            $table->string('garages')->nullable();
            $table->string('shop')->nullable();
            $table->string('outhouse')->nullable();
            $table->timestamps();


            /**
              *  $table->foreign('property_type')->references('id')->on('property_types')->onDelete('cascade');
              *  $table->foreign('property_category')->references('id')->on('property_categories')->onDelete('cascade');
              *  $table->foreign('property_owner')->references('id')->on('property_owners')->onDelete('cascade');
              *  $table->foreign('tas_id')->references('id')->on('tas')->onDelete('cascade');
              *  $table->foreign('electoral_id')->references('id')->on('electorals')->onDelete('cascade');
              *  $table->foreign('community_id')->references('id')->on('communities')->onDelete('cascade');
              *  $table->foreign('zonal_id')->references('id')->on('zonals')->onDelete('cascade');
              *  $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
              *  $table->foreign('street_id')->references('id')->on('streets')->onDelete('cascade');
              *  $table->foreign('building_permit_no')->references('id')->on('building_permits')->onDelete('cascade');
             */

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /**
         *   Schema::table('table', function (Blueprint $table) {
         *       $table->dropForeign([
         *           'property_type', 'property_category', 'property_owner', 'tas_id', 'electoral_id',
         *           'community_id', 'zonal_id', 'unit_id', 'street_id', 'building_permit_no'
         *       ]);
         *   });
         */
        Schema::dropIfExists('properties');
    }
}
