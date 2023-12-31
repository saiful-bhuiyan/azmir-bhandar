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
        Schema::create('check_book_page_setups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('check_id');
            $table->foreign('check_id')->references('id')->on('bank_check_book_setups');
            $table->bigInteger('page');
            $table->date('deleted_at')->nullable();
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
        Schema::dropIfExists('check_book_page_setups');
    }
};
