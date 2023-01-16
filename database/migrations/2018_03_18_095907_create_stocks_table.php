<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('stock_type')->default('gcr');
            $table->string('accountant_id')->nullable();
            $table->string('supervisor_id')->nullable();
            $table->string('collector_id')->nullable();
            $table->string('min_serial');
            $table->string('max_serial');
            $table->string('voucher');
            $table->integer('quantity')->unsigned()->default(100);
            $table->dateTime('date');
            $table->string('status')->default('free');
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
        Schema::dropIfExists('stocks');
    }
}
