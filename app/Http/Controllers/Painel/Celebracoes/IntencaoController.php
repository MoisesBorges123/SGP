<?php

namespace App\Http\Controllers\Painel\Celebracoes;

use Codedge\Fpdf\Facades\Fpdf;
use App\Http\Controllers\Controller;
use App\Models\Painel\Celevracoes\Intencao;
use App\Http\Controllers\PessoasController;
use App\Http\Controllers\Painel\Celebracoes\ScopeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class IntencaoController extends Controller
{
    private $intencao;
    public function __construct(Intencao $intentions){
        $this->intencao = $intentions;
    }
    public function index(Request $request)
    {
        
        $header = $this->header(); 
        if(!empty($request->begin)){
            $scopes = DB::table('intention_scopes')
            ->where('date_schedule','>=',$request->begin)
            ->where('date_schedule','<=',$request->end)
            ->get();
        }else{
            $scopes = DB::table('intention_scopes')->where('date_schedule','>=',date('Y-m-d',time()))->get();
        }
        
        $dados=$this->mountedIntention($scopes);         
        return view('celebrations.intentions.table',compact('header','dados'));
    }    
    public function create()
    {
        $header = $this->header();       
        $todayScopes = DB::table('intention_scopes')->where('date_schedule',date('Y-m-d',time()))->get();        
        $intentionsToday=$this->mountedIntention($todayScopes);       
      
        return view('celebrations.intentions.form',compact('header','intentionsToday'));
    }
    public function store(Request $request){
        
        if(!empty($request->input('falecido'))){
            $fn_people = new PessoasController;
            $deadPerson = array(
                'nome'=>$request->input('falecido')
            );
            $personRequired = array(
                'nome'=>$request->input('agendado_por')
            );
            $claimant = $fn_people->store($personRequired);
            $deceased = $fn_people->store($deadPerson);    
            $complement = $request->input('tempo_falecimento');
            $classification = $request->input('tipo_intencao');
            $fn_scope = new ScopeController;            
            $escopo = array(                                
                'date_schedule'=>$request->input('data_agendamento'),
                'time_schedule'=>$request->input('hora_agendamento'),
                'observations'=>$request->input('observacao'),
                'classification'=>$request->input('tipo_intencao'),
                'claimant'=>$claimant->id,
                'complement'=>$complement
                
            );            
            $scope = $fn_scope->store($escopo);            
            $intencao = array(
                'person'=>$deceased->id,
                'scope'=>$scope->id,              

            );
            $newIntention =$this->intencao->create($intencao);

            //dd($newIntention);
        }        
        else if($request->input('typeThanksGivenIntention')){
            $classification = $request->input('typeThanksGivenIntention');
                $fn_people = new PessoasController;
                $personRequired = array(
                    'nome'=>$request->input('agendado_por'),
                    'telefone'=>$request->input('telefone')
                );
                if($classification==7){
                    $person = $fn_people->store(['nome'=>'Alunos']);
                    $complement = $request->input('curso');
                }
                else if( $classification == 6){
                    $noivo = array(
                        'nome'=>$request->input('esposo')
                    );
                    $noiva = array(
                        'nome'=>$request->input('esposa')
                    );
                    $complement = $request->input('married_timef');
                    $engaged = $fn_people->store($noivo);
                    $fiancee = $fn_people->store($noiva);
                }
                else if( $classification == 8 || $classification ==5){
                    $pessoa = array(
                        'nome'=>$request->input('pessoa')
                    );
                    $person = $fn_people->store($pessoa);
                    $complement = $request->input('age') ?? '';
                }
                $claimant = $fn_people->store($personRequired);
                $escopo = array(                   
                    
                    'date_schedule'=>$request->input('data_agendamento'),
                    'time_schedule'=>$request->input('hora_agendamento'),
                    'observations'=>$request->input('observacao'),
                    'claimant'=>$claimant->id,
                    'classification'=>$classification,
                    'complement'=>$complement
                );
                $fn_scope = new ScopeController;                
                $scope = $fn_scope->store($escopo);       
                if($classification == 6){
                    
                    $intencao1 = array(
                        'person'=>$fiancee->id,
                        'scope'=>$scope->id,
                    );
                    $intencao2 = array(
                        'person'=>$engaged->id,
                        'scope'=>$scope->id,
                    );
                    $newIntention =$this->intencao->create($intencao1);
                    $newIntention =$this->intencao->create($intencao2);
                }
                else{
                    $intencao = array(
                        'person'=>$person->id,
                        'scope'=>$scope->id,
                    );
                    $newIntention =$this->intencao->create($intencao);
                }
    
                
            
        }
        else{
            $personRequired = array(
                'nome'=>$request->input('agendado_por')
            );
            $pessoa = array(
                'nome'=>$request->input('pessoa')
            );
            $fn_people = new PessoasController;
            $claimant = $fn_people->store($personRequired);
            $person = $fn_people->store($pessoa);
            $escopo = array(                   
                    
                'date_schedule'=>$request->input('data_agendamento'),
                'time_schedule'=>$request->input('hora_agendamento'),
                'observations'=>$request->input('observacao'),
                'claimant'=>$claimant->id,
                'classification'=>4,
                'complement'=>''
            );
            $fn_scope = new ScopeController;                
            $scope = $fn_scope->store($escopo);  
            $intencao = array(
                'person'=>$person->id,
                'scope'=>$scope->id,              

            );
            $newIntention =$this->intencao->create($intencao);  
        }
        if(!empty($newIntention)){
            
            notify()->success("Intenção registrada para dia ".date('d/m/Y',strtotime($request->input('data_agendamento')))." às ".$request->input('hora_agendamento'));
        }
        return redirect()->route('intentions.create');
    }   
    public function show(Intencao $intencao)
    {
        //
    }
    public function edit(Intencao $intencao)
    {
        //
    }
    public function update(Request $request, Intencao $intencao)
    {
        //
    }
    public function destroy(Intencao $intencao)
    {
        //
    }
    public function printer(Request $request)
    {
        
        if(!empty($request->date_schedule) && !empty($request->time_schedule) ){
            setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
            $all_scopes = DB::table('intention_scopes')
                ->where('date_schedule',$request->date_schedule)
                ->where('time_schedule',$request->time_schedule)                
                ->get();
            $scopes_ids=[];
            foreach ($all_scopes as $scope) {
                $scopes_ids[] = ['id'=>$scope->classification];
            }
           // dd($scopes_ids);
            $class_intentions=DB::table('intention_classes')
            ->where('empty_lines','>',0)
            ->orWhereIn('id',$scopes_ids)
            ->orderBy('print_position','asc')
            ->get();
            //dd($class_intentions);
            $pdf = new Fpdf();       
            $pdf::AddPage('P','A4');
            $pdf::Image("admin/intentions/images/folha_de_intencao.jpg",0,0,195);    
            $pdf::SetY(55);
            foreach($class_intentions as $class){
                $pdf::SetFont('Arial','B',14);  
                $pdf::Text(120,50,ucfirst(strftime('%A, %d de %B de %Y',strtotime($request->date_schedule))));               
                $pdf::Text(120,58,utf8_decode("Horário: ".$request->time_schedule));               
                $pdf::Cell(190,10,utf8_decode($class->classe),0, 1,'L',FALSE);
                
                $scopes = DB::table('intention_scopes')
                ->where('date_schedule',$request->date_schedule)
                ->where('time_schedule',$request->time_schedule)
                ->where('classification',$class->id)
                ->get();
                $intentions = $this->mountedIntention($scopes);                
                if(count($intentions) > 0 ){
                    $pdf::SetFont('Arial','',12);
                    foreach($intentions as $intention){
                        $pdf::Cell(190,7,utf8_decode($intention['intention']),0,1,'L',FALSE);
                    }
                     
                }
                for($i=0;$i<$class->empty_lines;$i++){
                    if($pdf::GetY()>210){
                        $pdf::Cell(130,7,'','B', 1,'L',FALSE);
                    }else{
                        $pdf::Cell(190,7,'','B', 1,'L',FALSE);
                    }
                }               
                $pdf::SetY(( $pdf::GetY()+5));
            }
            
            $pdf::Output('I','Intenção - dia-hora missa',true);      
            
                   
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
        ->where('intention_classes.typeintention',2)
        ->count();
        
        $card =array(
            [
                'headerText'=>'Intenções <b>HOJE</b>',
                'headerNumber'=> $totalIntentionsTODAY,
                'bodyIcon'=>'<i class="fas fa-chart-bar"></i>',
                'color'=>'bg-danger',
                'url'=>route('certidao-batismo.filter',1)
                
            ],
            [
                'headerText'=> 'Intenções Amanhã',
                'headerNumber'=>$totalIntentionsTOMORROW,
                'bodyIcon'=>'<i class="fas fa-chart-pie"></i>',
                'color'=>'bg-warning',
                'url'=>''
            ],
            [
                'headerText'=>'Intenções Falecidos',
                'headerNumber'=>$deathIntentions,
                'bodyIcon'=>'<i class="fas fa-users"></i>',
                'color'=>'bg-yellow',
                'url'=>''
            ],
            [
                'headerText'=>'Intenções Ação de Graças',
                'headerNumber'=>$thanks_givenIntentions,
                'bodyIcon'=>'<i class="fas fa-percent"></i>',
                'color'=>'bg-info',
                'url'=>route('certidao-batismo.filter',2)
            ]           
            
        );
        
        return $card;
    }
    private function mountedIntention($scopes){
        $intentionsToday=[];
        foreach ($scopes as $value) {
         
            if($value->classification == 6 ){
                $complement = !empty($value->complement) ?  $value->complement." anos " : '';
                $intention = $complement."Casamento de ";
                $adition = " e ";   
                 $dbIntentions = DB::table('intentions')->where('scope',$value->id)->get();
                 //dd($dbIntentions);
                 foreach ($dbIntentions as $dbIntention) {
                     $person = DB::table('pessoas')->where('id',$dbIntention->person)->first();
                     $intention.=$person->nome.$adition;
                     $adition="";
                 }
                 
            }
            else{
                 $dbIntentions = DB::table('intentions')->where('scope',$value->id)->first();                 
                 $person = DB::table('pessoas')->where('id',$dbIntentions->person)->first();
                 if($value->classification == 7){ 
                     $complement = !empty($value->complement) ? " do ".$value->complement : '';                            
                 } 
                 else if($value->classification == 5){
                     $complement = !empty($value->complement) ? " - ".$value->complement." anos" : '';
                 }
                 else if($value->classification ==3){
                     $complement = !empty($value->complement) ? " - ".$value->complement." anos de falecimento" : '';
                 }
                 else{
                     $complement = !empty($value->complement) ? " - ".$value->complement : '';
                 }
                 $intention=$person->nome.$complement;                                       
             }
             $typeIntention = DB::table('intention_classes')->where('id',$value->classification)->first();
             $claimant = DB::table('pessoas')->where('id',$value->claimant)->first();
             $phone = DB::table('telefone')->where('pessoa',$claimant->id)->first();
             
             $intentionsToday[] = ['data'=>date('d/m/Y',strtotime($value->date_schedule)),'hora'=>$value->time_schedule,'id'=>$value->id,'typeIntention'=>$typeIntention->classe,'intention'=>$intention,'claimant'=>$claimant->nome,'phone'=>$phone];
        } 
        return $intentionsToday; 
    }
}
