<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpportunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opportunities', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('code');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->unsignedBigInteger('opportunity_type_id');
            $table->foreign('opportunity_type_id')->references('id')->on('opportunity_types');
            $table->unsignedBigInteger('campaign_id');
            $table->foreign('campaign_id')->references('id')->on('campaigns');
            $table->unsignedBigInteger('user_owner_id');
            $table->foreign('user_owner_id')->references('id')->on('users');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('stage_id');
            $table->foreign('stage_id')->references('id')->on('stages');
            $table->unsignedBigInteger('company_contact_id');
            $table->foreign('company_contact_id')->references('id')->on('company_contacts');

            $table->float('budget',8,2)->nullable();
            $table->float('service_price',8,2)->nullable();
            $table->unsignedMediumInteger('order');
            $table->dateTime('order_updated_at');
            $table->unsignedMediumInteger('probability');
            $table->dateTime('closed_at')->nullable();
            $table->string('quotation')->nullable();
            $table->string('contract')->nullable();
            $table->string('work_order')->nullable();


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
        Schema::dropIfExists('opportunities');
    }
}
