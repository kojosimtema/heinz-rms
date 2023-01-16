<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account_no');
            $table->string('rate_pa');
            $table->string('rateable_value');
            $table->float('current_amount')->default(0.00);
            $table->float('arrears')->default(0.00);
            $table->string('rate_imposed')->nullable();
            $table->float('total_paid')->default(0.00);
            $table->string('bill_type');
            $table->string('prepared_by')->default("ADMIN");
            $table->boolean('printed')->default(0);
            $table->unsignedInteger('year');
            $table->float('account_balance')->nullable();
            $table->dateTime('bill_date')->nullable($value = true);
            $table->boolean('is_current')->default(0);
            $table->timestamps();


            // $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            // $table->foreign('prepared_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // $table->dropForeign(['property_id', 'prepared_by']);
        Schema::dropIfExists('bills');
    }
}
