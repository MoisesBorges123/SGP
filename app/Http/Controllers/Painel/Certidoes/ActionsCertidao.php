<?php

namespace App\Http\Controllers\Painel\Certidoes;

use App\Models\Painel\Certidao\CertidaoBatismo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Codedge\Fpdf\Facades\Fpdf;
use App\Http\Controllers\PessoasController;

class ActionsCertidao extends Controller
{
    //
    private $certidao;
    
    
    public function __construct(CertidaoBatismo $certificate){
        $this->certidao = $certificate;
        date_default_timezone_set('America/Sao_Paulo');
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    }
    public function emitir($certidao,$id,$fim_certidao,$obs){
        if($certidao = 'batizado'){
            $registro = DB::table('certidao_batismo')->where('id',$id)->first();
            $finalidade = DB::table('finalidades_certidao')->where('id',$fim_certidao)->first();
            $crianca = PessoasController::show($registro->crianca);
            $pai = PessoasController::show($registro->pai);
            $mae = PessoasController::show($registro->mae);
            $padrinho = PessoasController::show($registro->padrinho);
            $madrinha = PessoasController::show($registro->madrinha);           
            $celebrante = PessoasController::show($registro->celebrante);           
            
            $dados = array(
                'crianca'=>$crianca->nome,
                'pai'=>empty($pai->nome) ? '(Não possui)' : $pai->nome,
                'mae'=>empty($mae->nome) ? '(Não possui)' : $mae->nome,
                'madrinha'=>empty($madrinha->nome) ? '(Não possui)' : $madrinha->nome,
                'padrinho'=>empty($padrinho->nome) ? '(Não possui)' : $padrinho->nome,
                'dia_nascimento'=>strftime('%d',strtotime($crianca->data_nascimento)),
                'mes_nascimento'=>strftime('%B',strtotime($crianca->data_nascimento)),
                'ano_nascimento'=>strftime('%Y',strtotime($crianca->data_nascimento)),
                'dia_batizado'=>strftime('%d',strtotime($registro->data_batizado)),
                'mes_batizado'=>strftime('%B',strtotime($registro->data_batizado)),
                'ano_batizado'=>strftime('%Y',strtotime($registro->data_batizado)),                
                'dia_atual'=>date('d',time()),
                'mes_atual'=>strftime('%B',strtotime(date('Y-m-d',time()))),
                'ano_atual'=>date('Y',time()), 
                'local'=>$registro->local_batizado,
                'padre'=>$celebrante->nome,
                'livro'=>$registro->livro,
                'folha'=>$registro->folha,
                'numero'=>'-',
                'finalidade'=>$finalidade->finalidade,
                'obs'=>empty($obs) ? '' : $obs,

            );
            $notify = array(
                'finalidade'=>$finalidade->id,
                'certidao'=>$registro->id,
                'created_at'=>date('Y-m-d H:i:s',time())
            );
            $this->notifCertBatismo($notify);
            $this->emitirCertBatismo2($dados);
        }
    }
    private function emitirCertBatismo($dados){        
        //echo url('images/certidao/certdao_casamento2.png');exit;
        
        $pdf = new Fpdf();       
        $pdf::AddPage('P','A4');
        $pdf::SetFont("Arial","B",12);
        $pdf::Image("images/certidao/certdao_batismo2.png",0,0,210);
        $pdf::SetXY(65,92.3);
        $pdf::Cell(28.7,20,$dados['livro'],0,1,'L');
        $pdf::SetXY(81.5,92.3);
        $pdf::Cell(28.4,20,$dados['folha'],0,1,'L');
        $pdf::SetXY(100.4,92.2);
        $pdf::Cell(30,20,$dados['numero'],0,1,'L');
        $pdf::SetFont("Arial","B",13);
        $pdf::SetXY(31.4,110);
        $pdf::Cell(147,10,utf8_decode($dados['crianca']),0,1,'C');
        $pdf::SetFont("Arial","",11);
        $pdf::SetXY(53.6,117.5);
        $pdf::Cell(7,10,utf8_decode($dados['dia_batizado']),0,1,'L');
        $pdf::SetXY(63.7,117.5);
        $pdf::Cell(15,10,utf8_decode($dados['mes_batizado']),0,1,'C');
        $pdf::SetXY(82.5,117.5);
        $pdf::Cell(15,10,utf8_decode($dados['ano_batizado']),0,1,'L');
        $pdf::SetXY(101,117.5);
        $pdf::Cell(15,10,utf8_decode($dados['local']),0,1,'L');
        $pdf::SetXY(53.6,124.15);        
        $pdf::Cell(7,10,utf8_decode($dados['dia_nascimento']),0,1,'L');
        $pdf::SetXY(63.7,124.15);
        $pdf::Cell(15,10,utf8_decode($dados['mes_nascimento']),0,1,'C');
        $pdf::SetXY(83.5,124.15);
        $pdf::Cell(15,10,utf8_decode($dados['ano_nascimento']),0,1,'L');
        $pdf::SetXY(113.5,124.15);
        $pdf::Cell(15,10,utf8_decode($dados['pai']),0,1,'L');
        $pdf::SetXY(33.7,130.4);
        $pdf::Cell(15,10,utf8_decode($dados['mae']),0,1,'L');
        $pdf::SetXY(56.7,137.1);
        $pdf::Cell(15,10,utf8_decode($dados['padrinho']),0,1,'L');
        $pdf::SetXY(33.7,143.4);
        $pdf::Cell(15,10,utf8_decode($dados['madrinha']),0,1,'L');
        $pdf::SetXY(47,149.83);
        $pdf::Cell(15,10,utf8_decode($dados['padre']),0,1,'L');
        $pdf::SetXY(119,193.4);
        $pdf::Cell(15,10,utf8_decode($dados['dia_atual']),0,1,'L');
        $pdf::SetXY(132,193.4);
        $pdf::Cell(15,10,utf8_decode($dados['mes_atual']),0,1,'C');
        $pdf::SetXY(156,193.4);
        $pdf::Cell(15,10,utf8_decode($dados['ano_atual']),0,1,'L');
        if($dados['obs']){
            $pdf::SetXY(40,155.8);
            $pdf::Cell(15,10,utf8_decode($dados['obs']),0,1,'L');
        }
        $pdf::Output();
        exit;
        
        
    }
    private function emitirCertBatismo2($dados){        
        //echo url('images/certidao/certdao_casamento2.png');exit;
        
        $pdf = new Fpdf();       
        $pdf::AddPage('P','A4');
        $pdf::SetFont("Arial","B",12);
        $pdf::SetTitle('Certidão Batismo - '.$dados['crianca'],true);
        $pdf::Image("images/certidao/certdao_batismo4.png",0,0,210);
        $pdf::SetXY(65,92.3);
        $pdf::Cell(28.7,20,$dados['livro'],0,1,'L');
        $pdf::SetXY(82.5,92.3);
        $pdf::Cell(29.4,20,$dados['folha'],0,1,'L');
        $pdf::SetXY(100.4,92.2);
        $pdf::Cell(30,20,$dados['numero'],0,1,'L');
        $pdf::SetFont("Arial","B",13);
        $pdf::SetXY(31.4,110);
        $pdf::Cell(147,10,utf8_decode($dados['crianca']),0,1,'C');
        $pdf::SetFont("Arial","",11);
        $pdf::SetXY(53.6,117.5);
        $pdf::Cell(7,10,utf8_decode($dados['dia_batizado']),0,1,'L');
        $pdf::SetXY(63.7,117.5);
        $pdf::Cell(15,10,utf8_decode($dados['mes_batizado']),0,1,'C');
        $pdf::SetXY(82.5,117.5);
        $pdf::Cell(15,10,utf8_decode($dados['ano_batizado']),0,1,'L');
        $pdf::SetXY(101,117.5);
        $pdf::Cell(15,10,utf8_decode($dados['local']),0,1,'L');
        $pdf::SetXY(53.6,124.15);        
        $pdf::Cell(7,10,utf8_decode($dados['dia_nascimento']),0,1,'L');
        $pdf::SetXY(63.7,124.15);
        $pdf::Cell(15,10,utf8_decode($dados['mes_nascimento']),0,1,'C');
        $pdf::SetXY(83.5,124.15);
        $pdf::Cell(15,10,utf8_decode($dados['ano_nascimento']),0,1,'L');
        $pdf::SetXY(46.7,130.4);
        $pdf::Cell(15,10,utf8_decode($dados['pai']),0,1,'L');
        $pdf::SetXY(33.7,136.65);
        $pdf::Cell(15,10,utf8_decode($dados['mae']),0,1,'L');
        $pdf::SetXY(56.7,143.35);
        $pdf::Cell(15,10,utf8_decode($dados['padrinho']),0,1,'L');
        $pdf::SetXY(33.7,149.65);
        $pdf::Cell(15,10,utf8_decode($dados['madrinha']),0,1,'L');
        $pdf::SetXY(47,156.08);
        $pdf::Cell(15,10,utf8_decode($dados['padre']),0,1,'L');
        $pdf::SetXY(119,193.4);
        $pdf::Cell(15,10,utf8_decode($dados['dia_atual']),0,1,'L');
        $pdf::SetXY(132,193.4);
        $pdf::Cell(15,10,utf8_decode($dados['mes_atual']),0,1,'C');
        $pdf::SetXY(156,193.4);
        $pdf::Cell(15,10,utf8_decode($dados['ano_atual']),0,1,'L');        
        $pdf::SetXY(40,162.55);
        $pdf::Cell(15,10,utf8_decode($dados['finalidade']).'.',0,1,'L');
        $pdf::SetFont("Arial","B",9.5);
        $pdf::SetXY(30.93,167.5);                
        $pdf::Cell(15,10,utf8_decode($dados['obs']).'.',0,1,'L');
  
        $pdf::Output('I','Certidão Batismo - '.$dados['crianca'],true);
        exit;
        
        
    }
    private function notifCertBatismo($notify){
        $lastNotify = DB::table('emissa_cert_batismo')
        ->where('finalidade','like',$notify['finalidade'])
        ->where('certidao','like',$notify['certidao'])
        ->latest();
        if(!empty($lastNotify->id)){
            $lastDate = date('Y-m-d',strtotime($lastNotify->create_at));
            if($lastDate != date('Y-m-d',time())){            
                $operacao = DB::table('emissa_cert_batismo')->insert($notify);
            }else{
                $operacao = DB::table('emissa_cert_batismo')->update($notify);
            }
            
        }else{
            $operacao = DB::table('emissa_cert_batismo')->insert($notify);
        }
        return $operacao;
    }

}
