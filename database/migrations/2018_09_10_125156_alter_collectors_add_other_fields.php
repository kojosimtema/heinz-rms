<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCollectorsAddOtherFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collectors', function (Blueprint $table) {
            $table->string('address')->nullable();
            $table->string('collector_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('collectors', function (Blueprint $table) {
            $table->dropColumn(['address', 'collector_type']);
        });
    }
}
