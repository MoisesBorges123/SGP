<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('payments')->delete();
        DB::table('payments')->insert([ 
            ['id'=>1,'value'=>0,'discount'=>0,'justify_discount'=>'Carro isento','payed'=>0,'date_payed'=>date('Y-m-d',time()),'modality'=>'Free','created_at'=>date('Y-m-d H:i:s',time())],            
            
        ]);
    }
}
