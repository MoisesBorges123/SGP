<?php

namespace App\Http\Controllers\Painel\Certidoes;

use App\Http\Controllers\Controller;
use App\Models\Painel\Certidao\CertidaoBatismo;
use App\Http\Controllers\PessoasController;
use Illuminate\Http\Request;
use App\Http\Requests\Painel\Certidoes\CertidaoBatismoValidation;
use App\Http\Requests\Painel\Certidoes\UpdateCertidaoBatismoRequest;
use Illuminate\Support\Facades\DB;
class CertidaoBatismoController extends Controller
{
    private $certidao;
    public function __construct(CertidaoBatismo $baptismo)
    {
        $this->certidao = $baptismo;
    }
    private function header(){
        $totalBatizados = $this->certidao->where('data_batizado','like',date('Y',time()).'-%')->count();
        $totalRegIncosistente = $this->certidao->where('duvidoso','1')->count();
        $totalRegistros = $this->certidao->count();
        $totalLivrosDigitais = 0;
        $card =array(
            [
                'headerText'=>'Batizados '.date('Y',time()),
                'headerNumber'=> $totalBatizados,
                'bodyIcon'=>'<i class="fas fa-chart-bar"></i>',
                'color'=>'bg-danger',
                'url'=>route('certidao-batismo.filter',1)
                
            ],
            [
                'headerText'=> 'Certidões Registradas',
                'headerNumber'=>$totalRegistros,
                'bodyIcon'=>'<i class="fas fa-chart-pie"></i>',
                'color'=>'bg-warning',
                'url'=>''
            ],
            [
                'headerText'=>'Livros Digitalizados',
                'headerNumber'=>$totalLivrosDigitais,
                'bodyIcon'=>'<i class="fas fa-users"></i>',
                'color'=>'bg-yellow',
                'url'=>''
            ],
            [
                'headerText'=>'Registros Inconsistentes',
                'headerNumber'=>$totalRegIncosistente,
                'bodyIcon'=>'<i class="fas fa-percent"></i>',
                'color'=>'bg-info',
                'url'=>route('certidao-batismo.filter',2)
            ]           
            
        );
        
        return $card;
    }
    private function pessoaUpdate($pessoas,$certidao){
        $dados = [
            [
                'data_nascimento'=>$pessoas['data_nascimento'],
                'nome'=>$pessoas['crianca'],
                'id'=>$certidao->crianca,                
            ],
            [
                'nome'=>$pessoas['pai'],
                'id'=>$certidao->pai,
            ],
            [
                'nome'=>$pessoas['mae'],
                'id'=>$certidao->mae,
            ],
            [
                'nome'=>$pessoas['madrinha'],
                'id'=>$certidao->madrinha,
            ],
            [
                'nome'=>$pessoas['padrinho'],
                'id'=>$certidao->padrinho
            ],
            [
                'nome'=>$pessoas['celebrante'],
                'id'=>$certidao->celebrante
            ]
        ];
        //dd($dados);exit();
        $fnPessoa = new PessoasController;
        foreach($dados as $pessoa){            
            if(!empty($pessoa['nome']) && !empty($pessoa['id'])){
                $fnPessoa->update($pessoa);
            }else{
                $insert=$fnPessoa->store($pessoa);
                //dd($insert['insert']->id);exit;                
                DB::table('certidao_batismo')->where('id',$certidao->id)->update(['celebrante'=>$insert['insert']->id]);
            }
        }  
             
    }
    public function index()
    {
        $header=$this->header();
        $certidoes=count($this->certidao->orderBy('id','desc')->get())>0 ? $this->certidao->orderBy('id','desc')->get() : null;
        
        if(!empty($certidoes)){
            foreach($certidoes as $certidao){
                
                $crianca=DB::table('pessoas')->where('id',$certidao->crianca)->first();
                $pai=DB::table('pessoas')->where('id',$certidao->pai)->first();
                $mae=DB::table('pessoas')->where('id',$certidao->mae)->first();
                $madrinha=DB::table('pessoas')->where('id',$certidao->madrinha)->first();
                $padrinho=DB::table('pessoas')->where('id',$certidao->padrinho)->first();
                $dados[] =[
                    'crianca'=>$crianca->nome,
                    'pai'=>empty($pai->nome) ? 'Não possui' : $pai->nome,
                    'mae'=>empty($mae->nome) ? 'Não possui' : $mae->nome,
                    'padrinho'=>empty($padrinho->nome) ? 'Não possui' : $padrinho->nome,
                    'madrinha'=>empty($madrinha->nome) ? 'Não possui' : $madrinha->nome,                    
                    'id'=>$certidao->id
                ];
            }
        }else{
            $dados=null;
        }     
        return view('certidoes.certidao-batismo.table',compact('dados','header'));
    }
    public function filter($filter)
    {        
        $header=$this->header();
        if($filter  == 1){
            $certidoes=count($this->certidao->where('data_batizado','like',date('Y',time()).'-%')->orderBy('id','desc')->get())>0 ? $this->certidao->where('data_batizado','like',date('Y',time()).'-%')->orderBy('id','desc')->get() : null;
            
        }else if($filter==2){
            $certidoes=count($this->certidao->where('duvidoso','=','1')->orderBy('id','desc')->get())>0 ? $this->certidao->where('duvidoso','=','1')->orderBy('id','desc')->get() : null;
            
        }else{
            return redirect()->route('certidao-batismo.index');
        }

        if(!empty($certidoes)){
            foreach($certidoes as $certidao){                    
                $crianca=DB::table('pessoas')->where('id',$certidao->crianca)->first();
                $pai=DB::table('pessoas')->where('id',$certidao->pai)->first();
                $mae=DB::table('pessoas')->where('id',$certidao->mae)->first();
                $madrinha=DB::table('pessoas')->where('id',$certidao->madrinha)->first();
                $padrinho=DB::table('pessoas')->where('id',$certidao->padrinho)->first();
                $dados[] =[
                    'crianca'=>$crianca->nome,
                    'pai'=>empty($pai->nome) ? 'Não possui' : $pai->nome,
                    'mae'=>empty($mae->nome) ? 'Não possui' : $mae->nome,
                    'padrinho'=>empty($padrinho->nome) ? 'Não possui' : $padrinho->nome,
                    'madrinha'=>empty($madrinha->nome) ? 'Não possui' : $madrinha->nome,                    
                    'id'=>$certidao->id
                ];
            }
        }else{
            $dados=null;
        }     
        return view('certidoes.certidao-batismo.table',compact('dados','header'));
    }
    public function create()
    {
        
        $header=$this->header();
        $certidoes=count($this->certidao->orderBy('id','desc')->take(10)->get())>0 ? $this->certidao->orderBy('id','desc')->take(10)->get() : null;
        $ultimos = false;
        if(!empty($certidoes)){
            foreach($certidoes as $certidao){
                
                $crianca=DB::table('pessoas')->where('id',$certidao->crianca)->first();
                $pai=DB::table('pessoas')->where('id',$certidao->pai)->first();
                $mae=DB::table('pessoas')->where('id',$certidao->mae)->first();
                $ultimos[] =[
                    'crianca'=>$crianca->nome,
                    'pai'=>empty($pai->nome) ? 'Não possui' : $pai->nome,
                    'mae'=>empty($mae->nome) ? 'Não possui' : $mae->nome,
                ];
            }
        }        
        return view('certidoes.certidao-batismo.form',compact('ultimos','header'));
    }

