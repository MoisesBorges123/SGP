<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificacoesCertidoes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notificacoes_batismo', function (Blueprint $table) {
            $table->id();
            $table->string('texto');
            $table->unsignedBigInteger('certidao');
            $table->unsignedBigInteger('usuario');
            $table->timestamps();

            $table->foreign('certidao')->references('id')->on('certidao_batismo');
            $table->foreign('usuario')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notificacoes_batismo');
    }
}
