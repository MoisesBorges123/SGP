<?php

namespace App\Http\Controllers\Painel\Tithe\Tither;

use App\Http\Controllers\Controller;
use App\Models\Painel\Tithe\Tither;
use Illuminate\Http\Request;
use App\Http\Controllers\PessoasController;
use Illuminate\Support\Facades\DB;
use App\Models\Painel\Tithe\TitherDevolution;
class TitherController extends Controller
{
    private $tither;
    public function __construct(Tither $dizimista)
    {
        $this->tither = $dizimista;
    ini_set('max_execution_time', 1800);

    }
    public function index()
    {
        $header = $this->header();
        $tithers = DB::table('tithers')
        ->join('pessoas','pessoas.id','=','tithers.person')
        ->leftjoin('enderecos','pessoas.id','=','enderecos.pessoa')
        ->leftjoin('logradouros','logradouros.id','=','enderecos.logradouro')
        //->join('telefone','pessoas.id','=','telefone.pessoa')
        ->leftjoin('estados','estados.id','=','logradouros.estado')
        ->select('pessoas.id as pessoa_id','pessoas.nome as nome','rua','bairro','cidade','estados.sigla as estado_sigla','tithers.id as id','enderecos.numero as numero','enderecos.apartamento as apartamento')
        ->orderBy('pessoas.nome')
        ->get();
        $dados = [];
        foreach($tithers as $tither){
            
            $telefone = DB::table('telefone')->where('pessoa',$tither->pessoa_id)->orderBy('created_at','desc')->first();
            $numero = $telefone->telefone ?? '';
            $dados[]=[
                        'nome'=>$tither->nome,
                        'rua'=>$tither->rua,
                        'bairro'=>$tither->bairro,
                        'numero'=>$tither->numero,
                        'apartamento'=>$tither->apartamento,
                        'cidade'=>$tither->cidade,
                        'estado_sigla'=>$tither->estado_sigla,
                        'id'=>$tither->id,
                        'telefone'=>trim($numero)
                    ];
            //dd($dados);
        }
        
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
        $tithers = $this->tither->all();
        $offTither = 0;
        $i =1;
        foreach($tithers as $tither){            
            $devolution = DB::table('tither_devolutions')    
            ->where('created_at','>',date('Y-m-d H:i:s',strtotime('-91 days',time())))          
            ->where('tither',$tither->id)                         
            ->first();            
            if(empty($devolution)){
                $offTither++;

            }
           
        }
        
        $onTither  = $totalRegisterTither - $offTither;
        $birthdays = $this->tither->join('pessoas','pessoas.id','=','tithers.person')->where('pessoas.data_nascimento','like','%-'.date('m',time()).'-%')->count();
        
        
        $card =array(
            [
                'headerText'=>'Dizimistas Cadastrados',
                'headerNumber'=> $totalRegisterTither,
                'bodyIcon'=>'<i class="ni ni-chart-bar-32"></i>',
                'color'=>'bg-green',
                'url'=>route('certidao-batismo.filter',1),
                
                
            ],
            [
                'headerText'=> 'Dizimistas Ativos',
                'headerNumber'=>$onTither,
                'bodyIcon'=>'<i class="ni ni-satisfied"></i>',
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
    public function import(){
        $host="localhost";
        $user = "root";
        $password='';
        $database='catedral';        
        $connection = mysqli_connect($host,$user,$password,$database);
        $query1 = "select * from dizimistas order by id asc";       
        $result = mysqli_query($connection,$query1);
        $erros=[];
        while($dizimista = mysqli_fetch_assoc($result)){

            $location = explode('/',str_replace('N° ','',$dizimista['numero']));
            $numero = $location[0] ?? '';
            $apartamento = $location[1] ??'';
            $data = array(
                'nome'=>$dizimista['nome'],
                'telefone'=>$dizimista['telefone'] == 'Não possui' ? $dizimista['celular'] ?? '' : $dizimista['telefone'],
                'cep'=>$dizimista['cep'],
                'data_nascimento'=>$dizimista['data_nascimento'],
                'numero'=> $numero,
                'apartamento'=>$apartamento,
                'complemento2'=>$dizimista['complemento'] ?? ''
            );
 
            $fnPepleo = new PessoasController;
            $pessoa = $fnPepleo->store($data);
            if(!empty($pessoa->id)){
                $insert = $this->tither->where('person',$pessoa->id)->first();
                if(empty($insert)){
                    $insert = $this->tither->create(['person'=>$pessoa->id,'situation'=>'Ativo']);
                }
                $query3 = "select * from devolucoes where dizimista='".$dizimista['id']."'";
                $result2 = mysqli_query($connection,$query3);
                while($devolucao = mysqli_fetch_assoc($result2)){
                    
                    $dados = array(
                        'tither'=>$insert->id,
                        'amoutn' =>$devolucao['valor'],
                        'month'=>$devolucao['mes_referente'],
                        'year'=>$devolucao['ano_referente'],
                        'location'=>'127.0.0.1',
                        'created_at'=>$devolucao['data_recebimento'].'16:00:00'
                    );
                
                    $insert2=TitherDevolution::create($dados);
                }
                if(empty($insert->id)){
                    $errors=['dizimista'=>$dizimista];
                }
                echo "Inseriu dizimista: ".$dizimista['nome']."<br>";
            }else{
                $errors=['dizimista'=>$dizimista];
                
            }
        }
        
        return empty($erros) ? "<br><br><H1>Nenhum Erro \o/ </H1>" : $erros;
    }

}
