<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEnumGCRAddCashierId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('enum_gcrs', function (Blueprint $table) {
            $table->string('id_cashier')->after('id_collector')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('enum_gcrs', function (Blueprint $table) {
            $table->dropColumn('id_cashier');
        });
    }
}
