<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAddOtherStockFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->boolean('is_used')->default(0);
            $table->boolean('is_damaged')->default(0);
            $table->boolean('in_stock')->default(1);
            $table->boolean('is_missing')->default(0);
            $table->boolean('is_returned')->default(0);
            $table->dateTime('date_returned')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->dropColumn(['is_used', 'is_damaged', 'in_stock', 'is_missing', 'is_returned', 'date_returned']);
        });
    }
}
