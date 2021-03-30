<?php

namespace App\Http\Controllers\Painel\Estacionamento\Monthly;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Painel\Estacionamento\TablePrice\TablePriceController;
use App\Http\Controllers\Painel\Estacionamento\Time\TimeParkingController;
use App\Http\Controllers\Painel\Estacionamento\Payment\PaymentsController;
use App\Models\Painel\Estacionamento\Fluxo\Parking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class MonthlyPaysController extends Controller
{
    //
    public function create(Request $request){
        $dados = [];
        if(!empty($request->placa)){
            $dados['id'] ='2';
            if(!empty($request->placa)){
                $dados['placa']=$request->placa;
            }
            if(!empty($request->owner)){
                $dados['owner'] = $request->owner;
            }
            if(!empty($request->data_end)){
                $dados['date_beginning'] = date('Y-m-d',strtotime('+1 day',$request->data_end));
            }
            
            $dados['tipo_veiculo'] = $request->tipo_veiculo ?? '';
            
            if(!empty($request->id_parking)){
                $parking = DB::table('parking')->where('id',$request->id_parking)->first();                
                $lastPayed = DB::table('payments')->where('id',$parking->payment)->first();                
                $dados['discount'] = $lastPayed->discount==0 ? '': number_format($lastPayed->discount,2,',','.');
                $dados['justify'] = $lastPayed->justify_discount;                
                $tablePrice = TablePriceController::show($request->tipo_veiculo);                                
                $dados['valor'] = 'R$ '.number_format($tablePrice->mensalidade,2,',','.');
                $dados['valor_pagar']='R$ '.number_format(($tablePrice->mensalidade - $lastPayed->discount),2,',','.');
            }
            //dd($dados);
            return view('estacionamento.monthly.pays.form',['dados'=>$dados]);

        }else{
            $placas = DB::table('vehicle')->get();
            $option ='';
            foreach($placas as $placa){
                $option.='<option value="'.$placa->id.'">'.$placa->placa.'</option>';
            }
            return view('estacionamento.monthly.pays.form',['option'=>$option]);
        }
    }
    public function show($id_vehicle){
        $lastdata = DB::table('monthlyview')
        ->join('payments','payments.id','=','monthlyview.payment_id')
        ->join('vehicle','vehicle.id','=','monthlyview.vehicle_id')
        ->where('vehicle_id',$id_vehicle)->orderBy('parking_id', 'desc')->first();
        $tablePrice = TablePriceController::show($lastdata->typevehicle);
        return array(
            'valor'=>'R$ '.number_format($tablePrice->mensalidade,2,',','.'),
            'desconto'=>$lastdata->discount==0 ? '': number_format($lastdata->discount,2,',','.'),
            'typevehicle'=>$lastdata->typevehicle,
            'valor_pagar'=>'R$ '.number_format(($tablePrice->mensalidade - $lastdata->discount),2,',','.'),
            'justify'=>$lastdata->justify_discount,
            'parking_id'=>$lastdata->parking_id
        );
        
    }
    public function store(Request $request){
        if(!empty($request->placa)){
            $lastdata = DB::table('monthlyview')
            ->join('payments','payments.id','=','monthlyview.payment_id')
            ->join('vehicle','vehicle.id','=','monthlyview.vehicle_id')
            ->where('parking_id',$request->parking_id)->first();            
            $next_date = date('Y-m-d',strtotime('+1 days',strtotime($lastdata->end)));  
            $date_beginning = $next_date < date('Y-m-d',time()) ? date('Y-m-d',time()) : $next_date;
            $cash = floatval(str_replace(',','.',str_replace('.','',$request->cash)));
            $discount = !empty($request->discount) ? floatval(str_replace(',','.',str_replace('.','',$request->discount))) : 0;
            $justify = empty($request->justify) ? '' :  $request->justify;
            $value = floatval(str_replace(',','.',str_replace('.','',$request->valor)));

            $timeParking=TimeParkingController::store(['data_in'=>$date_beginning,'date_out'=>date('Y-m-d',strtotime("+30 days",strtotime($date_beginning))), 'hour_out'=>23,'min_out'=>59]);
            $payment = PaymentsController::store(['modality'=>'Mensalidade','value'=>$value,'discount'=>$discount,'justify_discount'=>$justify,'table_price'=>$request->table_price,'payed'=>$cash,'date_payed'=>date('Y-m-d',time())]);
    
            $dados = array(
                'payment'=>$payment->id,
                'time'=>$timeParking->id,
                'vehicle'=>$request->placa
            );
            $newPark = Parking::create($dados);
            if(!empty($payment->id) && !empty($newPark->id) ){
                return redirect()->route('monthly.index');
            }

        }else{
            return redirect()->back();
        }
    }
    public function print($id_parking){
        $lastdata = DB::table('monthlyview')
            ->join('payments','payments.id','=','monthlyview.payment_id')
            ->join('vehicle','vehicle.id','=','monthlyview.vehicle_id')
            ->where('parking_id',$request->parking_id)->first();   
            $tablePrice = TablePriceController::show($lastdata->typevehicle,$lastdata->table_price);
            $troco = (($tablePrice->mensalidade - $lastdata->discount) - $lastdata->payed) * (-1);
        return array(
            'placa'=>$lastdata->placa,
            'proprietario'=>$lastdata->owner,
            'data_inicio'=>date('d/m/Y',strtotime($lastdata->beginning)),
            'data_fim'=>date('d/m/Y',strtotime($lastdata->end)),
            'desconto'=>'R$ '.number_format($lastdata->discount,2,',','.'),
            'dinheiro'=>'R$ '.number_format($lastdata->payed,2,',','.'),
            'valor'=>'R$ '.number_format($tablePrice->mensalidade,2,',','.'),
            'troco'=>'R$ '.number_format($troco,2,',','.'),
        );
    }
}
