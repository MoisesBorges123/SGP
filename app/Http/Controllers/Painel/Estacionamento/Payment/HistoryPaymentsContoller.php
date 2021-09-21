<?php

namespace App\Http\Controllers\Painel\Estacionamento\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Painel\Estacionamento\Payment\HistoryPayment;
class HistoryPaymentsContoller extends Controller
{
    //

    public function index(){    
        date_default_timezone_set('America/Sao_Paulo');    
        //dd(date('Y-m-d',strtotime('-30 days',time())));
        $payments =HistoryPayment::where('date_payed','>=',date('Y-m-d',strtotime('-30 days',time())))
        ->orderby('date_payed','desc')
        ->get();
        
        return view('estacionamento.cash-history.table',compact('payments'));
        
    }
}
