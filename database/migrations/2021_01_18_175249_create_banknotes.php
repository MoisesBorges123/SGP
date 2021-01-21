<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBanknotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banknotes', function (Blueprint $table) {
            $table->id();
            $table->integer('2');
            $table->integer('5');
            $table->integer('10');
            $table->integer('20');
            $table->integer('50');
            $table->integer('100');
            $table->float('check');
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
        Schema::dropIfExists('banknotes');
    }
}
