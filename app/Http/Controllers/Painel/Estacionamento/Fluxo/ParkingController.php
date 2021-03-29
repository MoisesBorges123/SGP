<?php

namespace App\Http\Controllers\Painel\Estacionamento\Fluxo;

use App\Http\Controllers\Controller;
use App\Models\Painel\Estacionamento\Fluxo\Parking;
use App\Models\Painel\Estacionamento\Vehicle\Vehicle;
use App\Models\Painel\Estacionamento\Views\Monthly;
use App\Models\Painel\Estacionamento\Views\ParkingCar;
use Illuminate\Http\Request;
use App\Http\Controllers\Painel\Estacionamento\Vehicles\VehiclesController;
use App\Http\Controllers\Painel\Estacionamento\Time\TimeParkingController;
use App\Http\Controllers\Painel\Estacionamento\Suport\FuncoesController;
use App\Http\Controllers\Painel\Estacionamento\Payment\PaymentsController;
class ParkingController extends Controller
{
/**
 * TABELA DE ERROS
 * 2-Já está estacionado
 */
    
    public function index()
    {
        $dados = ParkingCar::all();
        $parking=[];
        foreach($dados as $dado){
            $values = FuncoesController::calc_estacionamento($dado);
            $dado['how_much']=$values['valor'];
            $dado['duration'] = $values['duracao'];
            array_push($parking,$dado);
        }
        $dados = array(
            'dados'=>$parking,            
            'total_registros'=>ParkingCar::all()->count(),
        );
        return $dados;
    }
    public function create()
    {
        $header = $this->header();
        $dados=null;
        return view('estacionamento.fluxo.table',compact('header','dados'));
    }
    public function store(Request $request)
    {
        
        //1-Conheço esse veículo?
        $vehicle = VehiclesController::show($request->placa);
        $vehicle = ! empty($vehicle) ? $vehicle : VehiclesController::store(['placa'=>strtoupper($request->placa),'typevehicle'=>$request->tipo_veiculo]);
        //2-Esse veículo está estacionado?
        $parking = Parking::where('vehicle',$request->placa)->where('payment','')->first();
        if(!empty($parking)){
            return array('error'=>2);
        }
        //3-Qual a modalidade do veiculo? Rotativo? Free?
            //3.1-Mensalista?
            $timeParking = TimeParkingController::store();
            $monthly = Monthly::where('placa',$request->placa)->first();
            if(!empty($monthly)){
                //O veículo é mensalista
                
                
                $dados = array(
                    'payment'=>$monthly->payment_id,
                    'time'=>$timeParking->id,
                    'vehicle'=>$vehicle->id,
                );
                $newPark = Parking::create($dados);
            }else{
                //O veículo não é mensalista. Ele é Free?
                $free=Vehicle::where('placa',$request->placa)
                ->where('insencao','1')
                ->first();
                if(!empty($free)){
                    //O veículo é free
                    
                    $dados =array(
                        'payment'=>1,
                        'time'=>$timeParking->id,
                        'vehicle'=>$vehicle->id
                    );
                    $newPark = Parking::create($dados);
                }else{
                    
                    //O veículo é rotativo
                    $payment = PaymentsController::store(['modality'=>ucwords($request->modalidade)]);
                    $dados = array(

                        'payment'=>$payment->id,
                        'time'=>$timeParking->id,
                        'vehicle'=>$vehicle->id
                    );
                    $newPark = Parking::create($dados);
                    
                  
                }
            }
            if(!empty($newPark)){
                return array(
                    'insert'=>true,
                    'id'=>$newPark->id
                );
            }
    }
    public function fetchHeader(){
        return FuncoesController::calc_header();
    }
    public function show(Parking $parking)
    {
        //
    }
    public function edit(Parking $parking)
    {
        //
    }
    public function update(Request $request, Parking $parking)
    {
        //
    }
    public function delete(Request $request)
    {
        $parking = Parking::where('id',$request->id)->first();        
        $delete = $parking->delete();
        $deleteTime = TimeParkingController::destroy($parking->time);
        $deletePayment = PaymentsController::destroy($parking->payment);
       return $delete;
    }
    
    private function header(){
        $dailyCashier = PaymentsController::show(date('Y-m-d',time()));
        $total_card1 = $dailyCashier->sum('value') - $dailyCashier->sum('discount');
        $total_card2 = sprintf("%02d",ParkingCar::all()->count());        
        $total_card4 = sprintf("%02d",Monthly::all()->count());

        $card =array(
            [
                'headerText'=>'Faturamento do Dia',
                'headerNumber'=> "<div id='headerNumber1'>R$ ".number_format($total_card1,2,',','.')."</div>",
                'bodyIcon'=>'<i class="ni ni-money-coins"></i>',
                'color'=>'bg-green',
                'url'=>route('certidao-batismo.filter',1),
                'footerText'=>'<button id="btn-print-caixa" class="btn btn-primary btn-sm">Imprimir Relatório</button>'
                
            ],
            [
                'headerText'=> 'Carros Estacionados',
                'headerNumber'=>"<div id='headerNumber2'>".$total_card2."</div>",
                'bodyIcon'=>'<i class="ni ni-bus-front-12"></i>',
                'color'=>'bg-warning',
                'url'=>'',
                'footerText'=>'',
                
                
            ],
            [
                'headerText'=>'Valor a receber',
                'headerNumber'=>"<div id='headerNumber3'>R$ 0,00</div>",
                'bodyIcon'=>'<i class="ni ni-chart-pie-35"></i>',
                'color'=>'bg-yellow',
                'url'=>'',
                'footerText'=>'',
                
            ],
            [
                'headerText'=>'Total Mensalistas',
                'headerNumber'=>"<div id='headerNumber4'>".$total_card4."</div>",
                'bodyIcon'=>'<i class="ni ni-diamond"></i>',
                'color'=>'bg-info',
                'url'=>'',
                'identify'=>'avisos',
                'footerText'=>'<button id="btn-detalhes-mensalista" class="btn btn-info btn-sm">Detalhes</button>'
            ]           
            
        );
        
        return $card;
    }
}
