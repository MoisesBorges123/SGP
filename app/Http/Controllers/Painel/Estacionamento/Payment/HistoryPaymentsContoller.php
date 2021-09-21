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
        $payments =HistoryPayment::where('date_payed','>=',date('Y-m-d',strtotime('-30 days',time())))
        ->get();
        
        return view('estacionamento.cash-history.table',compact('payments'));
        
    }
}
