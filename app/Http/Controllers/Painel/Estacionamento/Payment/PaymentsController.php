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
        $update = $pay->update($payment);
        return $update;
    }
}
