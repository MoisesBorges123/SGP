<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class GroupIntentionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('group_intentions')->delete();
        DB::table('group_intentions')->insert([ 
            ['id'=>1,'name'=>'Falecidos','created_at'=>date('Y-m-d H:i:s',time())],
            ['id'=>2,'name'=>'Ação de Graças','created_at'=>date('Y-m-d H:i:s',time())],
            ['id'=>3,'name'=>'Saúde','created_at'=>date('Y-m-d H:i:s',time())],             
            
        ]);
    }
}
