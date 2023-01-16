<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPropertyOwnersAddOtherFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_owners', function (Blueprint $table) {
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('partnership')->nullable();
            $table->string('area')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property_owners', function (Blueprint $table) {
            $table->dropColumn(['email', 'mobile', 'partnership', 'area']);
        });
    }
}
