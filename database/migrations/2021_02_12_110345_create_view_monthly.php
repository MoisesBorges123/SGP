<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateViewMonthly extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     
        DB::statement(
            "CREATE VIEW monthlyview as 
            select 
                vehicle.id as 'vehicle_id',
                vehicle.typevehicle as 'typevehicle',
                vehicle.placa as 'placa',
                parking.id as 'parking_id',
                pessoas.nome as 'owner',
                pessoas.id as 'owner_id',
                payments.id as 'payment_id',
                timeparking.date_in as 'beginning',
                timeparking.date_out as 'end'

            from 
                parking,
                payments,
                vehicle,
                pessoas,
                timeparking
                
            where 
                timeparking.id = parking.time and
                parking.payment!='' and
                payments.modality='Mensalidade' and
                parking.payment = payments.id and
                vehicle.id = parking.vehicle and
                vehicle.pessoa = pessoas.id
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
    
        //Schema::dropView('monthlyview');
        DB::statement("DROP VIEW monthlyview");
    }
}
