<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SacramentosSeeder extends Seeder
{
    
    public function run()
    {
        DB::table('sacramentos')->delete();
        DB::table('sacramentos')->insert([ 
            ['id'=>1,'nome'=>'Batizado','created_at'=>date('Y-m-d H:i:s',time())],
            ['id'=>2,'nome'=>'Crisma','created_at'=>date('Y-m-d H:i:s',time())],
            ['id'=>3,'nome'=>'Casamento','created_at'=>date('Y-m-d H:i:s',time())]
        ]);

    }
}
