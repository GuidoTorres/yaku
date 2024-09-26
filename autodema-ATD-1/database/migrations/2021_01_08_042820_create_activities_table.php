<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('activity_type_id');
            $table->foreign('activity_type_id')->references('id')->on('activity_types');
            $table->unsignedBigInteger('opportunity_id');
            $table->foreign('opportunity_id')->references('id')->on('opportunities');
            $table->unsignedBigInteger('user_id');
            $table->foreign('company_contact_id')->references('id')->on('company_contacts');
            $table->unsignedBigInteger('company_contact_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('name');
            $table->text('description');
            $table->dateTime('did_at');

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
        Schema::dropIfExists('activities');
    }
}
