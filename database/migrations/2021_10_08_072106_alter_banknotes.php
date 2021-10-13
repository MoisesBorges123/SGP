<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class AlterBanknotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(
            "ALTER TABLE banknotes ADD 
            total DOUBLE AS 
            ( (n2*2)+(n5*5)+(n10*10)+(n20*20)+(n50*50)+(n100*100)+check_paper)     
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
        //
    }
}
