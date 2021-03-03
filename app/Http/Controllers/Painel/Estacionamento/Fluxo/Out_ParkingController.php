<?php

namespace App\Http\Controllers\Painel\Estacionamento\Fluxo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Painel\Estacionamento\Fluxo\Parking;
use App\Models\Painel\Estacionamento\Views\ParkingCar;
use App\Http\Controllers\Painel\Estacionamento\Vehicles\VehiclesController;
use App\Http\Controllers\Painel\Estacionamento\Time\TimeParkingController;
use App\Http\Controllers\Painel\Estacionamento\Suport\FuncoesController;
use App\Http\Controllers\Painel\Estacionamento\Payment\PaymentsController;

class Out_ParkingController extends Controller
{
    public function store(Request $request){ 
        
        $parking = ParkingCar::where('parking_id',$request->cod)->first();    

        $time_update = TimeParkingController::updateOut(['time_id'=>$parking->timeparking_id,'hour_out'=>$request->h_saida,'min_out'=>$request->m_saida,'date_out'=>date('Y-m-d',time())]);
     
        if(!empty($time_update)){
            $valor = floatval(str_replace(',','.',str_replace('.','',str_replace('R$ ','',$request->valor))));
            $dinheiro = floatval(str_replace(',','.',str_replace('.','',str_replace('R$ ','',$request->dinheiro))));
            $desconto = empty($request->desconto) ? 0 : floatval(str_replace(',','.',str_replace('.','',str_replace('R$ ','',$request->desconto))));
            $valor = floatval(str_replace(',','.',str_replace('.','',str_replace('R$ ','',$request->valor))));
            $justificativa = $request->justificativa == 'false' ? '' : ucwords($request->justificativa);
            $payment_update = PaymentsController::update(['payment_id'=>$parking->payment_id,'value'=>$valor,'discount'=>$desconto,'justify_discount'=>$justificativa,'payed'=>$dinheiro,'data_payed'=>date('Y-m-d',time())]);            
        }
        if(!empty($payment_update)){
            return true;
        }else{
            return false;
        }
    }
    public function show($id){
        $parking = ParkingCar::where('parking_id',$id)->first();        
        return FuncoesController::calc_estacionamento($parking);
    }
}

