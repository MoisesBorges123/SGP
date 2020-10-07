<?php

namespace App\Http\Controllers\Painel\Livros;

use App\Http\Controllers\Controller;
use App\Models\Painel\Livros\Pagina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class PaginasController extends Controller
{
    private $paginas;
    public function __construct(Pagina $pages)
    {
        $this->paginas = $pages;
    }
    public function index(Request $request)
    {
        $paginas = DB::table('paginas')        
        ->where('livro','=',$request->livro)                                                   
        ->orderBy('id','ASC')
        ->get();
        //dd($paginas);exit();
        $dados = [];
        foreach($paginas as $pagina){
            
            $qtdeFotos=DB::table('fotos_livro')->where('pagina',$pagina->id)->count();
            $tamFotos=DB::table('fotos_livro')->where('pagina',$pagina->id)->sum('tamanho');
            $dados[]=['id'=>$pagina->id,'pagina'=>$pagina->numero,'qtdeFotos'=>$qtdeFotos,'tamanho'=>$tamFotos,'observacao'=>'Sem comentários.'];
        }
        //print_r($dados);
        //exit();
        return view('livros.paginas.table',compact('dados'));
    }
  
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Painel\Livros\Pagina  $pagina
     * @return \Illuminate\Http\Response
     */
    public function show($livro)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Painel\Livros\Pagina  $pagina
     * @return \Illuminate\Http\Response
     */
    public function edit(Pagina $pagina)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Painel\Livros\Pagina  $pagina
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pagina $pagina)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Painel\Livros\Pagina  $pagina
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pagina $pagina)
    {
        //
    }
}
