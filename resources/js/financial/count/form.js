window._ = require('lodash');
// @ts-ignore
window.$ = window.jQuery = require('jquery');
require('jquery-mask-plugin');
$('.money2').mask("#.##0,00", {reverse: true});
$(document).on('click','.btn_plus',function(){
    var value = $('#'+$(this).attr('for')).val()*1;
    value++;
    $('#'+$(this).attr('for')).val(value);
    total();
});
$(document).on('click','.btn_less',function(){
    var value = $('#'+$(this).attr('for')).val()*1;
    value--;
    if(value<0){
        value=0;
    }
    $('#'+$(this).attr('for')).val(value);
    total();
});
$(document).on('input','.form-control-primary',function(){
    if($(this).val()==''){
        
        total();
    }
})
$(document).on('input','.form-control-primary',function(){
    total();
})
function number_format (number, decimals, dec_point, thousands_sep) {
    number = number.toFixed(decimals);

    var nstr = number.toString();
    nstr += '';
    x = nstr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? dec_point + x[1] : '';
    var rgx = /(\d+)(\d{3})/;

    while (rgx.test(x1))
        x1 = x1.replace(rgx, '$1' + thousands_sep + '$2');

    return x1 + x2;
}
function total(){
    //Moedas
    var moeda_05 =  parseInt($('#moeda_5').val());
    var moeda_10 =  parseInt($('#moeda_10').val());
    var moeda_25 =  parseInt($('#moeda_25').val());
    var moeda_50 =  parseInt($('#moeda_50').val());
    var moeda_100 = parseInt($('#moeda_100').val());

    //Notas
    var nota_2 = parseInt($('#nota_2').val());
    var nota_5 = parseInt($('#nota_5').val());
    var nota_10 = parseInt($('#nota_10').val());
    var nota_20 = parseInt($('#nota_20').val());
    var nota_50 = parseInt($('#nota_50').val());
    var nota_100 = parseInt($('#nota_100').val());
    var str_cheque = $('#cheque').val();
    str_cheque = str_cheque.replace(/([.*+?^=!:${}()|\[\]\/\\])/g,'');
    console.log(str_cheque)
    str_cheque = str_cheque.replace("/,/gi",'.')
    console.log(str_cheque);
    var cheque = parseFloat(str_cheque);

    var moedas =(moeda_05 * 0.05) +
                (moeda_10 * 0.10) +
                (moeda_25 * 0.25) +
                (moeda_50 * 0.50) +
                (moeda_100 * 1.00);
    var notas = (nota_2 * 2.00) +
                (nota_5 * 5.00) +
                (nota_10 * 10.00) +
                (nota_20 * 20.00) +
                (nota_50 * 50.00) +
                (nota_100 * 100.00) +
                (cheque) ;
    var total =  moedas + notas;
    
    ;

    $('#total').html('Moedas: R$ '+number_format(moedas,2,',','.')+'<br>'+'Notas: R$ '+number_format(notas,2,',','.')+'<br>'+'Total: R$ '+number_format(total,2,',','.'));

}