<?php

namespace App\Http\Controllers\Painel\Contagem;

use Codedge\Fpdf\Facades\Fpdf;
use App\Http\Controllers\Controller;
use App\Models\Painel\Contagem\Contagem;
use App\Http\Controllers\Painel\Contagem\CoinsController;
use App\Http\Controllers\Painel\Contagem\BankNotesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ContagemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if(!empty($request->date_start) && !empty($request->date_end)){

            $contagens = Contagem::where('referer','>=',date('Y-m-d',strtotime($request->date_start)))->where('referer','<=',date('Y-m-d',strtotime($request->date_end)))->get();
        }else{

            $contagens = Contagem::where('referer','like',date('Y-m',time()).'-%')->get();
        }
        $header = $this->header();
        $title = 'Meus Controles';                                
        return view('contagem.table',compact('title','header','contagens'));
    }
  

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Fazer Contagem';
        $categor = DB::table('countcategor')->get();
        return view('contagem.form',compact('title','categor'));
    }

    public function store(Request $request)
    {
        //
        $dadosCoins = array (
            'm5'=>$request->moeda_5,
            'm10'=>$request->moeda_10,
            'm25'=>$request->moeda_25,
            'm50'=>$request->moeda_50,
            'm100'=>$request->moeda_100,
        );        
        $dadosBankNotes  = array(
            'n2'=>$request->nota_2,
            'n5'=>$request->nota_5,
            'n10'=>$request->nota_10,
            'n20'=>$request->nota_20,
            'n50'=>$request->nota_50,
            'n100'=>$request->nota_100,
            'check_paper'=>floatval(str_replace(',','.',str_replace('.','',$request->cheque))),
        );
        $coin = CoinsController::store($dadosCoins);
        $banknote = BankNotesController::store($dadosBankNotes);
        if(!empty($coin->id) && !empty($banknote->id)){
            $dados = array(
                'coin'=>$coin->id,
                'banknote'=>$banknote->id,
                'categor'=>$request->categor,
                'referer'=>$request->referer,
                'ip_device'=>$request->ip(),
                
            );
            $store = Contagem::create($dados);
            if($store){
                notify()->success("Controle salvo com sucesso. ;)");
                
                return redirect()->route('contagem.create');
            }else{
                notify()->error("Algo deu errado, não foi possível salvar estes dados. ;)");
                return redirect()->back()->withInput();
                
            }
        }else{
            notify()->error("O processo de pesistencia dos dados foi encerrado, não foi possível salvar os dados de moeda e ou notas.");
            return redirect()->back()->withInput();
        }
        
    }

    public function show(Contagem $contagem)
    {
        
        $title = $contagem->categors->nome.' - '.date('d/m/Y',strtotime($contagem->referer));
        //$total = check;
        return view('contagem.details',compact('title','contagem'));
       
        $pdf = new Fpdf();       
        $pdf::AddPage('L','A4');
        $pdf::SetFont('Arial','B',13); 
        $pdf::Cell(140,10,utf8_decode('Controle de Numerários'),1,1,'C');        
        $pdf::Cell(140,10,utf8_decode('Mitra Diocesana de Teófilo Otoni'),1,1,'C');
        
    }

    public function edit(Contagem $contagem)
    {
        $title = 'Editar Controle';
        $categor = DB::table('countcategor')->get();
        return view('contagem.form',compact('title','categor','contagem'));
    }

    public function update(Request $request, Contagem $contagem)
    {
        $dadosCoins = array (
            'id'=>$contagem->coin,
            'm5'=>$request->moeda_5,
            'm10'=>$request->moeda_10,
            'm25'=>$request->moeda_25,
            'm50'=>$request->moeda_50,
            'm100'=>$request->moeda_100,
        );        
        $dadosBankNotes  = array(
            'id'=>$contagem->banknote,
            'n2'=>$request->nota_2,
            'n5'=>$request->nota_5,
            'n10'=>$request->nota_10,
            'n20'=>$request->nota_20,
            'n50'=>$request->nota_50,
            'n100'=>$request->nota_100,
            'check_paper'=>floatval(str_replace(',','.',str_replace('.','',$request->cheque))),
        );
        $coin = CoinsController::update($dadosCoins);
        $banknote = BankNotesController::update($dadosBankNotes);
        if(!empty($coin) || !empty($banknote)){
            notify()->success("Controle editado com sucesso. ;)");
            return redirect()->route('contagem.index');
        }else{
            notify()->error("Ops! Algo deu errado :/");
            return redirect()->back();

        }
    }

    public function destroy(Contagem $contagem)
    {
        return $contagem->delete();
    }
    public function generatePDF($var){       
        
        $contagem = Contagem::find($var);
        
        if(!empty($contagem)){
            $title1 = utf8_decode("Controle de Numerários (".$contagem->categors->nome.")");
            $title2 = utf8_decode('Mitra Diocesana de Teófilo Otoni - F17');            
            $title3 = utf8_decode('Data: '.date('d/m/Y',strtotime($contagem->referer)));
            $pdf = new Fpdf(); 
            $pdf::setTitle('Controle ('.$contagem->categors->nome.') - '.date('d-m-Y',strtotime($contagem->referer)));
            $pdf::AddPage('L','A4');
            $pdf::SetAutoPageBreak(40);
            $pdf::SetFont('Arial','B',14);
            $pdf::setX(10);
            $pdf::Cell(120,10,$title1,1,1,'C');
            $pdf::Cell(120,10,$title2,1,1,'C');
            $pdf::Cell(120,10,$title3,1,1,'C');
            //Cabelçalho
            $pdf::Cell(30,10,"Valor",1,0,'C');
            $pdf::Cell(10,10,"X",1,0,'C');
            $pdf::Cell(40,10,"Quant.",1,0,'C');
            $pdf::Cell(40,10,utf8_decode("(R$)"),1,1,'C');
            //Linha1 (Moedas de 0,05)
            $pdf::Cell(30,10,"R$ 0,05",1,0,'C');
            $pdf::Cell(10,10,"X",1,0,'C');
            $pdf::Cell(40,10,str_pad($contagem->coins->m5 , 3 , '0' , STR_PAD_LEFT),1,0,'C');
            $pdf::Cell(40,10,"R$ ".number_format($contagem->coins->m5*0.05,2,',','.'),1,1,'C');
            //Linha2 (Moeda de 0,10)
            $pdf::Cell(30,10,"R$ 0,10",1,0,'C');
            $pdf::Cell(10,10,"X",1,0,'C');
            $pdf::Cell(40,10,str_pad($contagem->coins->m10 , 3 , '0' , STR_PAD_LEFT),1,0,'C');
            $pdf::Cell(40,10,"R$ ".number_format($contagem->coins->m10*0.1,2,',','.'),1,1,'C');
            //Linha3 (Moeda de 0,25)
            $pdf::Cell(30,10,"R$ 0,25",1,0,'C');
            $pdf::Cell(10,10,"X",1,0,'C');
            $pdf::Cell(40,10,str_pad($contagem->coins->m25 , 3 , '0' , STR_PAD_LEFT),1,0,'C');
            $pdf::Cell(40,10,"R$ ".number_format($contagem->coins->m25*0.1,2,',','.'),1,1,'C');
            //Linha4 (Moeda de 0,50)
            $pdf::Cell(30,10,"R$ 0,50",1,0,'C');
            $pdf::Cell(10,10,"X",1,0,'C');
            $pdf::Cell(40,10,str_pad($contagem->coins->m50 , 3 , '0' , STR_PAD_LEFT),1,0,'C');
            $pdf::Cell(40,10,"R$ ".number_format($contagem->coins->m50*0.1,2,',','.'),1,1,'C');
            //Linha5 (Moeda de 1,00)
            $pdf::Cell(30,10,"R$ 1,00",1,0,'C');
            $pdf::Cell(10,10,"X",1,0,'C');
            $pdf::Cell(40,10,str_pad($contagem->coins->m100 , 3 , '0' , STR_PAD_LEFT),1,0,'C');
            $pdf::Cell(40,10,"R$ ".number_format($contagem->coins->m100*0.1,2,',','.'),1,1,'C');
            //Linha6 ( Nota de 2,00)
            $pdf::Cell(30,10,"R$ 2,00",1,0,'C');
            $pdf::Cell(10,10,"X",1,0,'C');
            $pdf::Cell(40,10,str_pad($contagem->banknotes->n2 , 3 , '0' , STR_PAD_LEFT),1,0,'C');
            $pdf::Cell(40,10,"R$ ".number_format($contagem->banknotes->n2*2,2,',','.'),1,1,'C');
            //Linha7 ( Nota de 5,00)
            $pdf::Cell(30,10,"R$ 5,00",1,0,'C');
            $pdf::Cell(10,10,"X",1,0,'C');
            $pdf::Cell(40,10,str_pad($contagem->banknotes->n5 , 3 , '0' , STR_PAD_LEFT),1,0,'C');
            $pdf::Cell(40,10,"R$ ".number_format($contagem->banknotes->n5*5,2,',','.'),1,1,'C');
            //Linha8 ( Nota de 10,00)
            $pdf::Cell(30,10,"R$ 10,00",1,0,'C');
            $pdf::Cell(10,10,"X",1,0,'C');
            $pdf::Cell(40,10,str_pad($contagem->banknotes->n10 , 3 , '0' , STR_PAD_LEFT),1,0,'C');
            $pdf::Cell(40,10,"R$ ".number_format($contagem->banknotes->n10*10,2,',','.'),1,1,'C');
            //Linha9 ( Nota de 20,00)
            $pdf::Cell(30,10,"R$ 20,00",1,0,'C');
            $pdf::Cell(10,10,"X",1,0,'C');
            $pdf::Cell(40,10,str_pad($contagem->banknotes->n20 , 3 , '0' , STR_PAD_LEFT),1,0,'C');
            $pdf::Cell(40,10,"R$ ".number_format($contagem->banknotes->n20*20,2,',','.'),1,1,'C');
            //Linha10 ( Nota de 50,00)
            $pdf::Cell(30,10,"R$ 50,00",1,0,'C');
            $pdf::Cell(10,10,"X",1,0,'C');
            $pdf::Cell(40,10,str_pad($contagem->banknotes->n50 , 3 , '0' , STR_PAD_LEFT),1,0,'C');
            $pdf::Cell(40,10,"R$ ".number_format($contagem->banknotes->n50*50,2,',','.'),1,1,'C');
            //Linha10 ( Nota de 100,00)
            $pdf::Cell(30,10,"R$ 100,00",1,0,'C');
            $pdf::Cell(10,10,"X",1,0,'C');
            $pdf::Cell(40,10,str_pad($contagem->banknotes->n100 , 3 , '0' , STR_PAD_LEFT),1,0,'C');
            $pdf::Cell(40,10,"R$ ".number_format($contagem->banknotes->n100*100,2,',','.'),1,1,'C');
            //Linha10 ( Cheque )
            $pdf::Cell(30,10,"Cheque",1,0,'C');
            $pdf::Cell(10,10,"X",1,0,'C');
            $pdf::Cell(40,10,'-',1,0,'C');
            $pdf::Cell(40,10,"R$ ".number_format($contagem->banknotes->check_paper,2,',','.'),1,1,'C');
            //Linha11 ( Total )
            $pdf::Cell(80,10,"Total",1,0,'C');          
            $pdf::Cell(40,10,"R$ ".number_format($contagem->banknotes->total+$contagem->coins->total,2,',','.'),1,1,'C');
            //$pdf::setFont('Arial','',10);
            $pdf::setFont('Arial','',9);
            $pdf::Cell(120,5,"Impresso em ".date('d/m/Y - H:i:s',time()),0,0,'L');            
            $pdf::Ln(2);
            $pdf::Cell(120,10,"",'B',1,'L');
            $pdf::Cell(120,10,"",'B',1,'L');
            $pdf::Output('I','Controle - '.$contagem->categors->nome.'-'.date('d-m-Y',strtotime($contagem->referer)),true);

            exit();
        }
    }
    public function printByinterval(Request $request){
        
        
        if(!empty($request->date_end) && !empty($request->date_start)){
            $date_beginning = $request->date_start;
            $date_end = $request->date_end;
            $dados = Contagem::where('referer','>=',$date_beginning)->where('referer','<=',$date_end)->get();
            $i =0;
            
            foreach($dados as $contagem){            
                if(!empty($contagem)){
                    $title1 = utf8_decode("Controle de Numerários (".$contagem->categors->nome.")");
                    $title2 = utf8_decode('Mitra Diocesana de Teófilo Otoni - F17');            
                    $title3 = utf8_decode('Data: '.date('d/m/Y',strtotime($contagem->referer)));
                    $pdf = new Fpdf();       
                    $pdf::SetFont('Arial','B',14);
                    if($i%2 && $i!= 0){
                        $pdf::setXY(133,10); 
                        $pdf::SetMargins(133,10,0,0 );
                    }else{
                        $pdf::AddPage('L','A4');
                        $pdf::SetMargins(10,10,0,0 );
                        $pdf::setX(10);    
                        $pdf::SetAutoPageBreak(40);
                    }
                    $pdf::Cell(120,10,$title1,1,1,'C');
                    $pdf::Cell(120,10,$title2,1,1,'C');
                    $pdf::Cell(120,10,$title3,1,1,'C');
                    //Cabelçalho
                    $pdf::Cell(30,10,"Valor",1,0,'C');
                    $pdf::Cell(10,10,"X",1,0,'C');
                    $pdf::Cell(40,10,"Quant.",1,0,'C');
                    $pdf::Cell(40,10,utf8_decode("(R$)"),1,1,'C');
                    //Linha1 (Moedas de 0,05)
                    $pdf::Cell(30,10,"R$ 0,05",1,0,'C');
                    $pdf::Cell(10,10,"X",1,0,'C');
                    $pdf::Cell(40,10,str_pad($contagem->coins->m5 , 3 , '0' , STR_PAD_LEFT),1,0,'C');
                    $pdf::Cell(40,10,"R$ ".number_format($contagem->coins->m5*0.05,2,',','.'),1,1,'C');
                    //Linha2 (Moeda de 0,10)
                    $pdf::Cell(30,10,"R$ 0,10",1,0,'C');
                    $pdf::Cell(10,10,"X",1,0,'C');
                    $pdf::Cell(40,10,str_pad($contagem->coins->m10 , 3 , '0' , STR_PAD_LEFT),1,0,'C');
                    $pdf::Cell(40,10,"R$ ".number_format($contagem->coins->m10*0.1,2,',','.'),1,1,'C');
                    //Linha3 (Moeda de 0,25)
                    $pdf::Cell(30,10,"R$ 0,25",1,0,'C');
                    $pdf::Cell(10,10,"X",1,0,'C');
                    $pdf::Cell(40,10,str_pad($contagem->coins->m25 , 3 , '0' , STR_PAD_LEFT),1,0,'C');
                    $pdf::Cell(40,10,"R$ ".number_format($contagem->coins->m25*0.1,2,',','.'),1,1,'C');
                    //Linha4 (Moeda de 0,50)
                    $pdf::Cell(30,10,"R$ 0,50",1,0,'C');
                    $pdf::Cell(10,10,"X",1,0,'C');
                    $pdf::Cell(40,10,str_pad($contagem->coins->m50 , 3 , '0' , STR_PAD_LEFT),1,0,'C');
                    $pdf::Cell(40,10,"R$ ".number_format($contagem->coins->m50*0.1,2,',','.'),1,1,'C');
                    //Linha5 (Moeda de 1,00)
                    $pdf::Cell(30,10,"R$ 1,00",1,0,'C');
                    $pdf::Cell(10,10,"X",1,0,'C');
                    $pdf::Cell(40,10,str_pad($contagem->coins->m100 , 3 , '0' , STR_PAD_LEFT),1,0,'C');
                    $pdf::Cell(40,10,"R$ ".number_format($contagem->coins->m100*0.1,2,',','.'),1,1,'C');
                    //Linha6 ( Nota de 2,00)
                    $pdf::Cell(30,10,"R$ 2,00",1,0,'C');
                    $pdf::Cell(10,10,"X",1,0,'C');
                    $pdf::Cell(40,10,str_pad($contagem->banknotes->n2 , 3 , '0' , STR_PAD_LEFT),1,0,'C');
                    $pdf::Cell(40,10,"R$ ".number_format($contagem->banknotes->n2*2,2,',','.'),1,1,'C');
                    //Linha7 ( Nota de 5,00)
                    $pdf::Cell(30,10,"R$ 5,00",1,0,'C');
                    $pdf::Cell(10,10,"X",1,0,'C');
                    $pdf::Cell(40,10,str_pad($contagem->banknotes->n5 , 3 , '0' , STR_PAD_LEFT),1,0,'C');
                    $pdf::Cell(40,10,"R$ ".number_format($contagem->banknotes->n5*5,2,',','.'),1,1,'C');
                    //Linha8 ( Nota de 10,00)
                    $pdf::Cell(30,10,"R$ 10,00",1,0,'C');
                    $pdf::Cell(10,10,"X",1,0,'C');
                    $pdf::Cell(40,10,str_pad($contagem->banknotes->n10 , 3 , '0' , STR_PAD_LEFT),1,0,'C');
                    $pdf::Cell(40,10,"R$ ".number_format($contagem->banknotes->n10*10,2,',','.'),1,1,'C');
                    //Linha9 ( Nota de 20,00)
                    $pdf::Cell(30,10,"R$ 20,00",1,0,'C');
                    $pdf::Cell(10,10,"X",1,0,'C');
                    $pdf::Cell(40,10,str_pad($contagem->banknotes->n20 , 3 , '0' , STR_PAD_LEFT),1,0,'C');
                    $pdf::Cell(40,10,"R$ ".number_format($contagem->banknotes->n20*20,2,',','.'),1,1,'C');
                    //Linha10 ( Nota de 50,00)
                    $pdf::Cell(30,10,"R$ 50,00",1,0,'C');
                    $pdf::Cell(10,10,"X",1,0,'C');
                    $pdf::Cell(40,10,str_pad($contagem->banknotes->n50 , 3 , '0' , STR_PAD_LEFT),1,0,'C');
                    $pdf::Cell(40,10,"R$ ".number_format($contagem->banknotes->n50*50,2,',','.'),1,1,'C');
                    //Linha10 ( Nota de 100,00)
                    $pdf::Cell(30,10,"R$ 100,00",1,0,'C');
                    $pdf::Cell(10,10,"X",1,0,'C');
                    $pdf::Cell(40,10,str_pad($contagem->banknotes->n100 , 3 , '0' , STR_PAD_LEFT),1,0,'C');
                    $pdf::Cell(40,10,"R$ ".number_format($contagem->banknotes->n100*100,2,',','.'),1,1,'C');
                    //Linha10 ( Cheque )
                    $pdf::Cell(30,10,"Cheque",1,0,'C');
                    $pdf::Cell(10,10,"X",1,0,'C');
                    $pdf::Cell(40,10,'-',1,0,'C');
                    $pdf::Cell(40,10,"R$ ".number_format($contagem->banknotes->check_paper,2,',','.'),1,1,'C');
                    //Linha11 ( Total )
                    $pdf::Cell(80,10,"Total",1,0,'C');          
                    $pdf::Cell(40,10,"R$ ".number_format($contagem->banknotes->total+$contagem->coins->total,2,',','.'),1,1,'C');
                    $pdf::setFont('Arial','',9);
                    $pdf::Cell(120,5,"Impresso em ".date('d/m/Y - H:i:s',time()),0,1,'L');
                    $pdf::Ln(2);
                    $pdf::Cell(120,10,"",'B',1,'L');
                    $pdf::Cell(120,10,"",'B',1,'L');
                }
                $i++;
            }
            $pdf::Output('I','Controles - de '.date('d-m-Y',strtotime($request->date_start)).' a '.date('d-m-Y',strtotime($request->date_end)),true);

            exit();
            
        }else{
            return "Não deu certo :(";
        }
        


    }
    private function header(){
        $totalIntentionsTODAY = DB::table('intention_scopes')->where('date_schedule','=',date('Y-m-d',time()))->count();        
        $totalIntentionsTOMORROW = DB::table('intention_scopes')->where('date_schedule','=',date('Y-m-d',strtotime("1 days",time())))->count();        
        $deathIntentions = DB::table('intention_scopes')
        ->join('intention_classes','intention_classes.id','=','intention_scopes.classification')
        ->where('date_schedule','>=',date('Y-m-d',time()))
        ->where('intention_classes.typeintention',1)
        ->count();
        $thanks_givenIntentions = DB::table('intention_scopes')
        ->join('intention_classes','intention_classes.id','=','intention_scopes.classification')
        ->where('date_schedule','>=',date('Y-m-d',time()))
        ->whereNotNull('observations')
        ->count();
        
        $card =array(
            [
                'headerText'=>'Intenções p/ <b>HOJE</b>',
                'headerNumber'=> $totalIntentionsTODAY,
                'bodyIcon'=>'<i class="fas fa-calendar-check"></i>',
                'color'=>'bg-green',
                'url'=>route('certidao-batismo.filter',1),
                
                
            ],
            [
                'headerText'=> 'Intenções p/ Amanhã',
                'headerNumber'=>$totalIntentionsTOMORROW,
                'bodyIcon'=>'<i class="fas fa-history"></i>',
                'color'=>'bg-warning',
                'url'=>'',
                
                
            ],
            [
                'headerText'=>'Intenções Falecidos',
                'headerNumber'=>$deathIntentions,
                'bodyIcon'=>'<i class="fas fa-dizzy"></i>',
                'color'=>'bg-yellow',
                'url'=>'',
                
                
            ],
            [
                'headerText'=>'Avisos Sacristia',
                'headerNumber'=>$thanks_givenIntentions,
                'bodyIcon'=>'<i class="fas fa-bell"></i>',
                'color'=>'bg-info',
                'url'=>'',
                'identify'=>'avisos'
            ]           
            
        );
        
        return $card;
    }
}
