<?php

namespace App\Http\Controllers\Painel\Certidoes;

use App\Http\Controllers\Controller;
use App\Models\Painel\Certidao\CertidaoCasamento;
use App\Http\Requests\Painel\Certidoes\StoreCertidaCasamentoRequest;
use App\Http\Requests\Painel\Certidoes\UpdateCertidaCasamentoRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\PessoasController;

class CertidaoCasamentoController extends Controller
{
    private $certidaoCasamento;
    public function __construct(CertidaoCasamento $cert)
    {
        $this->certidaoCasamento = $cert;
    }   
    public function index()
    {
        $registros = $this->certidaoCasamento->all();
        $dados=[];
        foreach($registros as $casamento){
            $noivo = DB::table('pessoas')->where('id',$casamento->noivo)->first();
            $noiva = !empty($casamento->noiva) ? DB::table('pessoas')->where('id',$casamento->noiva)->first() : '';
            $celebrante = !empty($casamento->celebrante) ? DB::table('pessoas')->where('id',$casamento->celebrante)->first() : '';            
            $dados[]=[
                'id'=>$casamento->id,
                'noivo'=>$noivo->nome,
                'noiva'=> $noiva->nome ?? '',
                'celebrante'=> $celebrante->nome ?? '',                
                'data_casamento'=>date('d/m/Y',strtotime($casamento->data_crisma)),
            ];

            
        }
        $header = $this->header();

        return view('certidoes.certidao-casamento.table',compact('dados','header'));
    }
    public function create()
    {
        $header = $this->header();
        return view('certidoes.certidao-casamento.form',compact('header'));
    }
    public function store(StoreCertidaCasamentoRequest $request)
    {
        $pessoa  = new PessoasController;
        $r_noivo = array(
            'nome'=>$request->input('noivo')
        );
        $r_noiva = array(
            'nome'=>$request->input('noiva') ?? null
        );
        $r_celebrante = array(
            'nome'=>$request->input('celebrante') ?? null
        );
       
        $noivo = $pessoa->store($r_noivo);
        $noiva = $pessoa->store($r_noiva);
        $celebrante = !empty($r_celebrante) ? $pessoa->store($r_celebrante) : null;
        

        $dados = array(
            'noivo'=>$noivo->id,
            'noiva'=>$noiva->id,
            'celebrante'=>!empty($celebrante->id) ? $celebrante->id : null,
            'duvidoso'=> empty($request->input('duvidoso')) ? false : $request->input('duvidoso'),
            'livro'=>$request->input('livro'),
            'folha'=>$request->input('folha'),
            'data_casamento'=>$request->input('data_casamento'),
        );

        $insert = $this->certidaoCasamento->create($dados);
        if($insert){
            notify()->success('Registro salvo com sucesso!!');
            return redirect()->route('certidao-casamento.index');
        }else{
            notify()->error('Ocorreu um erro ao salvar os dados.');
            return redirect()->route('certidao-casamento.create');

        }
    }
    public function show($id)
    {
        $certidao=$this->certidaoCaamento->find($id);
        
        $noivo=DB::table('pessoas')->where('id',$certidao->noivo)->first();
        $noiva=DB::table('pessoas')->where('id',$certidao->noiva)->first();              
        $celebrante=DB::table('pessoas')->where('id',$certidao->celebrante)->first();
        $dados=array( 
            'duvidoso'=>$certidao->duvidoso,            
            'data_casamento'=>date('d/m/Y',strtotime($certidao->data_caamento)),
            'noivo'=>$noivo->nome,                        
            'noiva'=>$noiva->nome,            
            'celebrante'=>empty($celebrante->nome) ? 'Não cadastrado' : $celebrante->nome,                       
            'livro'=>$certidao->livro,            
            'pagina'=>$certidao->folha,
            'id'=>$certidao->id
        );        
        
        return view('certidoes.certidao-casamento.details',compact('dados'));
    }
    public function edit($id)
    {
        
        $casamento = $this->certidaoCasamento->find($id);
        $header = $this->header();        
        $dados = array(
            'id'=>$id,
            'noivo'=> empty($casamento->noivo) ? '' : DB::table('pessoas')->where('id',$casamento->noivo)->first()->nome,
            'noiva'=>empty($casamento->noiva) ? '' : DB::table('pessoas')->where('id',$casamento->noiva)->first()->nome,
            'celebrante'=>empty($casamento->celebrante) ? '' : DB::table('pessoas')->where('id',$casamento->celebrante)->first()->nome,
            'data_casamento'=>$casamento->data_casamento,
            'folha'=>$casamento->folha,
            'livro'=>$casamento->livro,
            'duvidoso'=>$casamento->duvidoso,           

        );
        
        return view('certidoes.certidao-casamento.form',compact('header','dados'));
    }
    
    public function update(UpdateCertidaCasamentoRequest $request, $id)
    {
        $casamento = $this->certidaoCasamento->find($id);
        $pessoas = $request->only('noivo','noiva','celebrante');
        $this->pessoaUpdate($pessoas,$casamento);
        $dados = $request->only('data_casamento','livro','folha','duvidoso');
        $dados['duvidoso'] = empty($dadosForm['duvidoso']) ? false : $dados['duvidoso'];
        $update = $casamento->update($dados);
        if($update){
            notify()->success('Registro atualizado com sucesso');
            return redirect()->route('certidao-casamento.index');
        }else{
            notify()->error('Não foi possível atualizar esse registro.');
            return redirect()->route('certidao-casamento.edit');
        }
    }   
    public function destroy($id)
    {
        $delete = $this->certidaoCasamento->find($id)->delete();
       
        if($delete){                 
            return true;
        }else{
            return false;
        }
    }
    private function header()
    {
        $totalCasamentos = $this->certidaoCasamento->where('data_casamento','like',date('Y',time()).'-%')->count();
        $totalRegIncosistente = $this->certidaoCasamento->where('duvidoso','1')->count();
        $totalRegistros = $this->certidaoCasamento->count();
        $totalLivrosDigitais = DB::table('fotos_livro')
        ->join('paginas','paginas.id','=','fotos_livro.pagina')
        ->join('livros','livros.id','=','paginas.livro')
        ->where('livros.sacramento','=',3)
        ->count('fotos_livro.foto');
        
        $card =array(
            [
                'headerText'=>'Casamentos '.date('Y',time()),
                'headerNumber'=> $totalCasamentos,
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
    private function pessoaUpdate($pessoas,$certidao)
    {
        $dados = [
            [
                'chave'=>'noivo',
                'nome'=>$pessoas['noivo'],
                'id'=>$certidao->noivo,                
            ],
            [
                'chave'=>'noiva',
                'nome'=>$pessoas['noiva'],
                'id'=>$certidao->noiva,
            ],
            [
                'chave'=>'celebrante',
                'nome'=>$pessoas['celebrante'],
                'id'=>$certidao->celebrante,
            ]           
            
           
        ];        
        $fnPessoa = new PessoasController;
        foreach($dados as $pessoa){            
            if(!empty($pessoa['nome']) && !empty($pessoa['id'])){
                $fnPessoa->update($pessoa);
            }else{
                if(!empty($pessoa['nome'])){
                    $insert=$fnPessoa->store($pessoa);                   
                    DB::table('certidao_casamento')->where('id',$certidao->id)->update(["'".$pessoa['chave']."'"=>$insert->id]);                    
                }
            }
        }  
             
    }
}
