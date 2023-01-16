<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBillsAddAccumulated extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bills', function (Blueprint $table) {
            $table->string('accumulated_current_amount')->after('adjust_arrears')->nullable();
            $table->string('accumulated_arrears')->after('adjust_arrears')->nullable();
            $table->string('accumulated_account_balance')->after('adjust_arrears')->nullable();
            $table->string('accumulated_adjust_arrears')->after('adjust_arrears')->nullable();
            $table->string('accumulated_total_paid')->after('adjust_arrears')->nullable();
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
            $table->dropColumn(['accumulated_current_amount','accumulated_arrears','accumulated_account_balance', 'accumulated_adjust_arrears', 'accumulated_total_paid']);
        });
    }
}
