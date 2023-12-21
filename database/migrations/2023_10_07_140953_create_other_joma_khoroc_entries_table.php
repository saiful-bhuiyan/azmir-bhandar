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
        Schema::create('other_joma_khoroc_entries', function (Blueprint $table) {
            $table->id()->from(100);
            $table->unsignedBigInteger('other_id');
            $table->foreign('other_id')->references('id')->on('other_joma_khoroc_setups');
            $table->unsignedBigInteger('bank_setup_id')->nullable();
            $table->foreign('bank_setup_id')->references('id')->on('bank_setups');
            $table->unsignedBigInteger('check_id')->nullable();
            $table->foreign('check_id')->references('id')->on('check_book_page_setups');
            $table->integer('type')->comment("1 = জমা & 2 = খরচ");
            $table->string('marfot')->nullable();
            $table->double('taka',10 ,2);
            $table->integer('payment_by')->comment("1 = Cash & 2 = Bank");
            $table->date('entry_date')->nullable();
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
        Schema::dropIfExists('other_joma_khoroc_entries');
    }
};
