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
        Schema::create('ponno_sales_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sales_invoice');
            $table->foreign('sales_invoice')->references('id')->on('ponno_sales_infos');
            $table->unsignedBigInteger('purchase_id');
            $table->foreign('purchase_id')->references('id')->on('ponno_purchase_entries');
            $table->double('sales_qty');
            $table->double('sales_weight');
            $table->double('sales_rate');
            $table->double('labour')->nullable();
            $table->double('other')->nullable();
            $table->double('kreta_commission')->nullable();
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
        Schema::dropIfExists('ponno_sales_entries');
    }
};
