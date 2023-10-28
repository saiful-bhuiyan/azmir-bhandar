<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_check_book_setups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bank_setup_id');
            $table->foreign('bank_setup_id')->references('id')->on('bank_setups');
            $table->string('page_from');
            $table->string('page_to');
            $table->integer('total_page');
            $table->integer('status')->default(1)->comment("0 = Inactive & 1 = Active");
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
        Schema::dropIfExists('bank_check_book_setups');
    }
};
