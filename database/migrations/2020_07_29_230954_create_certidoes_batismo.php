<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertidoesBatismo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certidao_batismo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('crianca');
            $table->unsignedBigInteger('mae')->nullable();
            $table->unsignedBigInteger('pai')->nullable();
            $table->unsignedBigInteger('padrinho')->nullable();
            $table->unsignedBigInteger('madrinha')->nullable();
            $table->unsignedBigInteger('celebrante')->nullable();
            $table->string('livro')->nullable();
            $table->string('folha')->nullable();
            $table->date('data_batizado')->nullable();            
            $table->string('local_batizado')->nullable();
            $table->boolean('duvidoso')->nullable();
            $table->timestamps();
            
            $table->foreign('crianca')->references('id')->on('pessoas');
            $table->foreign('mae')->references('id')->on('pessoas');
            $table->foreign('pai')->references('id')->on('pessoas');
            $table->foreign('padre')->references('id')->on('pessoas');
            $table->foreign('padrinho')->references('id')->on('pessoas');
            $table->foreign('madrinha')->references('id')->on('pessoas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('certidao_batismo');
    }
}
