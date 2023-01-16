<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBillsAddPropertyBusinessTypeCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bills', function (Blueprint $table) {
            $table->string('property_type')->after('electoral_id')->nullable();
            $table->string('property_category')->after('electoral_id')->nullable();
            $table->string('business_type')->after('electoral_id')->nullable();
            $table->string('business_category')->after('electoral_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bills', function (Blueprint $table) {
            $table->dropColumn(['property_type', 'property_category', 'business_type', 'business_category']);
        });
    }
}
