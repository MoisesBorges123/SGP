<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntentions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intentions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person');
            $table->unsignedBigInteger('scope');            
            $table->timestamps();

            $table->foreign('person')->references('id')->on('pessoas');
            $table->foreign('scope')->references('id')->on('intention_scopes');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('intentions');
    }
}
