<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ViewParkingCars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::statement(
            "CREATE VIEW parking_cars as 
            select 
                vehicle.id as 'vehicle_id',
                vehicle.placa as 'placa',                
                parking.id as 'parking_id',
                pessoas.nome as 'owner',
                pessoas.id as 'owner_id',
                payments.id as 'payment_id',
                payments.modality as 'modality',
                timeparking.id as 'timeparking_id',
                timeparking.hour_in as 'hour_in',
                timeparking.min_in as 'min_in',
                timeparking.date_in as 'date_in',
                vehicle.typevehicle as 'typevehicle'
            
            from
                parking
                
                LEFT JOIN vehicle
                ON vehicle.id = parking.vehicle
                LEFT JOIN pessoas
                ON pessoas.id = vehicle.pessoa
                LEFT JOIN timeparking
                on timeparking.id = parking.time
                LEFT JOIN payments
                on payments.id = parking.payment
                where 
                timeparking.hour_out is null
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
        DB::statement('DROP VIEW parking_cars');
    }
}
