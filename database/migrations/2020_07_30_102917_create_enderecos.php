<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnderecos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('logradouro');
            $table->unsignedBigInteger('pessoa');
            $table->string('numero')->nullable();
            $table->string('apartamento')->nullable();
            $table->string('complemento')->nullable(); //Ponto de referência para chegar até a casa           
            $table->timestamps();

            $table->foreign('logradouro')->references('id')->on('logradouros');
            $table->foreign('pessoa')->references('id')->on('pessoas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enderecos');
    }
}
