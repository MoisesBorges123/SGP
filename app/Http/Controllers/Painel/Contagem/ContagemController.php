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
    public function index()
    {
        //
        $header = $this->header();
        $title = 'Meus Controles';
        $dadosdb = DB::table('contagem')
        ->join('coins','coins.id','=','contagem.coin')
        ->join('countcategor','countcategor.id','=','contagem.categor')
        ->join('banknotes','banknotes.id','=','contagem.banknote')
        ->where('contagem.referer','like',date('Y-m',time()).'-%')
        ->select('countcategor.id as id_categor','contagem.id as id', 'countcategor.nome as nome','contagem.referer as referer',
        'coins.5 as moeda_5','coins.10 as moeda_10','coins.25 as moeda_25','coins.50 as moeda_50','coins.100 as moeda_100',
        'banknotes.2 as nota_2','banknotes.5 as nota_5', 'banknotes.check as check','banknotes.10 as nota_10','banknotes.20 as nota_20','banknotes.50 as nota_50','banknotes.100 as nota_100')
        ->get();   
        //dd($dadosdb);     
        $dados =[];
        foreach($dadosdb as $register){
            $total = ($register->moeda_5*0.05)+
                    ($register->moeda_10*0.10)+
                    ($register->moeda_25*0.25)+
                    ($register->moeda_50*0.50)+
                    ($register->moeda_100*1.00)+
                    ($register->nota_2*2.00)+
                    ($register->nota_5*5.00)+
                    ($register->nota_10*10.00)+
                    ($register->nota_20*20.00)+
                    ($register->nota_50*50.00)+
                    ($register->nota_100*100.00)+
                    ($register->check);
            $dados[]=['id'=>$register->id,'categoria'=>$register->nome,'data'=>date('d/m/Y',strtotime($register->referer)),'valor'=>'R$ '.number_format($total,2,',','.')];
        }
        //dd($dados);     
        return view('contagem.table',compact('title','header','dados'));
    }
    public function index2()
    {
        //
        $header = $this->header();
        $title = 'Meus Controles';
        $dadosdb = DB::table('contagem')
        ->join('coins','coins.id','=','contagem.coin')
        ->join('countcategor','countcategor.id','=','contagem.categor')
        ->join('banknotes','banknotes.id','=','contagem.banknote')
        ->where('contagem.referer','like',date('Y-m',time()).'-%')
        ->select('countcategor.id as id_categor',
        'coins.5 as moeda_5','coins.10 as moeda_10','coins.25 as moeda_25','coins.50 as moeda_50','coins.100 as moeda_100',
        'banknotes.2 as nota_2','banknotes.5 as nota_5', 'banknotes.10 as nta_10','banknotes.20 as nota_20','banknotes.50 as nota_50','banknotes.100 as nota_100, *')
        ->get();
        dd($dadosdb);
        $dados =[];
        foreach($dadosdb as $register){
            $total = ($register->moeda_5*0.05)+
                    ($register->moeda_10*0.10)+
                    ($register->moeda_25*0.25)+
                    ($register->moeda_50*0.50)+
                    ($register->moeda_100*1.00)+
                    ($register->nota_2*2.00)+
                    ($register->nota_5*5.00)+
                    ($register->nota_10*10.00)+
                    ($register->nota_20*20.00)+
                    ($register->nota_50*50.00)+
                    ($register->nota_100*100.00)+
                    ($register->check);
            $dados=['id'=>$register->id,'categoria'=>$register->nome,'data'=>date('d/m/Y',strtotime($register->referer)),'valor'=>$total];
        }
        return view('contagem.table',compact('title','header','dados'));
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
            '5'=>$request->moeda_5,
            '10'=>$request->moeda_10,
            '25'=>$request->moeda_25,
            '50'=>$request->moeda_50,
            '100'=>$request->moeda_100,
        );        
        $dadosBankNotes  = array(
            '2'=>$request->nota_2,
            '5'=>$request->nota_5,
            '10'=>$request->nota_10,
            '20'=>$request->nota_20,
            '50'=>$request->nota_50,
            '100'=>$request->nota_100,
            'check'=>floatval(str_replace(',','.',str_replace('.','',$request->cheque))),
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

    public function show($contagem)
    {
        $total_controlers = count($contagem['id']);
        for($i=0;$total_controlers<$i,$i++){
            DB::table('contagem')
        ->join('coins','coins.id','=','contagem.coin')
        ->join('countcategor','countcategor.id','=','contagem.categor')
        ->join('banknotes','banknotes.id','=','contagem.banknote')
        ->where('contagem.referer','like',date('Y-m',time()).'-%')
        ->where('contagem.id',$contagem['id'][$i])
        ->select('countcategor.id as id_categor','contagem.id as id', 'countcategor.nome as nome','contagem.referer as referer',
        'coins.5 as moeda_5','coins.10 as moeda_10','coins.25 as moeda_25','coins.50 as moeda_50','coins.100 as moeda_100',
        'banknotes.2 as nota_2','banknotes.5 as nota_5', 'banknotes.check as check','banknotes.10 as nota_10','banknotes.20 as nota_20','banknotes.50 as nota_50','banknotes.100 as nota_100')
        ->get();
            
        $pdf = new Fpdf();       
        $pdf::AddPage('L','A4');
        $pdf::SetFont('Arial','B',13); 
        $pdf::Cell(140,10,utf8_decode('Controle de Numerários'),1,1,'C');
        $pdf::Cell(140,10,utf8_decode('Mitra Diocesana de Teófilo Otoni'),1,1,'C');
        $pdf::Cell(140,10,utf8_decode('Mitra Diocesana de Teófilo Otoni'),1,1,'C');
        }
        
        $pdf::Output('I','Intenção - dia-hora missa',true);  
        exit;
    }

    public function edit(Contagem $contagem)
    {
        //
    }

    public function update(Request $request, Contagem $contagem)
    {
        //
    }

    public function destroy(Contagem $contagem)
    {
        //
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
