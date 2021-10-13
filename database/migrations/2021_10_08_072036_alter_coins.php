<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class AlterCoins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //ALTER TABLE coins ADD total double AS (m25 + m100)
        DB::statement(
            "ALTER TABLE coins ADD 
            total DOUBLE AS 
            ( (m5*0.05)+(m10*0.1)+(m25*0.25)+(m50*0.5)+(m100*1))     
            "       
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    
    }
}
