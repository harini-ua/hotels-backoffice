<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountVouchersCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_vouchers_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('discount_voucher_id');
            $table->string('code', 50);
            $table->boolean('status')->comment('0-used, 1-not used')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('discount_voucher_id')->references('id')->on('discount_vouchers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_vouchers_codes');
    }
}
