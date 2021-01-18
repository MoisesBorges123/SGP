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
    
    public static function store($request)    {
        
        
        
        if(is_array($request['telefone'])){
            foreach($request['telefone'] as $phone){
                //dd(['pessoa'=>$request['pessoa'],'telefone'=>$phone]);
                $insert = Telefone::create(['pessoa'=>$request['pessoa'],'telefone'=>$phone]);
            }
        }else{
            $insert = Telefone::create(['pessoa'=>$request['pessoa'],'telefone'=>$request['telefone']]);
            //dd($insert);
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

    public static function update($dados)
    {
        $phone = Telefone::where('pessoa',$dados['id'])->first();
        return $phone->update($dados);
    }

    public function destroy(Telefone $telefone)
    {
        //
    }
}
