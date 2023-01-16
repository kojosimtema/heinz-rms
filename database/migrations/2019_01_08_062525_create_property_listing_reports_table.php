<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyListingReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_listing_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account_no')->nullable();
            $table->string('report_id');
            $table->string('owner')->nullable();
            $table->string('address')->nullable();
            $table->string('category')->nullable();
            $table->string('arrears')->nullable();
            $table->string('current_bill')->nullable();
            $table->string('total_bill')->nullable();
            $table->string('total_payment')->nullable();
            $table->string('outstanding_arrears')->nullable();
            $table->string('m_arrears')->nullable();
            $table->string('m_current_bill')->nullable();
            $table->string('m_total_bill')->nullable();
            $table->string('m_total_payment')->nullable();
            $table->string('m_outstanding_arrears')->nullable();
            $table->string('zonal')->nullable();
            $table->string('electoral')->nullable();
            $table->string('tas')->nullable();
            $table->string('community')->nullable();
            $table->string('street')->nullable();
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
        Schema::dropIfExists('property_listing_reports');
    }
}
