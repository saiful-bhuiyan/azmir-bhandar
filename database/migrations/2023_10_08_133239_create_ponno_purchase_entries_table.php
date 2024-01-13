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
        Schema::create('ponno_purchase_entries', function (Blueprint $table) {
            $table->id()->from(1000)->comment('Purchase Invoices');
            $table->integer('purchase_type')->comment("1 = নিজ খরিদ & 2 = কমিশন");
            $table->unsignedBigInteger('mohajon_setup_id');
            $table->foreign('mohajon_setup_id')->references('id')->on('mohajon_setups');
            $table->unsignedBigInteger('ponno_setup_id');
            $table->foreign('ponno_setup_id')->references('id')->on('ponno_setups');
            $table->unsignedBigInteger('size_id')->nullable();
            $table->foreign('size_id')->references('id')->on('ponno_size_setups');
            $table->unsignedBigInteger('marka_id')->nullable();
            $table->foreign('marka_id')->references('id')->on('ponno_marka_setups');
            $table->string('gari_no')->nullable();
            $table->integer('quantity');
            $table->double('weight' ,10 ,2);
            $table->double('rate' ,10 ,2)->nullable();
            $table->double('labour_cost' ,10 ,2)->nullable();
            $table->double('other_cost' ,10 ,2)->nullable();
            $table->double('truck_cost' ,10 ,2)->nullable();
            $table->double('van_cost' ,10 ,2)->nullable();
            $table->double('tohori_cost' ,10 ,2)->nullable();
            $table->double('mohajon_commission' ,10 ,2)->nullable();
            $table->date('entry_date')->nullable();
            $table->date('cost_date')->nullable();
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
        Schema::dropIfExists('ponno_purchase_entries');
    }
};
