<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContagem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contagem', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('coin');
            $table->unsignedBigInteger('banknote');
            $table->unsignedBigInteger('categor');
            $table->date('referer');
            $table->string('ip_device');

            $table->timestamps();
            $table->foreign('coin')->references('id')->on('coins');
            $table->foreign('banknote')->references('id')->on('banknotes');
            $table->foreign('categor')->references('id')->on('countcategor');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contagem');
    }
}
