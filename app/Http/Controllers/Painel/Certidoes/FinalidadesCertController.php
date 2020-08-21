<?php

namespace App\Http\Controllers\Painel\Certidoes;

use App\Http\Controllers\Controller;
use App\Models\Painel\Certidao\Finalidade;
use Illuminate\Http\Request;

class FinalidadesCertController extends Controller
{
    
    private $finalidade;
    public function __construct(Finalidade $goal)
    {
        $this->finalidade = $goal;
    }

    public function index()
    {
        
        $registros = $this->finalidade->all();
        $dados=[];
        foreach($registros as $registro){
            $dados[]=array('value'=>$registro->id,'option'=>$registro->finalidade);
        }
        
        return json_encode($dados);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Finalidade $finalidade)
    {
        //
    }

   
    public function edit(Finalidade $finalidade)
    {
        //
    }

    
    public function update(Request $request, Finalidade $finalidade)
    {
        //
    }

    public function destroy(Finalidade $finalidade)
    {
        //
    }
}
