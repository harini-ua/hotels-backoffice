<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyBookingCommissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_booking_commission', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->mediumInteger('standard_commission');
            $table->mediumInteger('booking_commission');
            $table->mediumInteger('payback_to_client');
            $table->double('minimal_commission', 8, 2);
            $table->boolean('use_minimal_commission')->default(0)->comment('0-do not use
            minimal_commission, 1- use minimal_commission');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_booking_commission');
    }
}
