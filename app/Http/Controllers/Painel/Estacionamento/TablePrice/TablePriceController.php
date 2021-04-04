<?php

namespace App\Http\Controllers\Painel\Estacionamento\TablePrice;
use App\Models\Painel\Estacionamento\Precos\TablePrice;
use App\Models\Painel\Estacionamento\Precos\MotocyclePrice;
use App\Models\Painel\Estacionamento\Precos\CarPrice;
use App\Http\Requests\Painel\Estacionamento\StoreTablePriceRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TablePriceController extends Controller
{

    public function index()
    {
        $title = 'Histórico de Preço';
        $base_prices = TablePrice::orderBy('created_at','asc')->get();
        
        foreach($base_prices as $base){
            
            $priceMotocycle = MotocyclePrice::where('id',$base->motocycle_price)->first();
            $priceCar = CarPrice::where('id',$base->car_price)->first();
            
            $dados[]=[
                'id'=>$base->id,
                'created_at'=>date('d/m/Y - H:i:s',strtotime($base->created_at)),
                'carPrice'=>[
                    'mensalidade'=>"R$ ".number_format($priceCar->mensalidade,2,',','.'),
                    'min_15'=>"R$ ".number_format($priceCar->min_15,2,',','.'),
                    'min_30'=>"R$ ".number_format($priceCar->min_30,2,',','.'),
                    'min_60'=>"R$ ".number_format($priceCar->min_60,2,',','.'),
                    'diaria'=>"R$ ".number_format($priceCar->diaria,2,',','.'),
                    'pernoite'=>"R$ ".number_format($priceCar->pernoite,2,',','.'),
                ],
                'motocyclePrice'=>[
                    'mensalidade'=>"R$ ".number_format($priceMotocycle->mensalidade,2,',','.'),
                    'min_15'=>"R$ ".number_format($priceMotocycle->min_15,2,',','.'),
                    'min_30'=>"R$ ".number_format($priceMotocycle->min_30,2,',','.'),
                    'min_60'=>"R$ ".number_format($priceMotocycle->min_60,2,',','.'),
                    'diaria'=>"R$ ".number_format($priceMotocycle->diaria,2,',','.'),
                    'pernoite'=>"R$ ".number_format($priceMotocycle->diaria,2,',','.')
                ]
            ];
        }
        //dd($dados);
        return view('estacionamento.tablePrice.table',compact('title','dados'));
    }
   
    public function create()
    {
        $table_price = TablePrice::max('id');
        $baseCalculo = TablePrice::find($table_price);
        if(!empty($baseCalculo)){
            $dados  = array(
                'motocycle_price'=>empty(MotocyclePrice::find($baseCalculo->motocycle_price)) ? null : MotocyclePrice::find($baseCalculo->motocycle_price),
                'car_price'=> empty(CarPrice::find($baseCalculo->car_price))? null : CarPrice::find($baseCalculo->car_price),
            );
        }else{
            $dados = array( 
                'motocycle_price'=>null,
                'car_price'=>null
            );
        }

        $title = 'Novos Preços';
        return view('estacionamento.tablePrice.form',compact('title','dados'));
    }

    public function store(StoreTablePriceRequest $request)
    {
      
        $precosCar= array(
            'min_60'=>str_replace(',','.',str_replace('.','',$request->car_60min)),
            'min_30'=>str_replace(',','.',str_replace('.','',$request->car_30min)),
            'min_15'=>str_replace(',','.',str_replace('.','',$request->car_15min)),
            'diaria'=>str_replace(',','.',str_replace('.','',$request->car_diaria)),
            'pernoite'=>str_replace(',','.',str_replace('.','',$request->car_pernoite)),
            'mensalidade'=>str_replace(',','.',str_replace('.','',$request->car_mensalidade)),
        );
        $car_price = CarPrice::create($precosCar);

        $precosMot =array(
            'min_60'=>str_replace(',','.',str_replace('.','',$request->mot_60min)),
            'min_30'=>str_replace(',','.',str_replace('.','',$request->mot_30min)),
            'min_15'=>str_replace(',','.',str_replace('.','',$request->mot_15min)),
            'diaria'=>str_replace(',','.',str_replace('.','',$request->mot_diaria)),
            'pernoite'=>str_replace(',','.',str_replace('.','',$request->mot_pernoite)),
            'mensalidade'=>str_replace(',','.',str_replace('.','',$request->mot_mensalidade)),
        );
        $mot_price = MotocyclePrice::create($precosMot);
        
        if(!empty($mot_price) && !empty($car_price)){
            $dados = array(
                'motocycle_price'=>$mot_price->id,
                'car_price'=>$car_price->id
            );
            $table = TablePrice::create($dados);
            
            return redirect()->route('parking.create');
        }
    }

    public function fetch (Request $request )
    {  
       
        return TablePriceController::show($request->typevehicle);
    }
    public static function show($typevehicle,$table=''){
        $base = TablePrice::max('id');       
        if(intval($typevehicle)==1 || $typevehicle == 'Carro'){            
            if(empty($table)){
                $dados = CarPrice::where('id',$base)->first();
            }else{
                $base = TablePrice::find($table);                
                $dados = CarPrice::where('id',$base->car_price)->first();                
            }
        }elseif(intval($typevehicle)==2 || $typevehicle == 'Moto'){
            if(empty($table)){
                $dados = MotocyclePrice::where('id',$base)->first();                
            }else{
                $base = TablePrice::find($table);
                $dados = MotocyclePrice::where('id',$base->motocycle_price)->first();                
            }
        }
       
        return $dados;
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
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
