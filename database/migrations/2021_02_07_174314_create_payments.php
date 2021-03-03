<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->float('value')->nullable();
            $table->float('discount')->nullable();
            $table->string('justify_discount')->nullable();
            $table->unsignedBigInteger('table_price')->nullable();
            $table->float('payed')->nullable();
            $table->date('date_payed')->nullable();
            $table->string('modality'); //-rotativo | -mensalidade
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
        Schema::dropIfExists('payments');
    }
}
