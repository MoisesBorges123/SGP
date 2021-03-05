<?php

namespace App\Http\Controllers\Painel\Estacionamento\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Painel\Estacionamento\Precos\TablePrice;
use App\Models\Painel\Estacionamento\Payment\Payment;
class PaymentsController extends Controller
{
    //
    public static function store($dados =[]){
        $precoBase = TablePrice::max('id');       
        $dados['table_price'] = $precoBase;
        return Payment::create($dados);
    }
    public static function destroy($payment){
        $pay = Payment::where('id',$payment)->first();
        $delete = $pay->delete();
        return $delete;
    }
    public static function update($payment){
        $pay = Payment::where('id',$payment['payment_id'])->first();
        $payment['date_payed'] = date('Y-m-d',time());
        $update = $pay->update($payment);
        return $update;
    }
    public static function show($date){
        return Payment::where('date_payed',$date)->get();
    }
}
