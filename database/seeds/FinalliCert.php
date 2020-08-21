<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FinalliCert extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('finalidades_certidao')->delete();
        DB::table('finalidades_certidao')->insert(
            [ 
                ['finalidade'=>'Fins matrimonias'],
                ['finalidade'=>'Fins sociais'],
                ['finalidade'=>'Fins religiosos']
            ]
        );
    }
}
