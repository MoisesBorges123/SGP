<?php

namespace App\Http\Controllers\Painel\Estacionamento\Payment;

use App\Http\Controllers\Controller;
use App\Models\Painel\Estacionamento\Fluxo\Parking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Painel\Estacionamento\Payment\HistoryPayment;
use App\Models\Painel\Estacionamento\Payment\Payment;

class HistoryPaymentsContoller extends Controller
{
    //

    public function index(){    
        date_default_timezone_set('America/Sao_Paulo');    
        //dd(date('Y-m-d',strtotime('-30 days',time())));
        //date('Y-m-d',strtotime('-30 days',time()))
        $payments =HistoryPayment::where('date_payed','>=','2000-01-01')
        ->orderby('date_payed','desc')
        ->get();
        
        return view('estacionamento.cash-history.table',compact('payments'));
        
    }
    public function show($data){
        $payments = Parking::join('payments','payments.id','=','parking.payment')
        ->join('vehicle','vehicle.id','=','parking.vehicle')
        ->where('payments.date_payed',$data)        
        ->get();
        dd($payments[0]->payment_info);
        return view('estacionamento.cash-history.details',compact('payments'));
    }
}
