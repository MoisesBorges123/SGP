<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class AlterBanknotesDefaultValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //ALTER TABLE `banknotes` CHANGE `n2` `n2` INT(11) NOT NULL DEFAULT '0', CHANGE `n5` `n5` INT(11) NOT NULL DEFAULT '0', CHANGE `n10` `n10` INT(11) NOT NULL DEFAULT '0', CHANGE `n20` `n20` INT(11) NOT NULL DEFAULT '0', CHANGE `n50` `n50` INT(11) NOT NULL DEFAULT '0', CHANGE `n100` `n100` INT(11) NOT NULL DEFAULT '0', CHANGE `check_paper` `check_paper` DOUBLE(8,2) NULL DEFAULT '0';
        DB::statement(
            "ALTER TABLE `banknotes` 
            CHANGE `n2` `n2` INT(11) NOT NULL DEFAULT '0', 
            CHANGE `n5` `n5` INT(11) NOT NULL DEFAULT '0', 
            CHANGE `n10` `n10` INT(11) NOT NULL DEFAULT '0', 
            CHANGE `n20` `n20` INT(11) NOT NULL DEFAULT '0', 
            CHANGE `n50` `n50` INT(11) NOT NULL DEFAULT '0', 
            CHANGE `n100` `n100` INT(11) NOT NULL DEFAULT '0', 
            CHANGE `check_paper` `check_paper` DOUBLE(10,2) NULL DEFAULT '0'            
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
