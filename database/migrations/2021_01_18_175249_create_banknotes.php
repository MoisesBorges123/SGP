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
            $table->integer('n2');
            $table->integer('n5');
            $table->integer('n10');
            $table->integer('n20');
            $table->integer('n50');
            $table->integer('n100');
            $table->float('check_paper');
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
