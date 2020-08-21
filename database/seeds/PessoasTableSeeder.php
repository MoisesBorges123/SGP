<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class PessoasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('certidao_batismo')->delete();
        DB::table('pessoas')->delete();
        
        DB::table('pessoas')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nome' => 'Moisés Alves Borges',
                'identidade' => NULL,
                'cpf' => NULL,
                'data_nascimento' => '2020-08-02',
                'ctps' => NULL,
                'titulo_eleitoral' => NULL,
                'created_at' => '2020-08-18 00:21:07',
                'updated_at' => '2020-08-18 00:21:07',
            ),
            1 => 
            array (
                'id' => 2,
                'nome' => 'Geraldo Luiz Norges',
                'identidade' => NULL,
                'cpf' => NULL,
                'data_nascimento' => NULL,
                'ctps' => NULL,
                'titulo_eleitoral' => NULL,
                'created_at' => '2020-08-18 00:21:07',
                'updated_at' => '2020-08-18 00:21:07',
            ),
            2 => 
            array (
                'id' => 3,
                'nome' => 'Ilza Alves Borges',
                'identidade' => NULL,
                'cpf' => NULL,
                'data_nascimento' => NULL,
                'ctps' => NULL,
                'titulo_eleitoral' => NULL,
                'created_at' => '2020-08-18 00:21:07',
                'updated_at' => '2020-08-18 00:21:07',
            ),
            3 => 
            array (
                'id' => 4,
                'nome' => 'Fátima da Silva Pereira',
                'identidade' => NULL,
                'cpf' => NULL,
                'data_nascimento' => NULL,
                'ctps' => NULL,
                'titulo_eleitoral' => NULL,
                'created_at' => '2020-08-18 00:21:07',
                'updated_at' => '2020-08-18 00:21:07',
            ),
            4 => 
            array (
                'id' => 5,
                'nome' => 'Cesar da Silva Pereira',
                'identidade' => NULL,
                'cpf' => NULL,
                'data_nascimento' => NULL,
                'ctps' => NULL,
                'titulo_eleitoral' => NULL,
                'created_at' => '2020-08-18 00:21:07',
                'updated_at' => '2020-08-18 00:21:07',
            ),
            5 => 
            array (
                'id' => 6,
                'nome' => 'Serafim Magalhães Junior',
                'identidade' => NULL,
                'cpf' => NULL,
                'data_nascimento' => NULL,
                'ctps' => NULL,
                'titulo_eleitoral' => NULL,
                'created_at' => '2020-08-18 00:21:07',
                'updated_at' => '2020-08-18 00:21:07',
            ),
            6 => 
            array (
                'id' => 7,
                'nome' => 'Criança -Teste',
                'identidade' => NULL,
                'cpf' => NULL,
                'data_nascimento' => '2020-08-04',
                'ctps' => NULL,
                'titulo_eleitoral' => NULL,
                'created_at' => '2020-08-19 11:20:02',
                'updated_at' => '2020-08-19 11:20:02',
            ),
            7 => 
            array (
                'id' => 8,
                'nome' => 'Juliana Pereira da Silva Christina Mendes',
                'identidade' => NULL,
                'cpf' => NULL,
                'data_nascimento' => NULL,
                'ctps' => NULL,
                'titulo_eleitoral' => NULL,
                'created_at' => '2020-08-19 11:20:02',
                'updated_at' => '2020-08-19 11:33:39',
            ),
            8 => 
            array (
                'id' => 9,
                'nome' => 'Mãe-Teste',
                'identidade' => NULL,
                'cpf' => NULL,
                'data_nascimento' => NULL,
                'ctps' => NULL,
                'titulo_eleitoral' => NULL,
                'created_at' => '2020-08-19 11:20:02',
                'updated_at' => '2020-08-19 11:20:02',
            ),
            9 => 
            array (
                'id' => 10,
                'nome' => 'Madrinha-Teste',
                'identidade' => NULL,
                'cpf' => NULL,
                'data_nascimento' => NULL,
                'ctps' => NULL,
                'titulo_eleitoral' => NULL,
                'created_at' => '2020-08-19 11:20:02',
                'updated_at' => '2020-08-19 11:20:02',
            ),
            10 => 
            array (
                'id' => 11,
                'nome' => 'Padrinho-Teste',
                'identidade' => NULL,
                'cpf' => NULL,
                'data_nascimento' => NULL,
                'ctps' => NULL,
                'titulo_eleitoral' => NULL,
                'created_at' => '2020-08-19 11:20:02',
                'updated_at' => '2020-08-19 11:20:02',
            ),
            11 => 
            array (
                'id' => 12,
                'nome' => 'Celebrante-Teste',
                'identidade' => NULL,
                'cpf' => NULL,
                'data_nascimento' => NULL,
                'ctps' => NULL,
                'titulo_eleitoral' => NULL,
                'created_at' => '2020-08-19 11:20:02',
                'updated_at' => '2020-08-19 11:20:02',
            ),
            12 => 
            array (
                'id' => 13,
                'nome' => 'Pe Serafim Magalhães Junior',
                'identidade' => NULL,
                'cpf' => NULL,
                'data_nascimento' => NULL,
                'ctps' => NULL,
                'titulo_eleitoral' => NULL,
                'created_at' => '2020-08-19 12:14:42',
                'updated_at' => '2020-08-19 12:14:42',
            ),
            13 => 
            array (
                'id' => 14,
                'nome' => 'Kakagatinha',
                'identidade' => NULL,
                'cpf' => NULL,
                'data_nascimento' => '1998-05-13',
                'ctps' => NULL,
                'titulo_eleitoral' => NULL,
                'created_at' => '2020-08-19 13:25:01',
                'updated_at' => '2020-08-19 14:05:59',
            ),
            14 => 
            array (
                'id' => 15,
                'nome' => 'Dalmo Moreira Santana',
                'identidade' => NULL,
                'cpf' => NULL,
                'data_nascimento' => NULL,
                'ctps' => NULL,
                'titulo_eleitoral' => NULL,
                'created_at' => '2020-08-19 13:25:01',
                'updated_at' => '2020-08-19 13:25:01',
            ),
            15 => 
            array (
                'id' => 16,
                'nome' => 'Meize Alves Santana',
                'identidade' => NULL,
                'cpf' => NULL,
                'data_nascimento' => NULL,
                'ctps' => NULL,
                'titulo_eleitoral' => NULL,
                'created_at' => '2020-08-19 13:25:01',
                'updated_at' => '2020-08-19 13:25:01',
            ),
            16 => 
            array (
                'id' => 17,
                'nome' => 'Fátima',
                'identidade' => NULL,
                'cpf' => NULL,
                'data_nascimento' => NULL,
                'ctps' => NULL,
                'titulo_eleitoral' => NULL,
                'created_at' => '2020-08-19 13:25:01',
                'updated_at' => '2020-08-19 13:25:01',
            ),
            17 => 
            array (
                'id' => 18,
                'nome' => 'Sebastião',
                'identidade' => NULL,
                'cpf' => NULL,
                'data_nascimento' => NULL,
                'ctps' => NULL,
                'titulo_eleitoral' => NULL,
                'created_at' => '2020-08-19 13:25:01',
                'updated_at' => '2020-08-19 13:25:01',
            ),
            18 => 
            array (
                'id' => 19,
                'nome' => 'Pe Geraldo Divno dos Sanstos',
                'identidade' => NULL,
                'cpf' => NULL,
                'data_nascimento' => NULL,
                'ctps' => NULL,
                'titulo_eleitoral' => NULL,
                'created_at' => '2020-08-19 13:25:01',
                'updated_at' => '2020-08-19 13:25:01',
            ),
        ));
        
        
    }
}