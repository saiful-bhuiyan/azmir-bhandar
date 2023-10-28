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
        Schema::create('ponno_sales_infos', function (Blueprint $table) {
            $table->id()->from(1000)->comment('Sales Invoices');
            $table->integer('sales_type');
            $table->unsignedBigInteger('kreta_setup_id')->nullable();
            $table->foreign('kreta_setup_id')->references('id')->on('kreta_setups');
            $table->string('cash_kreta_address')->nullable();
            $table->string('cash_kreta_name')->nullable();
            $table->double('discount', 10,2)->nullable();
            $table->string('marfot')->nullable();
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
        Schema::dropIfExists('ponno_sales_infos');
    }
};
