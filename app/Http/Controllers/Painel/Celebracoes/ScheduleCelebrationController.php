<?php

namespace App\Http\Controllers\Painel\Celebracoes;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Painel\Celebracoes\ScheduleCelebration;
use Illuminate\Http\Request;

class ScheduleCelebrationController extends Controller
{
    
    public function index()
    {
        //
    }

    public function create()
    {
        $header = $this->header(); 
        return view('celebrations.schedule_celebration.form',compact('header'));
    }

    public function store(Request $request)
    {
        //
    }

    public function show(ScheduleCelebration $scheduleCelebration)
    {
        //
    }

    public function edit(ScheduleCelebration $scheduleCelebration)
    {
        //
    }

    public function update(Request $request, ScheduleCelebration $scheduleCelebration)
    {
        //
    }

    private function header(){
        $totalIntentionsTODAY = DB::table('intention_scopes')->where('date_schedule','=',date('Y-m-d',time()))->count();        
        $totalIntentionsTOMORROW = DB::table('intention_scopes')->where('date_schedule','=',date('Y-m-d',strtotime("1 days",time())))->count();        
        $deathIntentions = DB::table('intention_scopes')
        ->join('intention_classes','intention_classes.id','=','intention_scopes.classification')
        ->where('date_schedule','>=',date('Y-m-d',time()))
        ->where('intention_classes.typeintention',1)
        ->count();
        $thanks_givenIntentions = DB::table('intention_scopes')
        ->join('intention_classes','intention_classes.id','=','intention_scopes.classification')
        ->where('date_schedule','>=',date('Y-m-d',time()))
        ->where('intention_classes.typeintention',2)
        ->count();
        
        $card =array(
            [
                'headerText'=>'Intenções <b>HOJE</b>',
                'headerNumber'=> $totalIntentionsTODAY,
                'bodyIcon'=>'<i class="fas fa-chart-bar"></i>',
                'color'=>'bg-danger',
                'url'=>route('certidao-batismo.filter',1)
                
            ],
            [
                'headerText'=> 'Intenções Amanhã',
                'headerNumber'=>$totalIntentionsTOMORROW,
                'bodyIcon'=>'<i class="fas fa-chart-pie"></i>',
                'color'=>'bg-warning',
                'url'=>''
            ],
            [
                'headerText'=>'Intenções Falecidos',
                'headerNumber'=>$deathIntentions,
                'bodyIcon'=>'<i class="fas fa-users"></i>',
                'color'=>'bg-yellow',
                'url'=>''
            ],
            [
                'headerText'=>'Intenções Ação de Graças',
                'headerNumber'=>$thanks_givenIntentions,
                'bodyIcon'=>'<i class="fas fa-percent"></i>',
                'color'=>'bg-info',
                'url'=>route('certidao-batismo.filter',2)
            ]           
            
        );
        
        return $card;
    }
    
}
