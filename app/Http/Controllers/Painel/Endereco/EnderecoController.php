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
        $dados['complemento'] = $dados['complemento2'];
        $dados['logradouro'] = $logradouro->id;
        return Endereco::create($dados);
        
    }

    public function show(Endereco $endereco)
    {
        //
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
