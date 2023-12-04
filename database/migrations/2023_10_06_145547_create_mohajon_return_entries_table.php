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
        Schema::create('mohajon_return_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mohajon_setup_id');
            $table->foreign('mohajon_setup_id')->references('id')->on('mohajon_setups');
            $table->unsignedBigInteger('bank_setup_id')->nullable();
            $table->foreign('bank_setup_id')->references('id')->on('bank_setups');
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
        Schema::dropIfExists('mohajon_return_entries');
    }
};
