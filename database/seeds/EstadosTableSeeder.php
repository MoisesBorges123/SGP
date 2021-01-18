<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class EstadosTableSeeder extends Seeder
{


    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('estados')->delete();
        
        DB::table('estados')->insert(array (
            0 => 
            array (
                'id' => 1,
                'sigla' => 'AC',
                'nome' => 'Acre',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            1 => 
            array (
                'id' => 2,
                'sigla' => 'AL',
                'nome' => 'Alagoas',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            2 => 
            array (
                'id' => 3,
                'sigla' => 'AM',
                'nome' => 'Amazonas',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            3 => 
            array (
                'id' => 4,
                'sigla' => 'AP',
                'nome' => 'Amapá',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            4 => 
            array (
                'id' => 5,
                'sigla' => 'BA',
                'nome' => 'Bahia',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            5 => 
            array (
                'id' => 6,
                'sigla' => 'CE',
                'nome' => 'Ceará',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            6 => 
            array (
                'id' => 7,
                'sigla' => 'DF',
                'nome' => 'Distrito Federal',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            7 => 
            array (
                'id' => 8,
                'sigla' => 'ES',
                'nome' => 'Espírito Santo',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            8 => 
            array (
                'id' => 9,
                'sigla' => 'GO',
                'nome' => 'Goiás',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            9 => 
            array (
                'id' => 10,
                'sigla' => 'MA',
                'nome' => 'Maranhão',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            10 => 
            array (
                'id' => 11,
                'sigla' => 'MG',
                'nome' => 'Minas Gerais',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            11 => 
            array (
                'id' => 12,
                'sigla' => 'MS',
                'nome' => 'Mato Grosso do Sul',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            12 => 
            array (
                'id' => 13,
                'sigla' => 'MT',
                'nome' => 'Mato Grosso',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            13 => 
            array (
                'id' => 14,
                'sigla' => 'PA',
                'nome' => 'Pará',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            14 => 
            array (
                'id' => 15,
                'sigla' => 'PB',
                'nome' => 'Paraíba',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            15 => 
            array (
                'id' => 16,
                'sigla' => 'PE',
                'nome' => 'Pernambuco',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            16 => 
            array (
                'id' => 17,
                'sigla' => 'PI',
                'nome' => 'Piauí',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            17 => 
            array (
                'id' => 18,
                'sigla' => 'PR',
                'nome' => 'Paraná',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            18 => 
            array (
                'id' => 19,
                'sigla' => 'RJ',
                'nome' => 'Rio de Janeiro',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            19 => 
            array (
                'id' => 20,
                'sigla' => 'RN',
                'nome' => 'Rio Grande do Norte',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            20 => 
            array (
                'id' => 21,
                'sigla' => 'RO',
                'nome' => 'Rondônia',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            21 => 
            array (
                'id' => 22,
                'sigla' => 'RR',
                'nome' => 'Roraima',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            22 => 
            array (
                'id' => 23,
                'sigla' => 'RS',
                'nome' => 'Rio Grande do Sul',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            23 => 
            array (
                'id' => 24,
                'sigla' => 'SC',
                'nome' => 'Santa Catarina',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            24 => 
            array (
                'id' => 25,
                'sigla' => 'SE',
                'nome' => 'Sergipe',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            25 => 
            array (
                'id' => 26,
                'sigla' => 'SP',
                'nome' => 'São Paulo',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            26 => 
            array (
                'id' => 27,
                'sigla' => 'TO',
                'nome' => 'Tocantins',
                'created_at' => now(),
                'updated_at' => now(),
            ),
        ));
        
        
    }
}