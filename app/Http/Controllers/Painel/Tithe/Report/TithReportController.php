<?php

namespace App\Http\Controllers\Painel\Tithe\Report;

use Codedge\Fpdf\Facades\Fpdf;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Painel\People\People;

class TithReportController extends Controller
{
    public function actives(){
        $totalRegisterTither = DB::table('tithers')->get()->count();      
        $tithers = DB::table('tithers')->orderBy('data_nascimento')->get();
        $offTither = 0;
        $pdf = new Fpdf();       
        $pdf::AddPage('P','A4');
        $pdf::SetFont('Arial','',12);  
        $pdf::Cell(15,10,utf8_decode("Código"),1,0,'L');
        $pdf::Cell(100,10,"Nome",1,0,'L');   
        $pdf::Cell(50,10,"Data Nasc.",1,0,'L');   
        $pdf::Cell(50,10,"Telefone",1,1,'L'); 

        foreach($tithers as $tither){            
            $devolution = DB::table('tither_devolutions')    
            ->where('created_at','>',date('Y-m-d H:i:s',strtotime('-121 days',time())))          
            ->where('tither',$tither->id)                         
            ->first();            
            if(empty($devolution)){
                $offTither++;
               
                  
            }else{
                $person = People::find($tither->person);
                $telefone=DB::table('telefone')->where('pessoa',$person->id)->first();
                $pdf::Cell(15,10,$tither->id,1,0,'L');
                $pdf::Cell(100,10,utf8_decode($person->nome),1,0,'L');
                $pdf::Cell(50,10,$person->data_nascimento,1,0,'L');    
                $pdf::Cell(50,10,!empty($telefone->telefone) ? $telefone->telefone : '',1,1,'L');
            }
           
        }
        $pdf::Output('I','Dizimistas',true);
        exit();
        //$onTither  = $totalRegisterTither - $offTither;
        //dd($onTither);
    }
}
