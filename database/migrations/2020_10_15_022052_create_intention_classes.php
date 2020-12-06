<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntentionClasses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intention_classes', function (Blueprint $table) {
            //['id'=>8,'classe'=>'Pela graça alcançada','typeintention'=>2,'print_position'=>8,'empty_lines'=>0,'created_at'=>date('Y-m-d H:i:s',time())],             
            $table->id();
            $table->string('classe');
            $table->unsignedBigInteger('typeintention');
            $table->integer('print_position');
            $table->integer('empty_lines');
            $table->timestamps();

            $table->foreign('typeintention')->references('id')->on('group_intentions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('intention_classes');
    }
}
