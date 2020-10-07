<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFotosLivro extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fotos_livro', function (Blueprint $table) {
            $table->id();
            $table->string('foto');
            $table->float('tamanho');
            $table->string('caminho');
            $table->unsignedBigInteger('pagina');

            $table->foreign('pagina')->references('id')->on('paginas');
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
        Schema::dropIfExists('fotos_livro');
    }
}
