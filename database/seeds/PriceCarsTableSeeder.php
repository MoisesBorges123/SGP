<?php

use Illuminate\Database\Seeder;

class PriceCarsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('price_cars')->delete();
        
        \DB::table('price_cars')->insert(array (
            0 => 
            array (
                'id' => 1,
                'min_15' => 1.0,
                'min_30' => 2.0,
                'min_60' => 3.0,
                'mensalidade' => 180.0,
                'diaria' => 25.0,
                'pernoite' => 30.0,
                'created_at' => '2021-03-03 21:40:53',
                'updated_at' => '2021-03-03 21:40:53',
            ),
            1 => 
            array (
                'id' => 2,
                'min_15' => 1.0,
                'min_30' => 2.0,
                'min_60' => 3.0,
                'mensalidade' => 180.0,
                'diaria' => 25.0,
                'pernoite' => 30.0,
                'created_at' => '2021-03-08 12:57:54',
                'updated_at' => '2021-03-08 12:57:54',
            ),
            2 => 
            array (
                'id' => 3,
                'min_15' => 1.0,
                'min_30' => 2.0,
                'min_60' => 3.0,
                'mensalidade' => 180.0,
                'diaria' => 25.0,
                'pernoite' => 30.0,
                'created_at' => '2021-03-08 12:58:55',
                'updated_at' => '2021-03-08 12:58:55',
            ),
            3 => 
            array (
                'id' => 4,
                'min_15' => 1.0,
                'min_30' => 2.0,
                'min_60' => 3.0,
                'mensalidade' => 180.0,
                'diaria' => 25.0,
                'pernoite' => 30.0,
                'created_at' => '2021-03-08 13:00:11',
                'updated_at' => '2021-03-08 13:00:11',
            ),
        ));
        
        
    }
}