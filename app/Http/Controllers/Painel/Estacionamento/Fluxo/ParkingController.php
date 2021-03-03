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
      
        
        $card =array(
            [
                'headerText'=>'Intenções p/ <b>HOJE</b>',
                'headerNumber'=> 0,
                'bodyIcon'=>'<i class="fas fa-calendar-check"></i>',
                'color'=>'bg-green',
                'url'=>route('certidao-batismo.filter',1),
                
                
            ],
            [
                'headerText'=> 'Intenções p/ Amanhã',
                'headerNumber'=>0,
                'bodyIcon'=>'<i class="fas fa-history"></i>',
                'color'=>'bg-warning',
                'url'=>'',
                
                
            ],
            [
                'headerText'=>'Intenções Falecidos',
                'headerNumber'=>0,
                'bodyIcon'=>'<i class="fas fa-dizzy"></i>',
                'color'=>'bg-yellow',
                'url'=>'',
                
                
            ],
            [
                'headerText'=>'Avisos Sacristia',
                'headerNumber'=>0,
                'bodyIcon'=>'<i class="fas fa-bell"></i>',
                'color'=>'bg-info',
                'url'=>'',
                'identify'=>'avisos'
            ]           
            
        );
        
        return $card;
    }
}
