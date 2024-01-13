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
        Schema::create('ponno_purchase_cost_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_id');
            $table->foreign('purchase_id')->references('id')->on('ponno_purchase_entries');
            $table->integer('cost_name')->comment('1 = Labour Cost & 2 = Other Cost & 3 = Truck Cost & 4 = Van Cost & 5 = Tohori Cost');
            $table->double('taka' ,10 ,2)->nullable();
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
        Schema::dropIfExists('ponno_purchase_cost_entries');
    }
};
