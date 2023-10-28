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
        Schema::create('kreta_koifiyot_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kreta_setup_id');
            $table->foreign('kreta_setup_id')->references('id')->on('kreta_setups');
            $table->string('marfot')->nullable();
            $table->double('taka',10 ,2);
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
        Schema::dropIfExists('kreta_koifiyot_entries');
    }
};
