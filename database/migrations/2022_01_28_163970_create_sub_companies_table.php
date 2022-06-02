<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->unique();
            $table->unsignedBigInteger('company_id');
            $table->integer('commission');
            $table->tinyInteger('status')->default(1)
                ->comment('0-inactive, 1-active');
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
        Schema::dropIfExists('sub_companies');
    }
}
