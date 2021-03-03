<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle', function (Blueprint $table) {
            $table->id();
            $table->string('modelo')->nullable();            
            $table->string('placa');            
            $table->string('cor')->nullable();            
            $table->unsignedBigInteger('pessoa')->nullable();
            $table->string('descricao')->nullable();            
            $table->boolean('insencao')->nullable();  
            $table->unsignedBigInteger('typevehicle');
            $table->timestamps();

            $table->foreign('typevehicle')->references('id')->on('typevehicle');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle');
    }
}
