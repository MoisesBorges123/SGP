<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Painel\Celebracoes\IntencaoController;
use App\Models\Painel\Celevracoes\Intencao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
USE App\Models\Painel\Estacionamento\Views\MonthlyActive;

class DashboardController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        $dados = array(
            'mensalistas_ativos'=>MonthlyActive::where('day_left','<',7)->orderBy('day_left')->get()
        );
        
        return view('dashboard',compact('dados'));
    }
    private function tableIntentions(){
        $scopes = DB::table('intention_scopes')->where('date_schedule','>=',date('Y-m-d',time()))->get();
        if(count($scopes)>0){
            $intentionModel = new Intencao;
            $intentionController = new IntencaoController($intentionModel);
            return $intentionController->mountedIntention($scopes);
        }else{
            return false;
        }
    }
}
