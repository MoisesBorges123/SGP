<?php

use Mike42\Escpos\PrintConnectors\FilePrintConnector ; 
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer ;
require "../../impressora/drivers/autoload.php " ; 


            $connector = new WindowsPrintConnector("EPSON_TM_T20");           
            $printer = new Printer($connector);
			$printer->pulse();
            
          
                $printer->selectPrintMode(32);
                $printer->setJustification(Printer::JUSTIFY_CENTER);               
                $printer->setTextSize(2,2);                
                $printer -> text("PLACA: ".strtoupper($_POST['placa']."\n\n"));   
                $printer -> text(strtoupper($_POST['proprietario']."\n\n"));   
				
                //$printer->setJustification(Printer::JUSTIFY_LEFT);
                $printer->selectPrintMode(0);
                $printer->text("INÍCIO: ".date('d/m/Y',strtotime($_POST['data_inicio']))." ÀS ".$_POST['h_in']."\n");
                $printer->text("TÉRMINO: ".date('d/m/Y',strtotime($_POST['data_fim']))." ÀS ".$_POST['h_out']."\n\n\n");
                
                
                
                

                if(!empty($_POST['desconto']) && $_POST['desconto'] != 'R$ 0,00'){
					
					
					
					$dinheiro = floatval(str_replace(',','.',str_replace('.','',$_POST['dinheiro'])));
                    $printer->text("\nTOTAL............................".$_POST['valor']);
                    $printer->text("\nDESCONTO.........................".$_POST['desconto']);
					$printer->text("\nVALOR À PAGAR....................".$_POST['valor_pagar']);                
                    $printer->text("\n\nDINHEIRO.........................".$_POST['dinheiro']);
                    $printer->text("\nTROCO............................".$_POST['troco']."\n\n");
                }else{
                    $printer->text("\nVALOR À PAGAR....................".$_POST['valor']);                
                    $printer->text("\nDINHEIRO.........................".$_POST['dinheiro']);
                    $printer->text("\nTROCO............................".$_POST['troco']."\n\n");
                }
                $printer->setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text("\n\n ESTACIONAMENTO CATEDRAL\n");
                $printer -> text("Rua Antônio Alves Benjamim, s/n, centro \n");
                $printer -> text("Telefone: (33)3522-3278/(33)9 9855-3935 \n");
                $printer -> cut();
      
            $printer -> close();
			return true;