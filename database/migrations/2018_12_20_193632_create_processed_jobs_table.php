<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcessedJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processed_jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('job_id');
            $table->string('title');
            $table->boolean('is_completed')->default(0);
            $table->integer('total');
            $table->integer('count');
            $table->integer('percentage');
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
        Schema::dropIfExists('processed_jobs');
    }
}
