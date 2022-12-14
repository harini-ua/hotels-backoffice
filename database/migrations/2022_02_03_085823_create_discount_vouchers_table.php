<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('voucher_type')->comment('1-individual, 2-for all');
            $table->bigInteger('voucher_codes_count');
            $table->double('amount', 8, 2)->comment('in currency or %');
            $table->boolean('amount_type')->comment('0-fixed, 1-percent');
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->text('description')->nullable();
            $table->tinyInteger('commission_type')->default(1)->comment('1-company booking commission, 2-company booking & company sale commissions, 3-company sale commission');
            $table->double('min_price', 8, 2)->comment('minimal booking price in EUR');
            $table->date('expiry')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('currency_id')->references('id')->on('currencies');
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
        Schema::dropIfExists('discount_vouchers');
    }
}
