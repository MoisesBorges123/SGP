<?php

namespace App\Http\Controllers\Painel\Livros;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Painel\Livros\UploadFotos;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
class FotosController extends Controller
{
    private $fotos;
    public function __construct(UploadFotos $photos)
    {   
        $this->fotos = $photos; 
    }
    public function index(Request $request){
        //return view()
    }
    public function list($livro)
    {
        $dados = DB::table('paginas')       
        ->where('livro','=',$livro)
        ->join('livros','livros.id','=','paginas.livro') 
        ->join('fotos_livro','paginas.id','=','fotos_livro.pagina')       
        ->select('paginas.*','livros.numero as numero_livro','fotos_livro.foto','fotos_livro.tamanho','fotos_livro.caminho')
        ->get();
        return $dados;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
        if(!empty($request->pagina)){
            $dados = DB::table('paginas')->where('id',$request->pagina)->first();                        
            $imagens = $this->fotos->where('pagina',$request->pagina)->get();         
            if(!empty($request->excluir)){
                return view('livros.upload.delete',compact('dados','imagens'));
            }
            return view('livros.uploads.form',compact('dados','imagens'));
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $livro=DB::table('livros')
        ->where('livros.id',$request->input('livro'))
        ->join('sacramentos','sacramentos.id','=','livros.sacramento')
        ->select('livros.*','sacramentos.nome as nome_sacramento')
        ->first();
        
        $extencao=$request->file('foto')->extension();
        $tamanho=$request->file('foto')->getSize();
        $pagina = DB::table('paginas')
        ->where('numero',$request->input('pagina'))
        ->where('livro',$request
        ->input('livro'))
        ->first();
        $nameFile=uniqid(time()).".".$extencao;
        $caminho = "Registros/".ucwords($livro->nome_sacramento)."/Livro_".$livro->numero."/".$request->input('pagina');
        $upload=$request->file('foto')->storeAs("public/".$caminho,$nameFile);
        if($upload){
            $dado = array(
                'foto'=>$nameFile,
                'tamanho'=>$tamanho,
                'caminho'=>strval($caminho),
                'pagina'=>$pagina->id
            );
            
             $this->fotos->create($dado);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
