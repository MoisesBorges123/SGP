<?php

use Mike42\Escpos\PrintConnectors\FilePrintConnector ; 
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer ;
require "../../impressora/drivers/autoload.php " ; 
date_default_timezone_set('America/Sao_Paulo');

            $connector = new WindowsPrintConnector("EPSON_TM_T20");           
            $printer = new Printer($connector);
			$printer->pulse();
            
          
                $printer->selectPrintMode(32);
                $printer->setJustification(Printer::JUSTIFY_CENTER);               
                $printer->setTextSize(3,3);                
                $printer -> text("Relatório de Caixa do dia ".date('d/m/Y',time())."\n\n");   
				
                $printer->setJustification(Printer::JUSTIFY_LEFT);
                $printer->selectPrintMode(0);
                $printer->text("Total de Mensalidades pagas: ".$_POST['tn_mensalidade']." - ".$_POST['tv_mensalidade']."\n");
                $printer->text("Numero de pagamenos Rotativo: ".$_POST['tn_rotativo']."\n");
                $printer->text("Total de pagamenos Rotativo: ".$_POST['tv_rotativo']."\n\n");
                $printer->text("Valor do Caixa: ".$_POST['tv_geral']."\n");
                $printer->text("Valores não recebidos: ".$_POST['defict']."\n\n\n");
                $printer->text("Observações: ".$_POST['observacoes']."\n\n\n");
                $printer->text("Ass:_____________________________________"."\n");        
                $printer -> close();
                return true;
      