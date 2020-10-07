<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLivros extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('livros', function (Blueprint $table) {
            $table->id();
            $table->integer('numero');
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->string('observacao')->nullable();
            $table->unsignedBigInteger('sacramento');
            $table->timestamps();

            $table->foreign('sacramento')->references('id')->on('sacramentos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('livros');
    }
}
