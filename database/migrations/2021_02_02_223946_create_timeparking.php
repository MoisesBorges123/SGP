<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeparking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timeparking', function (Blueprint $table) {
            $table->id();
            $table->string('hour_in');
            $table->string('hour_out')->nullable();
            $table->string('min_in');
            $table->string('min_out')->nullable();
            $table->date('date_in');
            $table->date('date_out')->nullable();
            $table->unsignedBigInteger('church_time')->nullable();
            $table->timestamps();

            $table->foreign('church_time')->references('id')->on('church_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timeparking');
    }
}
