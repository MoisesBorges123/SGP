
window._ = require('lodash');
window.$ = window.jQuery = require('jquery');
require('datatables.net-bs4');
require('datatables.net-dt');
require('select2');
import 'jquery-mask-plugin';
const Swal = require('sweetalert2');

$('.placa').mask('AAA-0A00');
var _token = $('meta[name="csrf-token"]').attr('content');
$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': _token
}
});

montarTable();
fetchHeader();
setInterval(() => {          
    montarTable();
    fetchHeader();
 }, 60000);      
 const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
    })
$(document).on('keypress','#placa_entrada',function(e) {
    if (e.which == 13) {
         $('#btn-entrar').trigger('click'); 
         return false;
    }
    
});
$(document).on('click','#btn-entrar',function(){
    var tempo = new Date;
    var horas = tempo.getHours();        
    if(horas < 28){

    if($('#placa_entrada').val()==null || $('#placa_entrada').val()==""){
            Swal.fire({
                title:'Ops!',
                html:'Você precisa informar a placa do veiculo.',
                icon:'warning',
                position:'top-right',
                timer:1500,
                showConfirmButton: false
                });
        }else{
            var modalidade = $("input[name='modalidade']:checked").val();
            var tipo_veiculo = $("input[name='tipo_veiculo']:checked").val();
            var placa = $('#placa_entrada').val();
            var estacionar_carro = $(this).data('url');
        $.ajax({
            url:estacionar_carro,
            type:'POST',
            data:{placa:placa,modalidade:modalidade,tipo_veiculo:tipo_veiculo},
            statusCode: {
                404: function() {
                Swal.fire('Erro 404', "Ocorreu um erro ao carregar ao carregar a pagina!",'error');
                },
                405: function() {
                Swal.fire('Erro 405', "Ocorreu um erro ao encontrar o metodo de pesquisa!",'error');
                },
                500: function() {
                Swal.fire('Erro 500', "Ocorreu um erro ao processar os dados!",'error');
                }
            
            },
            beforeSend:function(){
               
            },
            success:async function(data){

                if(data.insert==true){                    

                    Toast.fire({
                    icon: 'success',
                    title: 'Carro cadastrado!!'
                    });
                               
                    $('#placa_entrada').val(null);
                    var dados = await calc_estacionamento(data.id);                  
                    montarTable();
                    var h_in = dados.hora_entrada+":"+dados.min_entrada;                    
                    var preco = await buscaPreco(dados.tipo_veiculo);
                    var impressao = await printIn(dados.data_entrada,preco,dados.placa,h_in); //no futuro colocar operador
                }else{
                    if(data.carro_estacionado){
                        const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 4000,
                        timerProgressBar: true,
                        onOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                        })

                        Toast.fire({
                        icon: 'info',
                        title: 'O carro em questão já foi cadastrado.'
                        })
                        
                    }
                }                  
                
            }
        });
        }
    }else{
        Toast.fire({
            title:'O estacionamento já encerrou o expediente.',
            icon:'info'
        })
    }
    fetchHeader();
});
$(document).on('click','.btn-edit',function(){
    var id = $(this).data('time');
    console.log($(this).data('time'));
    var placa = $(this).data('placa'); 
    var link = $('meta[name="time_update"]').attr('content');
    Swal.fire({
        title:"Ajustar entrada do veículo "+placa,
        icon: 'question',        
        html: "<div class='row'>"            
            + "<div class='col-12 text-center'>"
            + "<label>Hora</label>"
            + "<input type='text' name='time_schedule' id='in_time_schedule' class='form-control time' />"
            + "</div>"
            + "</div>",
        onRender: () => {

            $('.time').mask('00:00');
        },
        showCancelButton:true,
        cancelButtonText:"Cancelar",
        confirmButtonText:"Alterar",
        preConfirm:()=>{
            if($('#in_time_schedule').val()==''){
                Swal.showValidationMessage("Por favor preencha o novo horário de entrada.");
                return false;
            }else{
                return true;
            }
        }

    }).then((result)=>{
        
        if(result.value){ 
                var data = new FormData();
                data.append('id',id);
                data.append('time',$('#in_time_schedule').val());
                data.append('_token',_token);
                return fetch(link,{
                    body:data,
                    method:'POST',
                    credentials: "same-origin",
                });
        }else{
        
            return false;
        }
    }).then((resultado)=>{
        if(!resultado.ok && resultado != false){
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                onOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
                })

                Toast.fire({
                icon: 'error',
                title: 'Não foi possivel comunicar com o servidor.'
                })
        }else if(resultado.ok){
            return resultado.json();
        }
    }).then((resposta)=>{
        if(resposta != false && resposta.update ){
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                onOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
                })

                Toast.fire({
                icon: 'success',
                title: 'Registro Alterado.'
                })
        }else if(resposta.update == false){
            if(resposta.duplicidade==true){

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })

                    Toast.fire({
                    icon: 'warning',
                    title: 'Esse carro já foi registrado.'
                    })
            }else{

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })

                    Toast.fire({
                    icon: 'error',
                    title: 'Não foi possivel alterar esse registro.'
                    })
            }
        }
        montarTable();
    });
    fetchHeader();
    
});
$(document).on('click','.btn-delete',function(){
    var id = $(this).data('id');
    var placa = $(this).data('placa');
    var url_delete = $('meta[name="parking_delete"]').attr('content');
    Swal.fire({
        title:"Excluir Veículo ?",
        html:"Tem certeza que deseja excluir o veículo <b>"+placa+"</b>",
        icon:"question",
        showCancelButton:true,
        confirmButtonText:"Deletar!",
        cancelButtonText:"Cancelar",
    }).then((result)=>{
        if(result.value){
            var data =  new FormData();
            data.append('_token',_token);
            data.append('id',id);
            return fetch(url_delete,{
                credentials: "same-origin",
                method:'POST',
                body: data
            })
        }
    }).then((resultado)=>{
        if(!resultado.ok){
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                onOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
                })

                Toast.fire({
                icon: 'error',
                title: 'Não foi possivel comunicar com o servidor.'
                })
            
        }else{
            return resultado.json();
        }
    }).then((resposta)=>{
        
        if(resposta==1){
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                onOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
                })

                Toast.fire({
                icon: 'success',
                title: 'Veículo removido.'
                });
                montarTable();
        }else{
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                onOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
                })

                Toast.fire({
                icon: 'error',
                title: 'Ocorreu um erro ao excluir esse veículo.'
                })
            
        }
    });
    montarTable();
    fetchHeader();
});
$(document).on('input','#id_desconto',function(){
    if($('#id_desconto').val()==0 || $('#id_desconto').val()=='' || $('#id_desconto').val()==null ){
        $('.justificativa').hide(500);
    }else{
        $('.justificativa').show(500);            
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
    Swal.resetValidationMessage();  
    
        var dinheiro;
        var desconto;
        var valor = $('#id_valor').html();
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
$(document).on('click','#btn-pg-sair',async function(){
          
    var dados = await calc_estacionamento($('#placa_saida').val());
    var titulo='';
    if(dados){
        if(!dados.valor){
             Toast.fire({
                 icon:'success',
                 title:'Pagamento Efetuado!!'
             });
        }else{
 
         if(dados.token){
             /* ROTINA PARA IMPLANTAÇÃO DO TOKEN
             titulo = "<h4>Tempo Estacionado <b>"+server.calculo.duracao_original+"</b></h4>"+
             "<h4>Abatimento <b>"+server.token.tempo.tempo+"</b></h4>"+
             "<h4>Resultado <b>"+server.calculo.duracao+"</b></h4>"+
             "<h4>Valor:<b>"+server.calculo.valor+"</b></h4>";
             */
         }else{
             titulo = "<h4>Tempo Estacionado <b>"+dados.duracao+"</b></h4>"+           
             "<h3>Valor:<b id='id_valor'>"+dados.valor+"</b></h3>";
         }
        var pago = createInput('pago','*Dinheiro','text',true);
        var desconto = createInput('desconto','Desconto','text',true);
        var troco = createInput('troco','Troco','text',true);
        //chave = createInput('chave','Chave','text',true);
        var pagamento = await Swal.fire({
            title:'<h2>Carro '+dados.placa+"</h2>",
            showCancelButton:true,
            cancelButtonText:"Sair",
            html:"<div class='titulo-box-saida'>"+titulo+"</div>"+
            "<div class='row mt-4'>"+
            "<div class='col-4 efetuarPagamento'>"+pago.label+"</div><div class='col-8 efetuarPagamento'>"+pago.input+"</div>"+
            "<div class='col-4 mt-2 efetuarPagamento'>"+desconto.label+"</div><div class='col-8 mt-2 efetuarPagamento'>"+desconto.input+"</div>"+
            "<div class='col-4 mt-2 efetuarPagamento'>"+troco.label+"</div><div class='col-8 mt-2 efetuarPagamento'>"+troco.input+"</div>"+
            //"<div class='col-2 m-t-10 fieldChave'>"+chave.label+"</div><div class='col-8 m-t-10 fieldChave' id='div_field_chave'>"+chave.input+"</div>"+"<div class='col-1 m-t-10 fieldChave btn' id='div_checking' ><i id='key-checking' data-fluxo='"+cod+"' class='ion-checkmark'></i></div>"+
            "<div class='col-4 mt-2 justificativa'><label>*Justificar Desconto</label></div><div class='col-8 mt-2 justificativa'><textarea rows='5' name='justificativa' placeholder='Insira uma justificativa para o desconto realizado' class='form-control' id='id_justificativa'></textarea></div>"+
            "<div class='col-12 m-t-10'>"+
                    "<div class='row'>"+
                        "<div class='col-6'>"+
                            "<div class='checkbox-fade fade-in-primary'>"+
                            "<label>"+
                                "<input type='checkbox' name='imprimir' value=''>"+
                                "<span class='cr'>"+
                                    "<i class='cr-icon icofont icofont-ui-check txt-primary'></i>"+
                                "</span>"+
                                "<span>Imprimir Cupom</span>"+
                            "</label>"+
                            "</div>"+
                        "</div>"+
                        /*
                        "<div class='col-6'>"+
                            "<div class='checkbox-fade fade-in-primary' id='chave_desconto'>"+
                                "<label>"+
                                    "<input type='checkbox' name='inserir_chave' value=''>"+
                                    "<span class='cr'>"+
                                        "<i class='cr-icon icofont icofont-ui-check txt-primary'></i>"+
                                    "</span>"+
                                    "<span>Chave de Desconto</span>"+
                                "</label>"+
                            "</div>"+
                        "</div>"+
                        */
                    "</div>"+
            "</div>"+
            "</div>",
            onOpen:()=>{                    
                    $('#id_pago').addClass('money2');
                    $('#id_desconto').addClass('money2');
                    $('#id_troco').addClass('heading-title text-warning');
                    $('#id_troco').prop('disabled',true);
                    $('#id_troco').val('R$ 0,00');
                    $('.justificativa').hide();
                    $('.fieldChave').hide();
                    $('.money2').mask("#.##0,00", {reverse: true});
            },
            preConfirm:()=>{
                if($('#id_pago').val()!=''){
                    var dinheiro = $('#id_pago').val();
                    var valor = dados.valor;
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
                    dinheiro = dinheiro.replace(',','.');
                    dinheiro = parseFloat(dinheiro);
                    valor = parseFloat(valor);
                        if(dinheiro<(valor-desconto)){
                            var menssagem = "O valor inserido é invalido";                                   
                            Swal.showValidationMessage(menssagem);                        
                            return false;
                        }else{
                            if(desconto!=0 && $('#id_justificativa').val()==''){
                                Swal.showValidationMessage("O campo JUSTIFICATIVA é obrigatório.");
                                return false
                            }else{
                                return true;                            
                            }
                        }
                }else{
                    var menssagem = "O campo dinheiro deve ser preenchido";
                    Swal.showValidationMessage(menssagem);         
                    return false;
                }
            }
        });
            var pg = pagamento.value;
        if(pg){//Efetuando pagamento e imprimindo comprovante
                var dinheiro =$('#id_pago').val();
                var desconto =$('#id_desconto').val() == '' ? '' : $('#id_desconto').val();
                var justificativa = $('#id_justificativa').val() == '' ? false : $('#id_justificativa').val();
                var troco =$('#id_troco').val();
                var imprimir = $("input[name='imprimir']").prop("checked");          
                var cod = $('#placa_saida').val();
              
                 
                //console.log('Dinheiro: '+dinheiro+'\nDesconto: '+desconto+'\nJustificativa: '+justificativa+'\nTroco: '+troco+'\nImprimir: '+imprimir);
                var efetuaPagamento = await saidaEstacionamento(cod,pg,dinheiro,desconto,justificativa,troco,imprimir,dados);
                
                if(efetuaPagamento){
                    if(efetuaPagamento.pagamento){
                        Toast.fire({
                            icon: 'success',
                            title: 'Pagamento Efetuado!!'
                        });
                        
                       
                    }
                    
                }
                if(imprimir){
                    console.log(dados);
                    var h_in = dados.hora_entrada+":"+dados.min_entrada;
                    var h_out = dados.hora_saida+":"+dados.min_saida;
                    var preco = await buscaPreco(dados.tipo_veiculo);
                    var impressao = await printOut(dados.data_entrada,dados.data_saida,preco,dados.placa,h_in,h_out,dados.duracao,dinheiro,dados.valor,desconto,troco); //no futuro colocar operador
                }
        }
        
        }
    }
    montarTable();
    fetchHeader();
 });
$(document).on('click','#btn-print-caixa',async function(){
    
    var deficit = createInput('deficit','Diferença','text',true);
    var obs='';
    var deficit_value=0;
    var imprimir = await Swal.fire({
        title:'Relatório de Caixa Diário',
        html:"<div class='row'>"
            +"<div class='col-4'>"+deficit.label+"</div>"
            +"<div class='col-12 mb-3'>"+deficit.input+"</div>"
            +"<div class='col-4'><label>Observações</label></div>"
            +"<div class='col-12'><textarea rows='5' name='observacao' id='id_observacao' class='form-control'></textarea></div>"
        +"</div>",
        onRender:()=>{
            $('#id_deficit').mask("#.##0,00", {reverse: true});
        },
        confirmButtonText:'Imprimir!',
        cancelButtonText:'Cancelar.',
        showCancelButton:true,
        preConfirm:function(){
            obs = $('#id_observacao').val();
            deficit_value = $('#id_deficit').val();
        }
    });
    if(imprimir.value){
        var dados = new FormData();
        dados.append('observacoes',obs);
        dados.append('deficit',deficit_value);
        var printDados = await fetch($('meta[name="parkingReportCashier"]').attr('content'),{ 
            method:'POST',
            credentials:'same-origin',
            body:dados,
            headers:{
                'X-CSRF-TOKEN':_token,
            },            
        }).then((result)=>{
            if(result.ok){
                return result.json();
            }else{
                return false
            }
        });
        if(printDados != false){
            var data = new FormData();
            data.append('observacoes',printDados.observacoes);
            data.append('deficit',printDados.deficit);
            data.append('tn_mensalidade',printDados.tn_mensalidade);
            data.append('tn_rotativo',printDados.tn_rotativo);
            data.append('tv_geral',printDados.tv_geral);
            data.append('tv_mensalidade',printDados.tv_mensalidade);
            data.append('tv_rotativo',printDados.tv_rotativo);
            fetch($('meta[name="printReportCashier"]').attr('content'),{ 
                method:'POST',
                credentials:'same-origin',
                body:data,
                mode: 'no-cors'
            });
        }
    }
});
function montarTable(){
   
    fetch($('meta[name="parking_index"]').attr('content'),{'method':'GET'}).then((result)=>{
        if(!result.ok){
            return{"busca":false}
        }else{
            return result.json();
            
        }
       
    }).then((resposta)=>{
        var linhasTBL = "";
        var placas_saida="";
        var dados = resposta.dados;
        var btn_geraChave='';
        var icone_veiculo=null;
        var style;
        var total =0;
        var tipo_veiculo = '';
    for(var i=0;i<resposta.total_registros;i++){     
        
        if(dados[i].typevehicle ==1){
            icone_veiculo = 'icofont-motor-bike';  
            style ='font-size: 21px;'  
            tipo_veiculo = 'Carro';
        }else{
            icone_veiculo='icofont-police-car-alt-2';
            style=null;
            tipo_veiculo = 'Moto';
        }
        if(dados[i].modalyti=='Rotativo'){
            btn_geraChave = "&nbsp;&nbsp;&nbsp;&nbsp;"+
            "<i style='"+style+"' data-key='' data-timeKey='"+dados[i].timeparking_id+"' data-id="+dados[i].parking_id+" data-placa="+dados[i].placa+" data-timeEstacionamento='' data-tempo_chave=''  data-chave_minTotal='' class='icofont icofont-key btn-key'></i>";
            
        }else{
            btn_geraChave='';
        }
        
       placas_saida=placas_saida+"<option value='"+dados[i].parking_id+"'>"+dados[i].placa+"</option>";
        linhasTBL = linhasTBL+
        "<tr>"+
            "<td ><span data-tooltip='"+dados[i].modality+"'>"+dados[i].placa+"</span></td>"+
            "<td>"+tipo_veiculo+"</td>"+
            "<td>"+dados[i].hour_in+':'+dados[i].min_in+"</td>"+
            "<td>"+dados[i].how_much+"</td>"+
           "<td class='table-actions'>"+
                "<a href=#editar'  class='table-action btn-edit' data-tooltip='Editar Horario' data-placa='"+dados[i].placa+"' data-time='"+dados[i].timeparking_id+"' >"+
                    "<i class='fas fa-user-edit btn-update' ></i>"+
                "</a>&nbsp;&nbsp;&nbsp;&nbsp;"+
                "<a href='#excluir' class='table-action table-action-delete btn-delete' data-id='"+dados[i].parking_id+"' data-placa='"+dados[i].placa+"' data-tooltip='Excluir'>"+
                    "<i data-id="+dados[i].parking_id+" data-placa="+dados[i].placa+"  data-dono='"+dados[i].pessoa_id+"' class='fas fa-trash btn-delete'></i>"
                "</a>"+
            "</td>";            
            
      
    } 
    console.log($('#placa_saida').val());
    if($('#placa_saida').val()==''){
        $('#placa_saida').html("<option value=''>Selecione uma placa...</option>");  
        $('#placa_saida').append(placas_saida);
    }
    $('.select2-search__field').addClass('placa');
    $('.placa').mask('AAA-0A00');  
    $('#tbody_minha_table').html('');
    $('#minha_tabela').find('tbody').append(linhasTBL);
   
    });
    
      
}
async function saidaEstacionamento(cod,pago='',dinheiro='',desconto='',justificativa='',troco='',imprimir='',server=''){
    var url_calc=$('meta[name="parkingOut_store"]').attr('content');
    var data = new FormData();
     data.append('cod',cod);
     data.append('pago',pago);
     data.append('desconto',desconto);  
     if(imprimir){
         data.append('imprimir',imprimir);            
     }else{
         data.append('imprimir','');            
     } 
     data.append('dinheiro',dinheiro);
     data.append('troco',troco);
     data.append('justificativa',justificativa); 
     data.append('valor',server.valor);
     data.append('h_saida',server.hora_saida);
     data.append('m_saida',server.min_saida);     
     //data.append('token',server.token);
     /*
     if(server.calculo.token){
         data.append('duracao_token',server.token.tempo.tempo);
     }else{
         data.append('duracao_token','');
 
     } */
     var calc = await fetch(url_calc,{
             method:'POST',
             credentials:"same-origin",
             headers:{
                 'X-CSRF-TOKEN':_token,
             },
             body:data
 
         }).then((result)=>{
             if(result.ok){
                 return result.json();
             }else{ 
                 Swal.fire({
                     title:'Erro ao dar saida neste veiculo.',
                     text:result.statusText+" ("+result.status+")",
                     icon:'error'
                 });
                 return false;
             }
         }).then((resultado)=>{
             if(resultado==1){
                Toast.fire({
                    icon: 'success',
                    title: 'Pagamento Efetuado!!'
                });
             }else{
                Swal.fire({
                    title:'Erro ao dar saida neste veiculo.',                    
                    icon:'error'
                });
             }
         });
     return calc;
}
async function calc_estacionamento(cod){
    var link  = $('meta[name="parkingOut_show"]').attr('content')+'/'+cod;
    return fetch(link)
    .then((result)=>{
        if(result.ok){
            return result.json();
        }else{
            return false;
        }
    }).then((resposta)=>{
        return resposta;
    });
        
    
}
function createInput(name,label,type,required){
        
    var id="id_"+name;
    var input = "<input name='"+name+"' id='"+id+"' type='"+type+"' required='"+required+"' class='form-control'/>";
    var lbl = "<label>"+label+"</label>";
    var campo={}
    campo={
        label:lbl,
        input:input,
    };
                
    
    return campo;
}
function printOut(data_entrada, data_saida,precos='',placa = '',h_in = '',h_out='',duracao='',dinheiro='',valor='',desconto=0,troco=0){
    var data = new FormData();
    
    if(desconto=='' || desconto == null){
        desconto = 0;
    }
    if(desconto=='' || desconto == null){
        desconto = 0;
    }
    data.append('placa',placa);
    data.append('data_entrada',data_entrada);
    data.append('data_saida',data_saida);
    data.append('min_60',precos.min_60);
    data.append('min_30',precos.min_30);
    data.append('min_15',precos.min_15);
    data.append('h_in',h_in);
    data.append('h_out',h_out);
    data.append('duracao',duracao);
    data.append('dinheiro',dinheiro);
    data.append('valor',valor);
    data.append('desconto',desconto);
    data.append('troco',troco);
    fetch($('meta[name="printOut"]').attr('content'),{ 
        method:'POST',
        credentials:'same-origin',
        body:data,
        mode: 'no-cors'
    });
}
function printIn(data_entrada,precos='',placa = '',h_in = ''){
    var data = new FormData();
   
    data.append('placa',placa);
    data.append('data_entrada',data_entrada);
  
    data.append('min_60',precos.min_60);
    data.append('min_30',precos.min_30);
    data.append('min_15',precos.min_15);
    data.append('h_in',h_in);

    fetch($('meta[name="printIn"]').attr('content'),{ 
        method:'POST',
        credentials:'same-origin',
        body:data,
        mode: 'no-cors'
    });
}
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
async function fetchHeader(){
    var link = $('meta[name="fetchHeader"]').attr('content');
    var dados = fetch(link)
    .then((result)=>{
        if(result.ok){
            return result.json();
        }else{
            return false;
        }
    }).then((response)=>{
        
        $('#headerNumber1').html(response.card1);
        $('#headerNumber2').html(response.card2);
        $('#headerNumber3').html(response.card3);
        $('#headerNumber4').html(response.card4);
    });
   
}