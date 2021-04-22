<?php

namespace App\Http\Controllers\Painel\Estacionamento\Vehicles;

use App\Http\Controllers\Controller;
use App\Models\Painel\Estacionamento\Vehicle\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class VehiclesController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public static function store($dados)
    {
        $existe = Vehicle::where('placa',$dados['placa'])->first();
        if(!empty($existe)){
            if($existe->pessoa =='' && !empty($dados['pessoa'])){
                $existe->update(['pessoa'=>$dados['pessoa']]);
            }
            return $existe;
        }else{
            return Vehicle::create($dados);
        }
    }

    public static function show( $placa)
    {
        $vehicle = DB::table('vehicle')->where('placa',$placa)->first();
        return $vehicle;
    }

    public function edit(Vehicle $vehicle)
    {
        //
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        //
    }

    public function destroy(Vehicle $vehicle)
    {
        //
    }
}
