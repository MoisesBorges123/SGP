<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CountCategorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ADICIONAR A CLASSE DB E INSERIR O NOME REAL DA TABELA
        DB::table('countcategor')->delete();
        DB::table('countcategor')->insert([ 
            ['id'=>1,'nome'=>'Dízimo'],
            ['id'=>2,'nome'=>'Oferta'],
            ['id'=>3,'nome'=>'Estacionamento'],
            ['id'=>4,'nome'=>'Doação'],
            ['id'=>5,'nome'=>'O.V.S'],
            ['id'=>6,'nome'=>'Festa'],
            ['id'=>7,'nome'=>'Campanha'],
            ['id'=>8,'nome'=>'Venda de Bens'],
        ]);
    }
}
