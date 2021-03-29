<?php

namespace App\Http\Controllers\Painel\Estacionamento\Analyse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Painel\Estacionamento\Payment\PaymentsController;
class ReportController extends Controller
{
    //
    public function reportDaily(Request $request){
        $payeds = PaymentsController::show(date('Y-m-d',time()));        
        $rotativo_count = 0;
        $mendalidades_count = 0;
        $rotativo_value = 0;
        $mendalidades_value = 0;
        $total_count = count($payeds);
        $total_value = 0;
        $deficit = floatval(str_replace(',','.',str_replace('.','',$request->deficit)));;
        foreach($payeds as $payed){
            if($payed->modality == 'Rotativo' || $payed->modality == 'Diaria' || $payed->modality == 'Pernoite'){
                $rotativo_count++;
                $rotativo_value += ($payed->value - $payed->discount);
            }else if($payed->modality == 'Mensalidade'){
                $mendalidades_count++;
                $mendalidades_value += ($payed->value - $payed->discount);
            }
        }
        $total_value = $mendalidades_value+$rotativo_value;

        return array(
            'tn_rotativo'=>sprintf("%04d",$rotativo_count),
            'tv_rotativo'=>'R$ '.number_format($rotativo_value,2,',','.'),
            'tv_mensalidade'=>'R$ '.number_format($mendalidades_value,2,',','.'),
            'tn_mensalidade'=>sprintf("%04d",$mendalidades_count),
            'tv_geral'=>'R$ '.number_format($total_value,2,',','.'),
            'defict'=>'R$ '.number_format($deficit,2,',','.'),
            'observacoes'=>ucwords($request->observacoes)
        );
    }
}
