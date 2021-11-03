<?php

namespace App\Http\Controllers\Painel\Estacionamento\Monthly;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\PessoasController;
use App\Models\Painel\Estacionamento\Fluxo\Parking;
use App\Models\Painel\Estacionamento\Views\Monthly;
use App\Models\Painel\Estacionamento\Views\MonthlyActive;
use App\Http\Controllers\Painel\Estacionamento\Vehicles\VehiclesController;
use App\Http\Controllers\Painel\Estacionamento\Time\TimeParkingController;
use App\Http\Controllers\Painel\Estacionamento\Payment\PaymentsController;
use App\Http\Controllers\Painel\Estacionamento\Suport\FuncoesController;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Foreach_;

class MonthlyController extends Controller
{
 
  
    public function index()
    {
        //
        $monthlys_inactives= Monthly::where('beginning','>',date('Y-m-d',strtotime('-60 days',time())))->where('end','<',date('Y-m-d',time()))->get();
        $monthlys_actives= Monthly::where('end','>=',date('Y-m-d',time()))->orderBy('beginning','desc')->get();
        
        
        $dados=[];
        foreach($monthlys_actives as $monthly){
            $monthly_active= MonthlyActive::where('owner',$monthly->owner)->get();
            if(count($monthly_active) > 0){              
                
                $telefone = DB::table('telefone')->where('pessoa',$monthly->owner_id)->orderBy('created_at','desc')->first();
                $today = date('Y-m-d',time());
                $intervalo = (strtotime($monthly->end) - strtotime($today)) / ((60 * 60 * 24));            
                if($intervalo >= 21){
                    $classe = 'bg-success';
                }else if($intervalo<21 && $intervalo >10){
                    $classe='bg-warning';
                }else{
                    $classe = 'bg-danger';
                }
                $progresso = (100*$intervalo) /30;
                //dd($monthly->owner);
                $dados[]= [
                    'id'=>$monthly->parking_id,                    
                    'responsavel'=>$monthly->owner,
                    'telefone'=>empty($telefone->telefone) ? '' :  $telefone->telefone,
                    'placa'=>$monthly->placa,
                    'tipo_veiculo'=>$monthly->typevehicle == 1 ? 'Carro':'Moto',
                    'inicio'=>date('d/m/Y',strtotime($monthly->beginning)),
                    'encerramento'=>date('d/m/Y',strtotime($monthly->end)),
                    'intervalo'=>$intervalo,
                    'classe'=>$classe,
                    'progresso'=>$progresso,
                    
                ];
            }
                
                
        }
        
        foreach($monthlys_inactives as $monthly){
            $monthly_active= MonthlyActive::where('owner',$monthly->owner)->get();
            if(count($monthly_active) == 0){              
                
                $telefone = DB::table('telefone')->where('pessoa',$monthly->owner_id)->orderBy('created_at','desc')->first();
                $today = date('Y-m-d',time());
                $intervalo = (strtotime($monthly->end) - strtotime($today)) / ((60 * 60 * 24))*-1;            
                $classe = 'bg-default';                          
                $progresso =0;
                //dd($monthly);
                $dados[]= [
                    'id'=>$monthly->parking_id,
                    'responsavel'=>$monthly->owner,
                    'telefone'=>empty($telefone->telefone) ? '' :  $telefone->telefone,
                    'placa'=>$monthly->placa,
                    'tipo_veiculo'=>$monthly->typevehicle == 1 ? 'Carro':'Moto',
                    'inicio'=>date('d/m/Y',strtotime($monthly->beginning)),
                    'encerramento'=>date('d/m/Y',strtotime($monthly->end)),
                    'intervalo'=>'Ha '.number_format($intervalo,'0',',','.').' dias atrás.',
                    'classe'=>$classe,
                    'progresso'=>$progresso,
                    
                ];
            }
                
                
        }
        
           
            //dd($dados);
            
        return view('estacionamento.monthly.table',compact('dados'));
        
    }
    public function create()
    {
        //
        return view('estacionamento.monthly.form');
    }
    public function store(Request $request)
    {
        
        $value = floatval(str_replace(',','.',str_replace('.','',str_replace('R$ ','',$request->preco))));        
        $cash = floatval(str_replace(',','.',str_replace('.','',$request->cash)));
        $discount = !empty($request->discount) ? floatval(str_replace(',','.',str_replace('.','',$request->discount))) : 0;
        $justify = empty($request->justify) ? '' :  $request->justify;              
        $fnPessoa = new PessoasController;
        $pessoa = $fnPessoa->store(['nome'=>$request->nome,'telefone'=>$request->phone,'email'=>$request->email]);
      
        $vehicle = VehiclesController::store(['pessoa'=>$pessoa->id,'placa'=>strtoupper($request->placa),'typevehicle'=>$request->tipo_veiculo]);
        $timeParking=TimeParkingController::store(['date_out'=>date('Y-m-d',strtotime("+30 days",strtotime(date('Y-m-d',time())))), 'hour_out'=>date('H',time()),'min_out'=>date('i',time())]);
        $payment = PaymentsController::store(['modality'=>'Mensalidade','value'=>$value,'discount'=>$discount,'justify_discount'=>$justify,'table_price'=>$request->table_price,'payed'=>$cash,'date_payed'=>date('Y-m-d',time())]);
        
        $dados = array(
            'payment'=>$payment->id,
            'time'=>$timeParking->id,
            'vehicle'=>$vehicle->id
        );
        $newPark = Parking::create($dados);
        if(!empty($payment->id) && !empty($vehicle->id) && !empty($newPark->id) ){
            return redirect()->route('monthly.index');
        }

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
