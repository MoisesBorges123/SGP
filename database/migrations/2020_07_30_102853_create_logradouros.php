<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogradouros extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logradouros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estado');
            $table->string('rua');
            $table->string('bairro');
            $table->string('cep');
            $table->string('cidade');
            $table->string('complemento')->nullable(); //Complementos vindos do código do cep (Correios)
            $table->string('dd_local')->nullable();
            $table->string('ibge')->nullable(); //Numero do IBGE da localidade.
            $table->timestamps();

            $table->foreign('estado')->references('id')->on('estados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logradouros');
    }
}
