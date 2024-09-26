<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSamplingPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sampling_points', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('hidrographic_unit');
            $table->string('utm_zone');
            $table->string('north');
            $table->string('east');
            $table->string('latitude');
            $table->string('longitude');
            $table->unsignedBigInteger('eca_id');
            $table->foreign('eca_id')->references('id')->on('ecas');
            $table->unsignedBigInteger('basin_id');
            $table->foreign('basin_id')->references('id')->on('basins');
            $table->unsignedBigInteger('reservoir_id');
            $table->foreign('reservoir_id')->references('id')->on('reservoirs');
            $table->unsignedBigInteger('zone_id');
            $table->foreign('zone_id')->references('id')->on('zones');
            $table->unsignedBigInteger('user_created');
            $table->foreign('user_created')->references('id')->on('users');
            $table->tinyInteger('type')->default(\App\SamplingPoint::FIXED_POINT);
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
        Schema::dropIfExists('sampling_points');
    }
}
