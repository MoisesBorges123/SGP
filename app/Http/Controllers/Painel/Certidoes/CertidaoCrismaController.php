<?php

namespace App\Http\Controllers\Painel\Certidoes;

use App\Http\Controllers\Controller;
use App\Models\Painel\Certidao\CertidaoCrisma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            $padrinho = !empty($crisma->padrinho) ? DB::table('pessoas')->where('id',$crisma->pai)->first() : null;
            $dados[]=[
                'crismando'=>$crismando->nome,
                'pai'=> $pai->nome ?? '',
                'mae'=> $mae->nome ?? '',
                'padrinho'=> $padrinho->nome ?? '',
                'data_crisma'=>$crisma->data_crisma,
            ];

            
        }
        $header = $this->header();

        return view('certidoes.certidao-crisma.table',compact('dados','header'));
    }

    public function create()
    {
        //
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

  
    public function show()
    {
        //
    }

   
    public function edit(CertidaoCrisma $certidaoCrisma)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Painel\Certidao\CertidaoCrisma  $certidaoCrisma
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CertidaoCrisma $certidaoCrisma)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Painel\Certidao\CertidaoCrisma  $certidaoCrisma
     * @return \Illuminate\Http\Response
     */
    public function destroy(CertidaoCrisma $certidaoCrisma)
    {
        //
    }
}
