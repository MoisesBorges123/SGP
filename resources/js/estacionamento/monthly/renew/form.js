window._ = require('lodash');
window.$ = window.jQuery = require('jquery');
window.Vue = require ('vue');
import 'jquery-mask-plugin';
import {mask} from 'vue-the-mask'
import 'select2';

var _token = $('meta[name="csrf-token"]').attr('content');
$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': _token
}
});
const phone = new Vue({
    el: '#phone',
    directives: {mask},
});
const justify = $('.justificativa').html();
$('.justificativa').remove();
$('.money2').mask("#.##0,00", {reverse: true});
$('.placa').mask('AAA-0A00');
$('.js-example-basic-single').select2({
    dropdownCssClass:'customSelect2',
    closeOnSelect:true,
    allowClear: true,   
    closeOnSelect: true,
    placeholder: "Selecione uma placa",
});
$(document).on('change','#id_placa',async  function(){
    if($(this).val()!=''){
        var dados = await fetchLastPay($(this).val());        
        $('input[name="tipo_veiculo"]').filter('[value="'+dados.typevehicle+'"]').prop('checked',true);
        $('#id_valor').val(dados.valor);
        $('#id_preco').val(dados.valor);
        $('#id_desconto').val(dados.desconto);
        $('#id_total').val(dados.valor_pagar);        
        $('#id_parking').val(dados.parking_id);
        if(dados.desconto != 0 && dados.desconto!=''){
            $('.dinheiro').after('<div class="col-12 justificativa">'+justify+"</div>");
            $('#id_justificativa').html(dados.justify);
        }else{
            $('.justificativa').remove();
        }
    }
});
$(document).on('change','input[name="tipo_veiculo"]',async function(){
    var price = await buscaPreco($(this).val());
    $('#id_valor').val("R$ "+number_format(price.mensalidade,2,',','.'));
    $('#id_total').val("R$ "+number_format(price.mensalidade,2,',','.'));
    $('#id_table_price').val(price.id);
});
$(document).on('click','.pagar',async function(){
    openGave();    
    $('#form_monthly').submit();
});
$(document).on('input','#id_desconto',function(){
    if($('#id_desconto').val()==0 || $('#id_desconto').val()=='' || $('#id_desconto').val()==null ){
        $('.justificativa').remove();
        
    }else{
        if(!$('.justificativa').html()){
            $('.dinheiro').after('<div class="col-12 justificativa">'+justify+"</div>");            
        }
        
    }
    var valor = $('#id_valor').val();
    if($('#id_desconto').val()==''){
        var desconto = 0;     
        desconto = parseFloat(desconto);                  
    }else{
        var desconto = $('#id_desconto').val();
        desconto = desconto.replace(',','.');
        desconto = parseFloat(desconto);
    }
    valor = valor.replace(',','.');
    valor = valor.replace('R$ ','');        
    valor = parseFloat(valor);
    var total = valor - desconto;
    if(Number.isInteger(total)){
        total = "R$ "+total+",00";
    }else{
        total = "R$ "+total;
        total = total.replace(',','');
        total = total.replace('.',',');
    } 
    $('#id_total').val(total);
});
$(document).on('input','.money2',function(){          
        var dinheiro;
        var desconto;
        var valor = $('#id_valor').val();
        if($('#id_desconto').val()==''){
            desconto = 0;     
            desconto = parseFloat(desconto);                  
        }else{
            desconto = $('#id_desconto').val();
            desconto = desconto.replace(',','.');
            desconto = parseFloat(desconto);
        }
        if($('#id_pago').val()==''){
            dinheiro = 0;     
            dinheiro = parseFloat(dinheiro);                  
        }else{
            dinheiro = $('#id_pago').val();
            dinheiro = dinheiro.replace(',','.');
            dinheiro = parseFloat(dinheiro);
        }
        valor = valor.replace(',','.');
        valor = valor.replace('R$ ','');        
        valor = parseFloat(valor);
        console.log('valor: '+valor+'\ndinheiro: '+dinheiro+'\ndescoto: '+desconto);
        var troco = dinheiro-(valor-desconto); 
        
        var x;
        if(troco<0){
            x = troco*-1;             
            
        }else{
            x = troco
        }
        if(Number.isInteger(x)){
            if(troco<0){
                troco = "-R$ "+x+",00";
            }else{
                troco = "R$ "+troco+",00";
            }
        }else{
            if(troco<0){
                
                troco = "-R$ "+x;
                troco = troco.replace(',','');
                troco = troco.replace('.',',');
            }else{
                
                troco = "R$ "+troco;
                troco = troco.replace(',','');
                troco = troco.replace('.',',');
            }
        }               
        $("#id_troco").val(troco);   
    
});
function buscaPreco(tipo_veiculo){
    var link = $('meta[name="fetchPrice"]').attr('content');
    var data = new FormData();
    console.log(tipo_veiculo);
    data.append('typevehicle',tipo_veiculo);
    return fetch(link,{
        credentials:'same-origin',
        body:data,
        method:'POST',
        headers:{
            'X-CSRF-TOKEN':_token,
        },
    })
    .then((result)=>{
        if(result.ok){
            return result.json()
        }else{
            return false;
        }
    });
}
function number_format (number, decimals, dec_point, thousands_sep) {
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}
async function fetchLastPay(placa){
    
        var dados= await fetch($('#id_placa').data('link')+'/'+placa,{
            method:'GET',        
            credentials:'same-origin',
        }).then((result)=>{
            if(result.ok){
                return result.json();
            }else{
                return false
            }
        }).then((resposta)=>{
            return resposta;
        });
    
    return dados;
    
}
async function openGave(){   

    fetch($('meta[name="openGave"]').attr('content'),{ 
        method:'GET',
        credentials:'same-origin',        
        mode: 'no-cors'
    });
}