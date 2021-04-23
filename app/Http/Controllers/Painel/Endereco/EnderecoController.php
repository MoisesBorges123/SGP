<?php

namespace App\Http\Controllers\Painel\Endereco;

use App\Http\Controllers\Controller;
use App\Models\Painel\Endereco\Endereco;
use App\Http\Controllers\Painel\Endereco\LogradouroController;
use Illuminate\Http\Request;

class EnderecoController extends Controller
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
        
        
        $logradouro = LogradouroController::store($dados); 
        
        $dados['complemento'] = $dados['complemento2'] ?? '';
        $dados['logradouro'] = $logradouro->id ?? $logradouro['id'] ?? '';
        if(!empty($dados['logradouro'])){
            $endereco = Endereco::where('pessoa',$dados['pessoa'])->get();
            
            if(empty($endereco->id)){
                return Endereco::create($dados);
            }elseif(!empty($endereco) && ($endereco->logradouro != $dados['logradouro'] || $endereco->numero != $dados['numero'] || $endereco->apartamento != $dados['apartamento']) ){
                $endereco->update($dados);
                return Endereco::where('pessoa',$dados['pessoa'])->first();
            }else{
                return $endereco;
            }

        }else{
            return null;
        }
        
        
    }

    public static function show($id_endereco)
    {
        return Endereco::find($id_endereco);
    }

    public function edit(Endereco $endereco)
    {
        //
    }

    public static function update($dados)
    {
        $newLogradouro = LogradouroController::store($dados);
        $dados['logradouro'] = $newLogradouro->id;

        $endereco = Endereco::where('pessoa',$dados['id'])->first();
        return $endereco->update($dados);
    }

    public function destroy(Endereco $endereco)
    {
        //
    }
}
