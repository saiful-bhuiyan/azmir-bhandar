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
        Schema::create('mohajon_commission_setups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ponno_setup_id');
            $table->foreign('ponno_setup_id')->references('id')->on('ponno_setups');
            $table->double('commission_amount', 10, 2);
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
        Schema::dropIfExists('mohajon_commission_setups');
    }
};
