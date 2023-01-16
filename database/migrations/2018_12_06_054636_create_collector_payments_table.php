<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectorPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collector_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('collector_id');
            $table->string('account_no');
            $table->string('account_type');
            $table->string('name');
            $table->string('email');
            $table->string('username')->nullable();
            $table->boolean('paid')->deafult(0);
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
        Schema::dropIfExists('collector_payments');
    }
}
