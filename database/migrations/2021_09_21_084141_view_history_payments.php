<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ViewHistoryPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(" 
            
            CREATE VIEW history_payments as              
            select 
            SUM(sgp.payments.value) as cash, 
            SUM(payments.discount) as discount, 
            payments.date_payed 
            from 
            ((((parking left join vehicle on((vehicle.id = sgp.parking.vehicle)))
             left join pessoas on((pessoas.id = vehicle.pessoa))) 
             left join timeparking on((timeparking.id = parking.time))) 
             left join payments on((payments.id = parking.payment))) 
             GROUP BY sgp.payments.date_payed
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW parking_cars');
    }
}
