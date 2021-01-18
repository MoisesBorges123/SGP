<?php

namespace App\Http\Controllers\Painel\Tithe\Tither;

use App\Http\Controllers\Controller;
use App\Models\Painel\Tithe\Tither;
use Illuminate\Http\Request;
use App\Http\Controllers\PessoasController;
use Illuminate\Support\Facades\DB;
class TitherController extends Controller
{
    private $tither;
    public function __construct(Tither $dizimista)
    {
        $this->tither = $dizimista;
    }
    public function index()
    {
        $header = $this->header();
        $dados = DB::table('tithers')
        ->join('pessoas','pessoas.id','=','tithers.person')
        ->join('enderecos','pessoas.id','=','enderecos.pessoa')
        ->join('logradouros','logradouros.id','=','enderecos.logradouro')
        ->join('telefone','pessoas.id','=','telefone.pessoa')
        ->join('estados','estados.id','=','logradouros.estado')
        ->select('pessoas.nome as nome','telefone','rua','bairro','cidade','estados.sigla as estado_sigla','tithers.id as id','enderecos.numero as numero','enderecos.apartamento as apartamento')
        ->orderBy('pessoas.nome')
        ->get();
        //dd($dados);
        return view ('tithe.tither.table',compact('header','dados'));
    }

    public function create()
    {
        $title = 'Novo Dizimista';
        return view('tithe.tither.form',compact('title'));
    }

    
    public function store(Request $request)
    {
        $dataForm=$request->except('_token');
        $fnPepleo = new PessoasController;
        $pessoa = $fnPepleo->store($dataForm);
        $insert = $this->tither->create(['person'=>$pessoa->id,'situation'=>'Ativo']);
        if($insert){
            notify()->success("Dizimista cadastrado com sucesso :)");
            return redirect()->route('tither.index');
        }else{
            notify()->error("Ocorreu um erro durante o cadastro :(");
            return redirect()->back();

        }
        

    }
    

    public function show(Tither $tither)
    {
        //
    }
   
    public function edit($tither)
    {
        $dados = DB::table('tithers')
        ->join('pessoas','pessoas.id','=','tithers.person')
        ->join('enderecos','pessoas.id','=','enderecos.pessoa')
        ->join('logradouros','logradouros.id','=','enderecos.logradouro')
        ->join('telefone','pessoas.id','=','telefone.pessoa')
        ->join('estados','estados.id','=','logradouros.estado')
        ->where('tithers.id',$tither)
        ->select('pessoas.nome as nome','data_nascimento','email','ibge','dd_local','logradouros.complemento as complement1','enderecos.complemento as complement2','telefone','cep','rua','bairro','cidade','estados.sigla as estado_sigla','tithers.id as id','enderecos.numero as numero','enderecos.apartamento')
        ->orderBy('pessoas.nome')
        ->first();
        $title = 'Editar Dizimista';
        return view('tithe.tither.form',compact('dados','title'));

    }

    public function update(Request $request,  $tither)
    {
       $fn_pessoa = new PessoasController;
       $dados = $request->except('_token');
       $dizimista = $this->tither->find($tither);
       $dados['id']= $dizimista->person;
       $updated = $fn_pessoa->update($dados);
       if($updated){
           notify()->success('Alterações salvas com sucesso ;)');
            return redirect()->route('tither.index');
        }else{
           notify()->error('Não foi possível persistir as alterações ;)');
            return redirect()->back();

       }
    }

    public function destroy($tither)
    {
        DB::table('tither_devolutions')->where('tither',$tither)->delete();
        $register = $this->tither->find($tither)->delete();
        return $register;
    }

    private function header(){
        $totalRegisterTither = $this->tither->all()->count();
        $onTither = $this->tither->where('situation','Ativo')->count();
        $offTither = $this->tither->where('situation','Inativo')->count();
        $birthdays = $this->tither->join('pessoas','pessoas.id','=','tithers.person')->where('pessoas.data_nascimento','like','%-'.date('m',time()).'-%')->count();
        
        
        $card =array(
            [
                'headerText'=>'Dizimistas Cadastrados',
                'headerNumber'=> $totalRegisterTither,
                'bodyIcon'=>'<i class="fas fa-calendar-check"></i>',
                'color'=>'bg-green',
                'url'=>route('certidao-batismo.filter',1),
                
                
            ],
            [
                'headerText'=> 'Dizimistas Ativos',
                'headerNumber'=>$onTither,
                'bodyIcon'=>'<i class="fas fa-history"></i>',
                'color'=>'bg-warning',
                'url'=>'',
                
                
            ],
            [
                'headerText'=>'Dizimistas Inativos',
                'headerNumber'=>$offTither,
                'bodyIcon'=>'<i class="fas fa-dizzy"></i>',
                'color'=>'bg-yellow',
                'url'=>'',
                
                
            ],
            [
                'headerText'=>'Aniversariantes Mês',
                'headerNumber'=>$birthdays,
                'bodyIcon'=>'<i class="fas fa-bell"></i>',
                'color'=>'bg-info',
                'url'=>'',
                'identify'=>'avisos'
            ]           
            
        );
        
        return $card;
    }
}
