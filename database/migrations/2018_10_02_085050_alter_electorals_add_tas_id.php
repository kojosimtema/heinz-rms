<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterElectoralsAddTasId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('electorals', function (Blueprint $table) {
            $table->string('tas_id')->after('zonal_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('electorals', function (Blueprint $table) {
            $table->dropColumn('tas_id');
        });
    }
}
