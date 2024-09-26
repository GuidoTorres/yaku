<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSamplingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('samplings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sampling_point_id');
            $table->foreign('sampling_point_id')->references('id')->on('sampling_points')->onDelete('cascade');
            $table->string('utm_zone');
            $table->string('north');
            $table->string('east');
            $table->string('latitude');
            $table->string('longitude');
            $table->dateTime('sampling_date');
            $table->unsignedBigInteger('deep_id');
            $table->foreign('deep_id')->references('id')->on('deeps');
            $table->unsignedBigInteger('user_created_id');
            $table->foreign('user_created_id')->references('id')->on('users');
            $table->unsignedBigInteger('user_approved_id')->nullable();
            $table->foreign('user_approved_id')->references('id')->on('users');


            $table->enum('state', [
                \App\Sampling::FOR_APPROVAL,
                \App\Sampling::APPROVED,
                \App\Sampling::DISAPPROVED
            ])->default(\App\Sampling::FOR_APPROVAL);
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
        Schema::dropIfExists('samplings');
    }
}
