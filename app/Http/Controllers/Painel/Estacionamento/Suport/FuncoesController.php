<?php

namespace App\Http\Controllers\Painel\Estacionamento\Suport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Painel\Estacionamento\Precos\TablePrice;
use App\Models\Painel\Estacionamento\Precos\MotocyclePrice;
use App\Models\Painel\Estacionamento\Precos\CarPrice;

class FuncoesController extends Controller
{
    //Calcula Preço
    public static function calc_estacionamento($carro){
            
        //=============================================ENTRADAS=========================================||
        /*||*/    $hora_saida = empty($carro['hour_out']) ? date('H',time()) : intval($carro['hour_out']);/*||*/
        /*||*/    $min_saida = empty($carro['min_out']) ? date('i',time()) : intval($carro['min_out']);/*   ||*/
        /*||*/    $hora_entrada = intval($carro['hour_in']);/*                                             ||*/
        /*||*/    $min_entrada = intval($carro['min_in']);/*                                               ||*/
        /*||*/    $modalidade = $carro['modality'];/*                                                 ||*/
        /*||*/    $id_base_calculo = TablePrice::max('id');/*                                             ||*/
        /*||*/    $base_calculo = TablePrice::where('id',$id_base_calculo)->first();/*                                             ||*/
                  $carPrice = CarPrice::where('id',$base_calculo->car_price)->first();
                  $motocyclePrice = MotocyclePrice::where('id',$base_calculo->motocycle_price)->first();
        /*||*/    $tipo_veiculo = $carro['typevehicle'];/*                                             ||*/
        /*||*/    $tolerancia = isset($carro['tolerancia']) ? $carro['tolerancia']:0 ;/*                ||*/
        /*||*/    $mensalista = false; $rotativo = false; $free = false;               /*                ||*/
        /*||*/    $data_entrada = $carro['date_in'];/*                                             ||*/
        /*||*/    $data_atual = date('Y-m-d',time());/*                                                 ||*/
        /*||*/    $valor = 0;/*                                                                         ||*/
        /*||*/    $tempo_token = empty($carro['tempo_token']) ? 0 : $carro['tempo_token'];/*            ||*/
        /*||*/    $placa = empty($carro['placa']) ? '' : $carro['placa'];/*            ||*/
        //==============================================================================================||
        
      
        
        //====================PROCESSAMENTO=================================================||
            //CASO A PESSOA ENTROU NO DIA ANTERIO   
            
            if($data_entrada<$data_atual){
                $hora_saida=18;
                $min_saida=0;
            }
            
            //CALCULADO MINUTOS ESTACIONADO (INICIO)
            if ($min_saida < $min_entrada) {
                $min_saida2 = $min_saida + 60;                
                $hdif = 1;
                $mins_estacionado = $min_saida2 - $min_entrada;
            } else {
                $mins_estacionado = $min_saida - $min_entrada;
                $hdif = 0;
            }
            //CALCULADO MINUTOS ESTACIONADO (FIM)
            
            //CALCULO DE HORAS ESTACIONADAS
            
            $horas_estacionado = $hora_saida-$hora_entrada-$hdif;
            $original_duracao = sprintf("%02d",$horas_estacionado)."h ".sprintf("%02d",$mins_estacionado)."min(s)";
           
            // DESCONTO TOKEN (INICIO)
            if($tempo_token!=0){
                $token = true;                
                if($mins_estacionado<$tempo_token['min']){
                    if($horas_estacionado>0){
                        $mins_estacionado+=60;
                        $horas_estacionado--;
                        $mins_estacionado = $mins_estacionado-$tempo_token['min'];
                    }else{
                        $mins_estacionado=0;
                    }
                }else{
                    $mins_estacionado = $mins_estacionado-$tempo_token['min'];
                }   
                if($horas_estacionado<=0){
                    $horas_estacionado=0;
                }else{
                    if($horas_estacionado<$tempo_token['hora']){
                        $horas_estacionado=0;
                    }else{
                        $horas_estacionado =  $horas_estacionado - $tempo_token['hora'];                       

                    }
                }
                            
            }else{
                $token  = false;
            }
            // DESCONTO TOKEN (FIM)
            
            $duracao = sprintf("%02d",$horas_estacionado)."h ".sprintf("%02d",$mins_estacionado)."min(s)";
            
            
            //O CARRO SE ENCONTRA EM QUAL MODALIDADE?       
            switch ($modalidade) {
                    //1.O CARRO ESTÁ COMO DIARISTA?

                    case "Diaria":
                         if($tipo_veiculo==1){                            
                            $valor = $carPrice->diaria;
                         }else{
                            $valor = $motocyclePrice->diaria;
                         }                     
                      
                        $rotativo = true;
                        
                    break;
                    //2.O CARRO ESTÁ COMO MENSALISTA?
                    case "Mensalidade":
                        $valor=0;
                        $mensalista = true;
                       
                    break;
                    //3.O CARRO ESTÁ COMO PERNOITE?
                    case "Pernoite":
                        if($tipo_veiculo==1){                            
                            $valor = $carPrice->pernoite;
                         }else{
                            $valor = $motocyclePrice->pernoite;
                         }                     
                      
                        $rotativo = true;
                    break;
                    //4.O CARRO ESTÁ POR HORA?
                    case "Rotativo":
                        
                        //4.1 O carro ficou mais de 1h?
                        if($horas_estacionado>0){//=======SIM (O CARRO FICOU MAIS DE 1H ESTACIONADO)
                             

                            if($tipo_veiculo==1){                            
                                $preco = $carPrice->min_60;
                            }else{
                                $preco = $motocyclePrice->min_60;
                            }                         
                            $valor+= $preco*$horas_estacionado;                           
                            
                        }else{//==========================NÃO (O CARRO NÃO FICOU MAIS DE 1H ESTACIONADO)

                        }
                        
                         //4.2 O carro ficou algum minuto estacionado?
                         if($mins_estacionado>0){//=======SIM (O CARRO FICOU ALGUNS MINS ESTACIONADO)
                            if($mins_estacionado>$tolerancia && $mins_estacionado<=$tolerancia+15){
                                if($tipo_veiculo==1){                            
                                    $preco = $carPrice->min_15;
                                }else{
                                    $preco = $motocyclePrice->min_15;
                                } 
                                
                                $valor+= $preco;
                            }else if($mins_estacionado>$tolerancia+15 && $mins_estacionado<=$tolerancia+30){
                                if($tipo_veiculo==1){                            
                                    $preco = $carPrice->min_30;
                                }else{
                                    $preco = $motocyclePrice->min_30;
                                } 
                                $valor+= $preco;
                            }else if($mins_estacionado>$tolerancia+30){
                                if($tipo_veiculo==1){                            
                                    $preco = $carPrice->min_60;
                                }else{
                                    $preco = $motocyclePrice->min_60;
                                } 
                                $valor+= $preco;
                            }
                        }else{//=====================NÃO (O CARRO NÃO FICOU ALGUNS MINS ESTACIONADO)
                            $valor+=0;
                        }
                        
                        $rotativo = true;
                        
                    break;
                    case "Free":
                        $free=true;
                        //$duracao = "<i>Grátis</i>";
                    break;
            }
            
    
            
        //  ||======================================RETORNO============================================================||           
        /*  ||      */  return array(
            'valor'=>"R$ ".number_format($valor,2,',','.'),
            'duracao'=>$duracao,
            'mensalista'=>$mensalista,
            'free'=>$free,
            'rotativo'=>$rotativo,
            'token'=>$token,
            'duracao_original'=>$original_duracao,
            'hora_saida'=>$hora_saida,
            'min_saida'=>$min_saida,
            'data_saida'=>date('Y-m-d',time()),
            'hora_entrada'=>$hora_entrada,
            'min_entrada'=>$min_entrada,
            'data_entrada'=>$data_entrada,
            'tipo_veiculo'=>$tipo_veiculo,
            'placa'=>$placa);//             ||
        //  ||=========================================================================================================||
    }

}
