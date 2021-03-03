<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parking', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment')->nullable();
            $table->unsignedBigInteger('time');
            $table->unsignedBigInteger('vehicle');            
            $table->timestamps();

            $table->foreign('payment')->references('id')->on('payments');
            $table->foreign('time')->references('id')->on('timeparking');
            $table->foreign('vehicle')->references('id')->on('vehicle');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parking');
    }
}
