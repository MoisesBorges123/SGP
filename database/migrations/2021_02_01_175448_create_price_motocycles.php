<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceMotocycles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_motocycles', function (Blueprint $table) {
            $table->id();
            $table->float('min_15');
            $table->float('min_30');
            $table->float('min_60');
            $table->float('mensalidade');
            $table->float('diaria');
            $table->float('pernoite');
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
        Schema::dropIfExists('price_motocycles');
    }
}
