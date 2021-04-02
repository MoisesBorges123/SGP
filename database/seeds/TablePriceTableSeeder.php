<?php

use Illuminate\Database\Seeder;

class TablePriceTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('table_price')->delete();
        
        \DB::table('table_price')->insert(array (
            0 => 
            array (
                'id' => 1,
                'car_price' => 1,
                'motocycle_price' => 1,
                'created_at' => '2021-03-03 21:40:54',
                'updated_at' => '2021-03-03 21:40:54',
            ),
            1 => 
            array (
                'id' => 2,
                'car_price' => 2,
                'motocycle_price' => 2,
                'created_at' => '2021-03-08 12:57:55',
                'updated_at' => '2021-03-08 12:57:55',
            ),
            2 => 
            array (
                'id' => 3,
                'car_price' => 3,
                'motocycle_price' => 3,
                'created_at' => '2021-03-08 12:58:55',
                'updated_at' => '2021-03-08 12:58:55',
            ),
            3 => 
            array (
                'id' => 4,
                'car_price' => 4,
                'motocycle_price' => 4,
                'created_at' => '2021-03-08 13:00:11',
                'updated_at' => '2021-03-08 13:00:11',
            ),
        ));
        
        
    }
}