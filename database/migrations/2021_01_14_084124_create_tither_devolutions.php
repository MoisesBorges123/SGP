<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTitherDevolutions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tither_devolutions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tither');
            $table->float('amoutn');
            $table->string('year');
            $table->string('month');
            $table->string('location')->nullable();
            $table->timestamps();

            $table->foreign('tither')->references('id')->on('tithers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tither_devolutions');
    }
}
