<?php
use Mike42\Escpos\PrintConnectors\FilePrintConnector ; 
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer ;
require "../../impressora/drivers/autoload.php " ; 
$connector = new WindowsPrintConnector("EPSON_TM_T20");           
$printer = new Printer($connector);
$printer->pulse();
$printer -> close();
return true;
?>