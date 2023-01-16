<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('contact_info_text')->nullable();
            $table->text('enforce_law_text')->nullable();
            $table->string('authority_person')->nullable();
            $table->string('signature')->nullable();
            $table->string('logo')->nullable();
            $table->dateTime('paymet_date')->nullable();
            $table->string('organization_type')->nullable();
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
        Schema::dropIfExists('bill_settings');
    }
}