    public function store(CertidaoBatismoValidation $request)
    {
        $request->validated();
         $validated = $request->smartValidation($request->except('_token'));
         if($validated){

             $crianca = array(
                 'nome'=>$request->input('crianca'),
                 'data_nascimento'=>$request->input('data_nascimento')
             );
             $pai = array(
                 'nome'=>$request->input('pai'),
                 
             );
             $mae = array(
                 'nome'=>$request->input('mae'),
                 
             );
             $madrinha = array(
                 'nome'=>$request->input('madrinha'),
                 
             );
             $padrinho = array(
                 'nome'=>$request->input('padrinho'),
                 
             );
             $celebrante = array(
                 'nome'=>$request->input('celebrante')
             );
             $pessoa = new PessoasController;
    
             $pessoas = array(
                 'crianca' =>$pessoa->store($crianca),
                 'pai'=>!empty($pai['nome']) ? $pessoa->store($pai) : ['insert'=>'N'],
                 'mae'=>!empty($mae['nome']) ? $pessoa->store($mae) : ['insert'=>'N'],
                 'madrinha'=>!empty($madrinha['nome']) ? $pessoa->store($madrinha) : ['insert'=>'N'],
                 'padrinho'=>!empty($padrinho['nome']) ? $pessoa->store($padrinho) : ['insert'=>'N'],
                 'celebrante'=>!empty($celebrante['nome']) ? $pessoa->store($celebrante) : ['insert'=>'N'],
             );
             //dd($pessoas);exit();
             foreach($pessoas as $cadastro){
                 if(empty($cadastro['insert'])){                    
                     return redirect()->back()->withErrors($cadastro['errors'])->withInput();
                 }
             }           
             
             $dados  =  array(
                 'crianca'=>$pessoas['crianca']['insert']->id,
                 'mae'=>$pessoas['mae']['insert']!='N' ? $pessoas['mae']['insert']->id : null,
                 'pai'=>$pessoas['pai']['insert']!='N' ? $pessoas['pai']['insert']->id : null,
                 'padrinho'=>$pessoas['padrinho']['insert']!='N' ? $pessoas['padrinho']['insert']->id : null,
                 'madrinha'=>$pessoas['madrinha']['insert']!='N' ? $pessoas['madrinha']['insert']->id : null,
                 'celebrante'=>$pessoas['celebrante']['insert']!='N' ? $pessoas['celebrante']['insert']->id : null,
                 'livro'=>$request->input('livro'),
                 'folha'=>$request->input('folha'),
                 'data_batizado'=>$request->input('data_batizado'),
                 'local_batizado'=>$request->input('local_batizado'),
                 'duvidoso'=>$request->input('duvidoso')
             );
             
             $insert = $this->certidao->create($dados);
             if($insert){
                 notify()->success('Registro salvo com sucesso');
                 return redirect()->back();
             }else{
                 return redirect()->back()->withInput();
 
             }
         }else{
             notify()->error('Não foi possivel salvar esse registro. Verifique se a data de batismo ou de nascimento foram preenchidos corretamente.');
            return redirect()->back()->withInput();
         }

    }

