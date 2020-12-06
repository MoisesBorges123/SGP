<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Models\Telefone;
use Illuminate\Http\Request;

class TelefoneController extends Controller
{
    private $telefone;    
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }
    
    public function store($request)
    {
        $telefone = new Telefone;
        $nTelefones = count($request['telefone']);
        if($nTelefones >= 1){
            foreach($request['telefone'] as $phone){
                //dd(['pessoa'=>$request['pessoa'],'telefone'=>$phone]);
                $insert = $telefone->created(['pessoa'=>$request['pessoa'],'telefone'=>$phone]);
            }
        }
        return $insert;
    }

    public function show(Telefone $telefone)
    {
        //
    }

    public function edit(Telefone $telefone)
    {
        //
    }

    public function update(Request $request, Telefone $telefone)
    {
        //
    }

    public function destroy(Telefone $telefone)
    {
        //
    }
}
