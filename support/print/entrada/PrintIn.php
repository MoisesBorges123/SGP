<?php

use Mike42\Escpos\PrintConnectors\FilePrintConnector ; 
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer ;
require "../../impressora/drivers/autoload.php " ; 


            $connector = new WindowsPrintConnector("EPSON_TM_T20");           
            $printer = new Printer($connector);
			//$printer->pulse();
            
          
                $printer->selectPrintMode(32);
                $printer->setJustification(Printer::JUSTIFY_CENTER);               
                $printer->setTextSize(2,2);                
                $printer -> text("PLACA: ".strtoupper($_POST['placa']."\n\n"));   
				
                //$printer->setJustification(Printer::JUSTIFY_LEFT);
                $printer->selectPrintMode(0);
                $printer->text("HORÁRIO ENTRADA: ".date('d/m/Y',strtotime($_POST['data_entrada']))." ÀS ".$_POST['h_in']."\n\n\n");
                
                $printer->setJustification(Printer::JUSTIFY_RIGHT);
                $printer->text("TABELA DE PREÇOS\n\n");                
				$prefixo="R$ ";
				$printer->text("1H e acima de 30min........".$prefixo.number_format($_POST['min_60'],2,',','.')."\n");
				$printer->text("16min a 30min........".$prefixo.number_format($_POST['min_30'],2,',','.')."\n");
				$printer->text("01min a 15min........".$prefixo.number_format($_POST['min_15'],2,',','.')."\n");
                    
                
                

                
                $printer->setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text("\n\n ESTACIONAMENTO CATEDRAL\n");
                $printer -> text("Rua Antônio Alves Benjamim, s/n, centro \n");
                $printer -> text("Telefone: (33)3522-3278/(33)9 9855-3935 \n");
                $printer -> cut();
      
            $printer -> close();
return true;