<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmissaoCertBatismo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emissa_cert_batismo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('certidao');
            $table->unsignedBigInteger('finalidade');
            $table->timestamps();

            $table->foreign('finalidade')->references('id')->on('finalidades_certidao');
            $table->foreign('certidao')->references('id')->on('certidao_batismo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emissa_cert_batismo');
    }
}
