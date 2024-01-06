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
        Schema::create('arod_chotha_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_id');
            $table->foreign('purchase_id')->references('id')->on('ponno_purchase_entries');
            $table->double('labour_cost' ,10 ,2)->nullable();
            $table->double('other_cost' ,10 ,2)->nullable();
            $table->double('truck_cost' ,10 ,2)->nullable();
            $table->double('van_cost' ,10 ,2)->nullable();
            $table->double('tohori_cost' ,10 ,2)->nullable();
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
        Schema::dropIfExists('arod_chotha_infos');
    }
};
