<?php

namespace App\Http\Controllers\Painel\Celebracoes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Painel\Celebracoes\IntencaoController;
use App\Models\Painel\Celevracoes\Intencao;
class AvisosIntencoesController extends Controller
{
    
    public function index()// load all notices    
    {
    
        $scopes = DB::table('intention_scopes')
        ->where('date_schedule','>=',date('Y-m-d',time()))
        ->whereNotNull('observations')
        //->select('observations')
        ->get();
        
        if(count($scopes)>0){
            $intentionModel = new Intencao;
            $intentionController =  new  IntencaoController($intentionModel);
            $intentions = $intentionController->mountedIntention($scopes);
            //dd($intentions);
            $i=0;
            $observation = '';
            foreach($scopes as $scope){
                $observation.='<p class="text-justify">'.ucfirst($scope->observations).'<b> - '.$intentions[$i]['intention'].'</b> '.'</p>';
                $i++;
            }
            return array('observations'=>$observation);
        }else{
            return array('observations'=>'Não há observações.');

        }
    }

    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

  
    public function edit($id)
    {
        //
    }

   
    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
