<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntentionScopes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intention_scopes', function (Blueprint $table) {
            $table->id();
            $table->date('date_schedule');
            $table->string('time_schedule');
            $table->unsignedBigInteger('claimant')->nullable(); 
            $table->string('observations')->nullable();
            $table->string('complemnt')->nullable();
            $table->unsignedBigInteger('classification');
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
        Schema::dropIfExists('intention_scopes');
    }
}
