<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class AlterCoinsDefaultValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //ALTER TABLE `coins` CHANGE `m5` `m5` INT(11) NOT NULL DEFAULT '0', CHANGE `m10` `m10` INT(11) NOT NULL DEFAULT '0', CHANGE `m25` `m25` INT(11) NOT NULL DEFAULT '0', CHANGE `m50` `m50` INT(11) NOT NULL DEFAULT '0', CHANGE `m100` `m100` INT(11) NOT NULL DEFAULT '0';
        DB::statement(
            "ALTER TABLE `coins` 
            CHANGE `m5` `m5` INT(11) NOT NULL DEFAULT '0', 
            CHANGE `m10` `m10` INT(11) NOT NULL DEFAULT '0', 
            CHANGE `m25` `m25` INT(11) NOT NULL DEFAULT '0', 
            CHANGE `m50` `m50` INT(11) NOT NULL DEFAULT '0', 
            CHANGE `m100` `m100` INT(11) NOT NULL DEFAULT '0'
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
