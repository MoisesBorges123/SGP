<?php

namespace App\Http\Controllers\Painel\Endereco;

use App\Http\Controllers\Controller;
use App\Models\Painel\Endereco\Logradouro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class LogradouroController extends Controller
{
    
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }
    public static function store($dados)
    {
        //dd($dados);
        
        if(!empty($dados['cep'])){ 
            $logradouro = LogradouroController::show($dados['cep']);            
            if(!empty($logradouro) && empty($logradouro['id'])){
                if(!empty($dados['estado']) && is_string($dados['estado'])){
                    $estado = DB::table('estados')->where('nome',$dados['estado'])->first();
                    $dados['estado']= $estado->id;
                }else{
                    $estado = DB::table('estados')->where('nome',$logradouro['nome_estado'])->first();
                    $dados['estado']= $estado->id;
                }     
                  
                $dadosLog = [
                    'estado'=>$dados['estado'],
                    'rua'=>$logradouro['logradouro'],
                    'bairro'=>$logradouro['bairro'],
                    'cep'=>$logradouro['cep'],
                    'cidade'=>$logradouro['cidade'],
                    'dd_local'=>$logradouro['dd_local'],
                    'complemento'=>$logradouro['complemento'],
                    'ibge'=>$logradouro['ibge']
                ];
                //dd($dadosLog);
                return Logradouro::create($dadosLog);                
            }else{
                return $logradouro;
            }
        }else{
            return false;
        }
    }
    public function search_cep (Request $request)
    {
        if(!empty($request->cep)){
            return LogradouroController::show($request->cep);
        }else{
            return false;
        }
    }
    public static function show($cep)
    {      
        $cep = trim($cep);
        $localidade = LogradouroController::internalSearch($cep);
        if($localidade==false){ // Se não achar no banco de dados local faça uma pesquisa online
            $localidade=LogradouroController::externalSearch($cep); 
            if(!empty($localidade)){
                if(empty($localidade['uf'])){
                    $localidade['uf']='MG';
                }
                $estado = DB::table('estados')                   
                        ->where('sigla',$localidade['uf'])
                        ->first();  
                
                $endereco = array( 
                    'resposta'=>true,
                    'cep'=>empty($localidade['cep']) ? '' : $localidade['cep'],                    
                    'logradouro'=>empty($localidade['logradouro']) ? '' : $localidade['logradouro'],
                    'bairro'=>empty($localidade['bairro']) ? '' : $localidade['bairro'],
                    'cidade'=>empty($localidade['localidade']) ? '' : $localidade['localidade'],
                    'estado'=>$estado->id ?? '',
                    'nome_estado'=>$estado->nome ,
                    'complemento'=>empty($localidade['complemento']) ? '' : $localidade['complemento'],
                    'dd_local'=>empty($localidade['ddd']) ? '' : $localidade['ddd'],
                    'ibge'=>empty($localidade['ibge']) ? '' : $localidade['ibge'],
                    );                 
            }else{
                $endereco = array('resposta'=>false);
            }
        }else{ // Caso foi encontrado no banco de dados o endereço carregue os dados para um array
           
            $estado = DB::table('estados')->where('id',$localidade->estado)->first();
            $endereco = array(
                'id'=>$localidade->id,
                'resposta'=>true,
                'cep'=>$localidade->cep,                
                'logradouro'=>$localidade->rua,
                'bairro'=>$localidade->bairro,
                'cidade'=>$localidade->cidade,
                'estado'=>$localidade->estado,
                'nome_estado'=>$estado->nome,
                'complemento'=>$localidade->complemento,
                'dd_local'=>$localidade->dd_local,
                'ibge'=>$localidade->ibge,
            );
        }
        
        return $endereco;

        
    }  
    public function edit(Logradouro $logradouro)
    {
        //
    }
    public function update(Request $request, Logradouro $logradouro)
    {
        //
    }
    public function destroy(Logradouro $logradouro)
    {
        //
    }
    private static function externalSearch($cep){
        $cep = preg_replace("/[^0-9]/", "", $cep);
        //$cep= substr($cep, 0,5).'-'.substr($cep, 5,3);
        $url = "http://viacep.com.br/ws/$cep/xml/";
        $xml = simplexml_load_file($url);         
        $array = json_decode(json_encode((array) $xml), 1);     
        if(!empty($array['error'])){
            return false;
        }else{

            return $array;
        }
    }
    private static function internalSearch($dado){      
           
        $logradouro = DB::table('logradouros')->where('cep',$dado)->first();
        if(empty($logradouro)){
            return false;
        }else{
            return $logradouro;
        }
        
      
     
    }//PROCURAR ENDERÇOS (JÁ CADASTRADOS)
}