    public function show($id)
    {
        $certidao=$this->certidao->find($id);
        
        $crianca=DB::table('pessoas')->where('id',$certidao->crianca)->first();
        $pai=DB::table('pessoas')->where('id',$certidao->pai)->first();
        $mae=DB::table('pessoas')->where('id',$certidao->mae)->first();
        $madrinha=DB::table('pessoas')->where('id',$certidao->madrinha)->first();
        $padrinho=DB::table('pessoas')->where('id',$certidao->padrinho)->first();
        $dados=array( 
            'duvidoso'=>$certidao->duvidoso,
            'nascimento'=>date('d/m/Y',strtotime($crianca->data_nascimento)),
            'batizado'=>date('d/m/Y',strtotime($certidao->data_batizado)),
            'crianca'=>$crianca->nome,
            'pai'=>empty($pai->nome) ? 'Não possui' : $pai->nome,
            'mae'=>empty($mae->nome) ? 'Não possui' : $mae->nome,
            'padrinho'=>empty($padrinho->nome) ? 'Não possui' : $padrinho->nome,
            'madrinha'=>empty($madrinha->nome) ? 'Não possui' : $madrinha->nome,   
            'livro'=>$certidao->livro,            
            'pagina'=>$certidao->folha,
            'id'=>$certidao->id
        );
        
            //dd($dados);exit();
                
            
        
        return view('certidoes.certidao-batismo.details',compact('dados'));
    }


