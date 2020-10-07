<?php

namespace App\Http\Controllers\Painel\Livros;

use App\Http\Controllers\Controller;
use App\Models\Painel\Livros\Livro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class LivrosController extends Controller
{
    private $livro;
    public function __construct(Livro $book)
    {
        $this->livro = $book;
    }
    public function index()
    {
        $livros=$this
        ->livro                
        ->join('sacramentos','sacramentos.id','=','livros.sacramento')
        ->select('livros.*','sacramentos.nome as nome_sacramento')
        ->get();
        
        return view('livros.table',compact('livros'));
    }

    public function create()
    {
        //
    }
   
    public function store(Request $request)
    {
        $formData = $request->except('_token');
        $sacramento = DB::table('sacramentos')->find($request->input('sacramento'));
        $exite = $this->livro
        ->where('numero',$request->input('numero'))
        ->where('sacramento',$sacramento->id)
        ->first();
        if(empty($existe)){
            $insert = $this->livro->create($formData);
            if($insert){    
                
                for($i=1;$i<=$formData['qtdePaginas'];$i++){         
                    DB::table('paginas')->insert(['numero'=>$i,'livro'=>$insert->id]);               
                    DB::table('paginas')->insert(['numero'=>$i.'V','livro'=>$insert->id]);
          
                }
                
                $directory = "public/Registros/".ucwords($sacramento->nome)."/Livro_".$insert->numero;            
                $newDirectory = Storage::makeDirectory($directory);            
                return array('insert'=>true,'livro'=>$insert->id);
            }else{
                return array('insert'=>false,'livro'=>0);
            }            
        }else{
            return array('duplicate'=>true,'livro'=>0);
        }
    }
   
    public function show($livro)
    {
        $book = $this->livro
        ->join('sacramentos','sacramentos.id','=','livros.sacramento')
        ->where('livros.id',$livro)
        ->first();
        $pages = DB::table('paginas')        
        ->where('livro','=',$livro)        
        ->get();
        $totalPages = count($pages);
        $paginas = [];
        $espacoDisco=DB::table('paginas')
        ->where('paginas.livro','=',$livro)
        ->join('fotos_livro','paginas.id','=','fotos_livro.pagina')
        ->sum('fotos_livro.tamanho');
        $photos=DB::table('fotos_livro')
        ->join('paginas','paginas.id','=','fotos_livro.pagina')
        ->where('paginas.livro','=',$livro)
        ->select('fotos_livro.*','paginas.numero as nome_pagina')
        ->get();
        $totalUploads=DB::table('paginas')
        ->where('paginas.livro','=',$livro)
        ->join('fotos_livro','paginas.id','=','fotos_livro.pagina')
        ->count('fotos_livro.tamanho');
        $espacoDisco=$espacoDisco/1073741824;
        
        
     /*   foreach($db_paginas as $pagina){
            $qtdeFotos=DB::table('fotos_livro')->where('pagina',$pagina->id)->count();
            $tamFotos=DB::table('fotos_livro')->where('pagina',$pagina->id)->sum('tamanho');
            $paginas[]=['pagina'=>$pagina->numero,'qtdeFotos'=>$qtdeFotos,'tamanho'=>$tamFotos,'observacao'=>'Sem comentários.'];
        }*/
        $dados = array(
            'livro'=>$book,
            'paginas'=>$pages,
            'totalPaginas'=>str_pad($totalPages,2,'0',STR_PAD_LEFT),
            'espacoDisco'=>number_format($espacoDisco,2,'.',',')."GB",
            'fotosCadastradas'=>str_pad($totalUploads,2,'0',STR_PAD_LEFT),
            'fotos'=>$photos,
        );

        return view('livros.details',compact('dados'));
        
       
    }
  
    public function edit(Livro $livro)
    {
        //
    }

   
    public function update(Request $request, Livro $livro)
    {
        //
    }
   
    public function destroy($livro)
    {
       $book = $this->livro->find($livro);
       //dd($book);
        $pages = DB::table('paginas')
        ->where('paginas.livro',$book->id)
        ->get();
        
        if(count($pages)>0){
            foreach($pages as $pagina){
             DB::table('fotos_livro')
                ->where('fotos_livro.pagina','=',$pagina->id)
                ->delete();
            }
            DB::table('paginas')
            ->where('paginas.livro',$book->id)
            ->delete();
        }
        $sacramento = DB::table('sacramentos')->find($book->sacramento);
        $directory = "public/Registros/".ucwords($sacramento->nome)."/Livro_".$book->numero;        
        //dd($directory);
        $directoryDelete=Storage::deleteDirectory($directory);   
        
        if($directoryDelete){
            $deleteBook = $book->delete();        
        }else{
            $deleteBook =false;
        }   
        if($deleteBook && $directoryDelete){
            return array('excluir'=>true);
        }else{
            return array('excluir'=>false);
        }
        
    }
    public function search(Request $request)
    {/*
        if(isset($request->input('filter_book'))){
            $this->livro->where('id',$request->input('filter_book'));
        }
        */
    }
}
