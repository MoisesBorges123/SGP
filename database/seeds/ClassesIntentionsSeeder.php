<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ClassesIntentionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('intention_classes')->delete();
        DB::table('intention_classes')->insert([ 
            ['id'=>1,'classe'=>'7º dia','typeintention'=>1,'print_position'=>1,'empty_lines'=>2,'created_at'=>date('Y-m-d H:i:s',time())],
            ['id'=>2,'classe'=>'30º dia','typeintention'=>1,'print_position'=>2,'empty_lines'=>2,'created_at'=>date('Y-m-d H:i:s',time())],
            ['id'=>3,'classe'=>'Falecidos','typeintention'=>1,'print_position'=>3,'empty_lines'=>3,'created_at'=>date('Y-m-d H:i:s',time())],             
            ['id'=>4,'classe'=>'Pela saúde','typeintention'=>3,'print_position'=>4,'empty_lines'=>0,'created_at'=>date('Y-m-d H:i:s',time())],             
            ['id'=>5,'classe'=>'Pelo aniversário','typeintention'=>2,'print_position'=>5,'empty_lines'=>2,'created_at'=>date('Y-m-d H:i:s',time())],             
            ['id'=>6,'classe'=>'Pelo casamento','typeintention'=>2,'print_position'=>6,'empty_lines'=>0,'created_at'=>date('Y-m-d H:i:s',time())],             
            ['id'=>7,'classe'=>'Pela graduação','typeintention'=>2,'print_position'=>7,'empty_lines'=>0,'created_at'=>date('Y-m-d H:i:s',time())],             
            ['id'=>8,'classe'=>'Pela graça alcançada','typeintention'=>2,'print_position'=>8,'empty_lines'=>0,'created_at'=>date('Y-m-d H:i:s',time())],             
            
        ]);
    }
}