    public function edit($id)
    {
        $header=$this->header();
        $certidoes=count($this->certidao->orderBy('id','desc')->take(10)->get())>0 ? $this->certidao->orderBy('id','desc')->take(10)->get() : null;
        $ultimos = false;
        if(!empty($certidoes)){
            foreach($certidoes as $certidao){
                
                $crianca=DB::table('pessoas')->where('id',$certidao->crianca)->first();
                $pai=DB::table('pessoas')->where('id',$certidao->pai)->first();
                $mae=DB::table('pessoas')->where('id',$certidao->mae)->first();
                $ultimos[] =[
                    'crianca'=>$crianca->nome,
                    'pai'=>empty($pai->nome) ? 'Não possui' : $pai->nome,
                    'mae'=>empty($mae->nome) ? 'Não possui' : $mae->nome,
                ];
            }
        }     
        $certidao=$this->certidao->find($id);
        
        $crianca=DB::table('pessoas')->where('id',$certidao->crianca)->first();
        $pai=DB::table('pessoas')->where('id',$certidao->pai)->first();
        $mae=DB::table('pessoas')->where('id',$certidao->mae)->first();
        $madrinha=DB::table('pessoas')->where('id',$certidao->madrinha)->first();
        $padrinho=DB::table('pessoas')->where('id',$certidao->padrinho)->first();
        $celebrante=DB::table('pessoas')->where('id',$certidao->celebrante)->first();
        //dd($celebrante);exit;
        $dados=array( 
            'duvidoso'=>$certidao->duvidoso,
            'nascimento'=>$crianca->data_nascimento,
            'batizado'=>$certidao->data_batizado,
            'local'=>$certidao->local_batizado,
            'crianca'=>$crianca->nome,
            'pai'=>empty($pai->nome) ? '' : $pai->nome,
            'mae'=>empty($mae->nome) ? '' : $mae->nome,
            'padrinho'=>empty($padrinho->nome) ? '' : $padrinho->nome,
            'madrinha'=>empty($madrinha->nome) ? '' : $madrinha->nome,   
            'livro'=>$certidao->livro,            
            'pagina'=>$certidao->folha,
            'id'=>$certidao->id,
            'celebrante'=>$celebrante->nome
        );
        
            //dd($dados);exit();
                
            
        
        return view('certidoes.certidao-batismo.form',compact('dados','ultimos','header'));
    }
  
    public function update(UpdateCertidaoBatismoRequest $request,$id)
    {
        $request->validated();
        $certidao = $this->certidao->find($id);
        $dadosForm = $request->except('_token','crianca','pai','mae','madrinha','padrinho','data_nascimento','celebrante');
        if(empty($dadosForm['duvidoso'])){
            $dadosForm['duvidoso']=false;
        }
        $pessoas = $request->only('crianca','pai','mae','madrinha','padrinho','data_nascimento','celebrante');        
        $this->pessoaUpdate($pessoas,$certidao);
        //echo "OK!"; exit; 
        $update = $certidao->update($dadosForm);
        if($update){
            notify()->success('Dados atualizados com sucesso!!');            
            return redirect()->route('certidao-batismo.index');
        }else{
            notify()->error('<b>Algo deu errado!!</b> Não foi possível atualizar seu registro.');
        }
        return redirect()->route('certidao-batismo.edit');
    }

    public function destroy($id)
    {
        //
        $delete = $this->certidao->find($id)->delete();
       
        if($delete){     
            echo"Entrou!!!";
            return true;
        }else{
            return false;
        }
    }
  
}
