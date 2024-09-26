<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcaParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eca_parameters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('eca_id');
            $table->foreign('eca_id')->references('id')->on('ecas');
            $table->unsignedBigInteger('parameter_id');
            $table->foreign('parameter_id')->references('id')->on('parameters');
            $table->double('min_value')->nullable();
            $table->double('max_value')->nullable();
            $table->string('allowed_value')->nullable();

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
        Schema::dropIfExists('eca_parameters');
    }
}
