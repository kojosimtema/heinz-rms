<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account_no')->nullable();
            $table->string('data_type');
            $table->unsignedInteger('payment_year');
            $table->dateTime('payment_date');
            $table->float('amount_paid');
            $table->string('gcr_number');
            $table->string('payment_mode');
            $table->string('cheque_no')->nullable();
            $table->string('cprn')->nullable();
            $table->string('collector_id')->nullable();
            $table->string('collector_name')->nullable();
            $table->string('collector_email')->nullable();
            $table->string('cashier_id')->nullable();
            $table->boolean('is_verfied')->default(0);
            $table->timestamps();

            // $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            // $table->foreign('collector_id')->references('id')->on('collectors')->onDelete('cascade');
            // $table->foreign('cashier_id')->references('id')->on('cashiers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // $table->dropForeign(['property_id', 'collector_id', 'cashier_id']);
        Schema::dropIfExists('payments');
    }
}
