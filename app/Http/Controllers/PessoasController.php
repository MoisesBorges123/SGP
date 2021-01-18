<?php

namespace App\Http\Controllers;

use App\Models\Painel\Pessoa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Painel\TelefoneController;
use App\Http\Controllers\Painel\Endereco\EnderecoController;
class PessoasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store($dados)
    {
        
        $validated = $this->validation($dados);
        if(!$validated->fails()){
            $pessoa = new Pessoa;
            $existe=DB::table('pessoas')->where('nome',$dados['nome'])->first();
            if(!$existe){
                $insert=$pessoa->create($dados);   
                $dados['pessoa'] = $insert->id;
            if(!empty($dados['cep'])){                
                EnderecoController::store($dados);
            }
            if(!empty($dados['telefone'])){
                $dadosTelefone = array(
                    'pessoa'=>$insert->id,
                    'telefone'=>$dados['telefone']
                );
                TelefoneController::store($dadosTelefone);               
                
            }             
            }else{
                $insert = $existe;
            }
            
           return $insert;
        }else{
            return $validated;
            //return array('validated'=>false,'errors'=>$validated);
        }
    }

    public static function show($id)
    {
        $pessoa=DB::table('pessoas')->where('id',$id)->first();
        return $pessoa;

    }

    public function update($dados)
    {
        $validated = $this->validation($dados);
        if(!$validated->fails()){
            $pessoa = new Pessoa;
            $selectedPeople=$pessoa->find($dados['id']);
            $updatePerson = $selectedPeople->update($dados);
        }
        if($dados['cep']){
            $updateAdress = EnderecoController::update($dados);
        }
        if($dados['telefone']){
            $updatePhone = TelefoneController::update($dados);
        }
        return array('pessoa'=>$updatePerson,'endereco'=>$updateAdress,'telefone'=>$updatePhone);
    }
    public function destroy(Pessoa $pessoa)
    {
        //
    }
    private function validation($dados){
        return Validator::make($dados,[
            'nome'=>'required|min:3|string',
            'identidade'=>'string|min:5|max:15',
            'cpf'=>'string|min:13|max:13',
            'data_nascimento'=>'date',
            'ctps'=>'string',
            'titulo_eleitoral'=>'string'
        ]) ;
    }
}
