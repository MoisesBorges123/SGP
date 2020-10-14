<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertidaoCasamento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certidao_casamento', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('noivo');
            $table->unsignedBigInteger('noiva');
            $table->unsignedBigInteger('celebrante')->nullable();
            $table->date('data_casamento');
            $table->string('local_casamento')->nullable();
            $table->string('folha')->nullable();
            $table->string('livro')->nullable();
            $table->boolean('duvidoso')->nullable();
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
        Schema::dropIfExists('certidao_casamento');
    }
}
