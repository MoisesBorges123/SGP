<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CertidaoBatismoTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('certidao_batismo')->delete();
        
        DB::table('certidao_batismo')->insert(array (
            0 => 
            array (
                'id' => 1,
                'crianca' => 1,
                'mae' => 3,
                'pai' => 2,
                'padrinho' => 5,
                'madrinha' => 4,
                'celebrante' => 13,
                'livro' => '12',
                'folha' => '14v',
                'data_batizado' => '2020-08-17',
                'local_batizado' => 'Paroquia Catedral Imaculada Conceição',
                'duvidoso' => 1,
                'created_at' => '2020-08-18 00:22:42',
                'updated_at' => '2020-08-18 00:22:42',
            ),
            1 => 
            array (
                'id' => 2,
                'crianca' => 7,
                'mae' => 9,
                'pai' => 8,
                'padrinho' => 11,
                'madrinha' => 10,
                'celebrante' => 13,
                'livro' => '104',
                'folha' => '123v',
                'data_batizado' => '2020-08-18',
                'local_batizado' => 'Paroquia Catedral Imaculada Conceição',
                'duvidoso' => 1,
                'created_at' => '2020-08-19 11:20:02',
                'updated_at' => '2020-08-19 12:35:42',
            ),
            2 => 
            array (
                'id' => 3,
                'crianca' => 14,
                'mae' => 16,
                'pai' => 15,
                'padrinho' => 18,
                'madrinha' => 17,
                'celebrante' => 19,
                'livro' => '107',
                'folha' => '113',
                'data_batizado' => '2020-08-19',
                'local_batizado' => 'Paroquia Santo Antônio',
                'duvidoso' => 1,
                'created_at' => '2020-08-19 13:25:01',
                'updated_at' => '2020-08-19 13:25:01',
            ),
        ));
        
        
    }
}