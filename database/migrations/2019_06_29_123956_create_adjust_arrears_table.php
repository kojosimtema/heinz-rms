<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdjustArrearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adjust_arrears', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account_no');
            $table->float('amount');
            $table->string('bill_year');
            $table->string('bill_type');
            $table->string('date');
            $table->string('adjusted_by');
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
        Schema::dropIfExists('adjust_arrears');
    }
}
