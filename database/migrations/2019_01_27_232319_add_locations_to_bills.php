<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLocationsToBills extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bills', function (Blueprint $table) {
          $table->string('electoral_id')->after('accumulated_current_amount')->nullable();
          $table->string('community_id')->after('accumulated_current_amount')->nullable();
          $table->string('tas_id')->after('accumulated_current_amount')->nullable();
          $table->string('zonal_id')->after('accumulated_current_amount')->nullable();
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
          $table->dropColumn('electoral_id');
          $table->dropColumn('community_id');
          $table->dropColumn('town_area_id');
          $table->dropColumn('zonal_id');
        });
    }
}
