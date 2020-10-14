<?php

namespace App\Http\Controllers\Painel\Certidoes;

use App\Http\Controllers\Controller;
use App\Models\Painel\Certidao\CertidaoCrisma;
use Illuminate\Http\Request;
use App\Http\Requests\Painel\Certidoes\StoreCertidaoCrisma;
use App\Http\Requests\Painel\Certidoes\UpdateCertidaoCrismaRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\PessoasController;

class CertidaoCrismaController extends Controller
{
    private $certidaoCrisma;
    public function __construct(CertidaoCrisma $certidao)
    {
        $this->certidaoCrisma = $certidao;
    }
    private function header(){
        $totalCrismas = $this->certidaoCrisma->where('data_crisma','like',date('Y',time()).'-%')->count();
        $totalRegIncosistente = $this->certidaoCrisma->where('duvidoso','1')->count();
        $totalRegistros = $this->certidaoCrisma->count();
        $totalLivrosDigitais = DB::table('fotos_livro')
        ->join('paginas','paginas.id','=','fotos_livro.pagina')
        ->join('livros','livros.id','=','paginas.livro')
        ->where('livros.sacramento','=',2)
        ->count('fotos_livro.foto');
        
        $card =array(
            [
                'headerText'=>'Crismas '.date('Y',time()),
                'headerNumber'=> $totalCrismas,
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
                'headerText'=>'Páginas Digitalizadas',
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
    public function index()    
    {        
        $registros = $this->certidaoCrisma->all();
        $dados=[];
        foreach($registros as $crisma){
            $crismando = DB::table('pessoas')->where('id',$crisma->crismando)->first();
            $pai = !empty($crisma->pai) ? DB::table('pessoas')->where('id',$crisma->pai)->first() : '';
            $mae = !empty($crisma->mae) ? DB::table('pessoas')->where('id',$crisma->mae)->first() : '';
            $padrinho = !empty($crisma->padrinho) ? DB::table('pessoas')->where('id',$crisma->padrinho)->first() : null;
            $dados[]=[
                'id'=>$crisma->id,
                'crismando'=>$crismando->nome,
                'pai'=> $pai->nome ?? '',
                'mae'=> $mae->nome ?? '',
                'padrinho'=> $padrinho->nome ?? '',
                'data_crisma'=>date('d/m/Y',strtotime($crisma->data_crisma)),
            ];

            
        }
        $header = $this->header();

        return view('certidoes.certidao-crisma.table',compact('dados','header'));
    }

    public function create()
    {
        $header = $this->header();
        return view('certidoes.certidao-crisma.form',compact('header'));
    }

  
    public function store(StoreCertidaoCrisma $request)
    {
        $pessoa  = new PessoasController;
        $r_crismando = array(
            'nome'=>$request->input('crismando')
        );
        $r_pai = array(
            'nome'=>$request->input('pai') ?? null
        );
        $r_mae = array(
            'nome'=>$request->input('mae') ?? null
        );
        $r_padrinho = array(
            'nome'=>$request->input('padrinho') ?? null
        );
        $crismando = $pessoa->store($r_crismando);
        $pai = !empty($r_pai) ? $pessoa->store($r_pai) : null;
        $mae = !empty($r_mae) ? $pessoa->store($r_mae) : null;
        $padrinho = !empty($r_padrinho) ? $pessoa->store($r_padrinho) : null;

        $dados = array(
            'crismando'=>$crismando->id,
            'pai'=>!empty($pai->id) ? $pai->id : null,
            'mae'=>!empty($mae->id) ? $mae->id : null,
            'padrinho'=>!empty($padrinho->id) ? $padrinho->id : null,
            'livro'=>$request->input('livro'),
            'folha'=>$request->input('folha'),
            'data_crisma'=>$request->input('data_crisma'),
            'duvidoso'=> empty($request->input('duvidoso')) ? false : $request->input('duvidoso')
        );

        $insert = $this->certidaoCrisma->create($dados);
        if($insert){
            notify()->success('Registro salvo com sucesso!!');
            return redirect()->route('certidao-crisma.index');
        }else{
            notify()->error('Ocorreu um erro ao salvar os dados.');
            return redirect()->route('certidao-crisma.create');

        }
    }
  
    public function show($id)
    {
        $certidao=$this->certidaoCrisma->find($id);
        
        $crismando=DB::table('pessoas')->where('id',$certidao->crismando)->first();
        $pai=DB::table('pessoas')->where('id',$certidao->pai)->first();       
        $mae=DB::table('pessoas')->where('id',$certidao->mae)->first();       
        $padrinho=DB::table('pessoas')->where('id',$certidao->padrinho)->first();
        $dados=array( 
            'duvidoso'=>$certidao->duvidoso,            
            'data_crisma'=>date('d/m/Y',strtotime($certidao->data_crisma)),
            'crismando'=>$crismando->nome,                        
            'pai'=>empty($pai->nome) ? 'Não cadastrado' : $pai->nome,           
            'mae'=>empty($mae->nome) ? 'Não cadastrado' : $mae->nome,           
            'padrinho'=>empty($padrinho->nome) ? 'Não cadastrado' : $padrinho->nome,           
            'livro'=>$certidao->livro,            
            'pagina'=>$certidao->folha,
            'id'=>$certidao->id
        );        
        
        return view('certidoes.certidao-crisma.details',compact('dados'));
    }

   
    public function edit($id)    
    {
        $crisma = $this->certidaoCrisma->find($id);
        $header = $this->header();        
        $dados = array(
            'id'=>$id,
            'pai'=> empty($crisma->pai) ? '' : DB::table('pessoas')->where('id',$crisma->pai)->first()->nome,
            'mae'=>empty($crisma->mae) ? '' : DB::table('pessoas')->where('id',$crisma->mae)->first()->nome,
            'padrinho'=>empty($crisma->padrinho) ? '' : DB::table('pessoas')->where('id',$crisma->padrinho)->first()->nome,
            'data_crisma'=>$crisma->data_crisma,
            'folha'=>$crisma->folha,
            'livro'=>$crisma->livro,
            'duvidoso'=>$crisma->duvidoso,
            'crismando'=>empty($crisma->crismando) ? '' : DB::table('pessoas')->where('id',$crisma->crismando)->first()->nome,

        );
        
        return view('certidoes.certidao-crisma.form',compact('header','dados'));
    }

    public function update(UpdateCertidaoCrismaRequest $request,$id)
    {
        $crisma = $this->certidaoCrisma->find($id);
        $pessoas = $request->only('crismando','pai','mae','padrinho');
        $this->pessoaUpdate($pessoas,$crisma);
        $dados = $request->only('data_crisma','livro','folha','duvidoso');
        $dados['duvidoso'] = empty($dadosForm['duvidoso']) ? false : $dados['duvidoso'];
        $update = $crisma->update($dados);
        if($update){
            notify()->success('Registro atualizado com sucesso');
        }else{
            notify()->error('Não foi possível atualizar esse registro.');
        }
        return redirect()->route('certidao-crisma.index');

    }

    public function destroy($id)
    {
        $delete = $this->certidaoCrisma->find($id)->delete();
       
        if($delete){                 
            return true;
        }else{
            return false;
        }
    }
    private function pessoaUpdate($pessoas,$certidao)
    {
        $dados = [
            [
                'chave'=>'crismando',
                'nome'=>$pessoas['crismando'],
                'id'=>$certidao->crismando,                
            ],
            [
                'chave'=>'pai',
                'nome'=>$pessoas['pai'],
                'id'=>$certidao->pai,
            ],
            [
                'chave'=>'mae',
                'nome'=>$pessoas['mae'],
                'id'=>$certidao->mae,
            ],           
            [
                'chave'=>'padrinho',
                'nome'=>$pessoas['padrinho'],
                'id'=>$certidao->padrinho
            ],
           
        ];        
        $fnPessoa = new PessoasController;
        foreach($dados as $pessoa){            
            if(!empty($pessoa['nome']) && !empty($pessoa['id'])){
                $fnPessoa->update($pessoa);
            }else{
                if(!empty($pessoa['nome'])){
                    $insert=$fnPessoa->store($pessoa);                   
                    DB::table('certidao_crisma')->where('id',$certidao->id)->update(["'".$pessoa['chave']."'"=>$insert->id]);                    
                }
            }
        }  
             
    }
}
