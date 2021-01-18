<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertidoesCrisma extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certidao_crisma', function (Blueprint $table) {
            $table->id();            
            $table->unsignedBigInteger('pai')->nullable();
            $table->unsignedBigInteger('mae')->nullable();
            $table->unsignedBigInteger('padrinho')->nullable();
            $table->unsignedBigInteger('crismando');
            $table->date('data_crisma');
            $table->string('livro')->nullable();
            $table->string('folha')->nullable();
            $table->boolean('duvidoso')->nullable();
            $table->timestamps();
            //$table->foreign('livro')->references('id')->on('livros');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('certidao_crisma');
    }
}
