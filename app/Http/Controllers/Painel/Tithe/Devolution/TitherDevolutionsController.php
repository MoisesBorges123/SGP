<?php

namespace App\Http\Controllers\Painel\Tithe\Devolution;

use App\Http\Controllers\Controller;
use App\Models\Painel\Tithe\TitherDevolution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TitherDevolutionsController extends Controller
{
    private $devoution;
    public function __construct(TitherDevolution $devolutionsTbl)
    {
        $this->devolution = $devolutionsTbl;
    }
    public function index()
    {
        //
        $header = $this->header();
        $dados = DB::table('tithers')
        ->join('pessoas','pessoas.id','=','tithers.person')
        ->leftjoin('enderecos','pessoas.id','=','enderecos.pessoa')
        ->leftjoin('logradouros','logradouros.id','=','enderecos.logradouro')        
        ->leftjoin('estados','estados.id','=','logradouros.estado')
        ->select('pessoas.nome as nome','rua','bairro','cidade','estados.sigla as estado_sigla','tithers.id as id','enderecos.numero as numero','enderecos.apartamento as apartamento')
        ->orderBy('pessoas.nome')
        ->get();
        
        //dd($dados);
        return view('tithe.devolution.table',compact('header','dados'));
    }
    
    public function create(Request $request)
    {
        //dd($request->dizimista);
        $tither = DB::table('tithers')->where('id',$request->dizimista)->first();
        $pessoa = DB::table('pessoas')->where('id',$tither->person)->first();        
        $endereco = DB::table('enderecos')
        ->where('pessoa',$pessoa->id)
        ->join('logradouros','logradouros.id','=','enderecos.logradouro')
        ->join('estados','estados.id','=','logradouros.estado')
        ->first();
        $telefone = DB::table('telefone')->where('pessoa',$pessoa->id)->first();

        $dados = array(
            'dizimista'=>[
                'data_cadastro'=>$tither->created_at,
                'nome'=>$pessoa->nome,
                'data_nascimento'=>$pessoa->data_nascimento,
                'rua'=>$endereco->rua ?? '',
                'bairro'=>$endereco->bairro ?? '',
                'cep'=>$endereco->cep ?? '',
                'cidade'=>$endereco->cidade ?? '',
                'estado'=>$endereco->sigla ?? '',
                'email'=>$pessoa->email,
                'apartamento'=>$endereco->apartamento ?? '',
                'numero'=>$endereco->numero ?? '',
                'telefone'=>$telefone->telefone ?? '',
                'id'=>$request->dizimista,
                'situacao'=>$tither->situation
               
                

            ],
            'devolution' => $this->buscar_ficha($tither->id)

        );
        //dd($dados);
        return view('tithe.devolution.form',compact('dados'));
    }
    public function save(Request $request,$tither){
        
        $dados = $request->except('_token');
        $dados['ip']=$request->ip();
        $dados['tither']=$tither;
        //dd($dados);
        return $this->store($dados);
    }
    public function store($dados)
    {
        if(!empty($dados)){
            $month=$this->busca_mes($dados);               
            $year = $dados['id'];
            
            $dizimista = $dados['tither'];
            $devolucao = $this->devolution
                    ->where('month',$month['mes'])
                    ->where('year',$year)
                    ->where('tither',$dados['tither'])
                    ->first();
            if($devolucao){
               $dados= array('amoutn'=>$month['valor']);
                return $update=$devolucao->update($dados);
                                
            }else{
                
                
               // $conhecido=$this->computadores->find($ip);
               // if(!$conhecido){
               //     $this->computadores->create(['ip'=>$ip,'tipo'=>'desconhecido']) ;
              //  }
                $dados = array(
                    'tither'=>$dizimista,
                    'amoutn' =>$month['valor'],
                    'month'=>$month['mes'],
                    'year'=>$year,
                    'location'=>$dados['ip'],
                   
                    
                    
                );
               return $this->devolution->create($dados);
            }
        }
    }

   
    public function show(TitherDevolution $titherDevolution)
    {
        //
    }

   
    public function edit(TitherDevolution $titherDevolution)
    {
        //
    }

   
    public function update(Request $request, TitherDevolution $titherDevolution)
    {
        //
    }

    public function destroy(TitherDevolution $titherDevolution)
    {
        //
    }
    private function header(){
        $totalRegisterTither = DB::table('tithers')->get()->count();      
        $tithers = DB::table('tithers')->get();
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
        $birthdays = DB::table('tithers')->join('pessoas','pessoas.id','=','tithers.person')->where('pessoas.data_nascimento','like','%-'.date('m',time()).'-%')->count();
        
        
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
                'url'=>route('tither.actives'),
                
                
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
    private function buscar_ficha($tither){
        $firstDevolution=DB::table('tither_devolutions')
                ->where('tither',$tither)
                ->first();
                $Devolutions=DB::table('tither_devolutions')
                       ->where('tither',$tither)               
                       ->orderby('year','asc')                    
                       ->get();
        $totalRegister = count($Devolutions);
        
        
        if(!empty($firstDevolution)){ // CASO EXISTA ALGUMA DEVOLUÇÃO
            $lastDevolution=$Devolutions[$totalRegister-1];
            //dd($lastDevolution->year)
            $firstYear = $firstDevolution->year;
            if(($lastDevolution->year) < ( (date('Y',time())) -1 ) ){            
                $intervalo = (date('Y',time())) - ($lastDevolution->year) ;
            }else{
                $intervalo = ($lastDevolution->year) - ($firstDevolution->year);

            }
            
        }else{ //CASO NUNCA TENHA FEITO UMA DEVOLUÇÃO 
            $intervalo=0;
            $firstYear = date('Y',time());
        }
        
        $intervalo+=2; //Para mostrar 2 anos após a ultima devolução ou 2 anos após o atual
        
        $tabela_devolucoes=[];
        for($i=-2;$i<=$intervalo;$i++){            
                 $ano = $firstYear+$i;   
                
            for($j=-1;$j<=12;$j++){                
                $mes=$j;
                if($j>0){
                    $devolucao = 'R$ '.number_format($this->buscar_devolucao($ano, $mes, $tither),2,',','.');
                    
                    if(empty($devolucao)){
                        $valor = 'R$ - ';
                    }else{                        
                        $valor = $devolucao;
                        ;
                    }
                    $tabela_devolucoes[$firstYear+$i][$j]=$valor;                    
                }else{
                    $tabela_devolucoes[$firstYear+$i][$j]=$ano;                    
                    
                }
                
            }
        }
        $resposta = array(
          'tabela_devolucoes'  =>$tabela_devolucoes,
            'ultimo_ano'=>$ano
        );
        return $resposta;
        //return $tabela_devolucoes;
       
    }
    
    private function buscar_devolucao($year,$month,$tither){

        
        $devolucao=DB::table('tither_devolutions')
                ->where('year',$year)
                ->where('month',$month)
                ->where('tither',$tither)
                ->first();                
        if(empty($devolucao->amoutn)){
            return null;
        }else{
            return $devolucao->amoutn;
        }
    }
    private function busca_mes($formData){        
        extract($formData);
        if(!empty($Janeiro)){
            $valor=$Janeiro;
            $mes=1;
        }elseif(!empty($Fevereiro)){
            $valor=$Fevereiro;
            $mes=2;
        }elseif(!empty($Março)){
            $valor=$Março;
            $mes=3;
        }elseif(!empty($Abril)){
            $valor=$Abril;
            $mes=4;
        }elseif(!empty($Maio)){
            $valor=$Maio;
            $mes=5;
        }elseif(!empty($Junho)){
            $valor=$Junho;
            $mes=6;
        }elseif(!empty($Julho)){
            $valor=$Julho;
            $mes=7;
        }elseif(!empty($Agosto)){
            $valor=$Agosto;
            $mes=8;
        }elseif(!empty($Setembro)){
            $valor=$Setembro;
            $mes=9;
        }elseif(!empty($Outubro)){
            $valor=$Outubro;
            $mes=10;
        }elseif(!empty($Novembro)){
            $mes=11;
            $valor=$Novembro;
        }elseif(!empty($Dezembro)){
            $mes=12;
            $valor=$Dezembro;
        }else{
            $mes=0;
            $valor=0;
        }
        $valor = floatval(str_replace(',', '.', $valor));
        $resposta = array('mes'=>$mes,'valor'=>$valor);
        return $resposta;
    }
}
