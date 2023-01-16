<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnumGcrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enum_gcrs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('stock_id')->nullable();
            $table->string('gcr_number')->nullable();
            $table->boolean('is_used')->default(0);
            $table->boolean('is_damaged')->default(0);
            $table->boolean('is_returned')->default(0);
            $table->string('id_collector')->nullable();
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
        Schema::dropIfExists('enum_gcrs');
    }
}
