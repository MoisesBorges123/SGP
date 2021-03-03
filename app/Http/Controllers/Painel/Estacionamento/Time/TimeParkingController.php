<?php

namespace App\Http\Controllers\Painel\Estacionamento\Time;

use App\Http\Controllers\Controller;
use App\Models\Painel\Estacionamento\Time\TimeParking;
use Illuminate\Http\Request;

class TimeParkingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public static function store($dados=[])
    {
        //
        $dados['hour_in'] = date('H',time());
        $dados['min_in'] = date('i',time());
        $dados['date_in']=date('Y-m-d',time());
        return TimeParking::create($dados);
    }

    public function show(TimeParking $timeParking)
    {
        //
    }

    public static function updateOut($timeParking)
    {
        $time = TimeParking::where('id',$timeParking['time_id'])->first();  
        
        $update = $time->update($timeParking);     
        return $update;
    }

    public function update(Request $request)
    {
       
        $time = TimeParking::where('id',$request->id)->first();
        $dados = explode(':',$request->time);
        
        $hour_in = sprintf("%02d",$dados[0]);
        $min_in = sprintf("%02d",$dados[1]);
        
        $update = $time->update(['hour_in'=>$dados[0],'min_in'=>$dados[1]]);
     
        return $update;
    }

    public static function destroy($timeParking)
    {
        $time = TimeParking::where('id',$timeParking)->first();        
        $delete = $time->delete();
        return $delete;

    }
}
