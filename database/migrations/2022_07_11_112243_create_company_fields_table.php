<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_fields', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('type')->default(0)
                ->comment('0 => text field, 1=> text area, 2=>button, 3 => HTML content');
            $table->smallInteger('max_length')->default(25)
                ->comment('maximum character length for the field name');
            $table->tinyInteger('is_mobile')->default(0)
                ->comment('0 => Existing verbals, 1 => Web2 Verbals, 2 => Mobile Verbals');
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
        Schema::dropIfExists('company_fields');
    }
}
