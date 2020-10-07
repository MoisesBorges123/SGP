const { default: Swal } = require("sweetalert2")
window._ = require( 'lodash' );
window.$ = window.jQuery = require( 'jquery' );
window.Popper = require('popper.js').default;
require( 'datatables.net-bs4' );
require( 'datatables.net' );
import PerfectScrollbar from 'perfect-scrollbar';
const sacramentos = [ 
    {value:'1',option:'Batizado'},
    {value:'2',option:'Crisma'},
    {value:'3',option:'Casamento'},
];
const myTable = $('#bookTable2').DataTable({
    "searching": true,
    "ordering": false,
    'paging':true,
    "info":false,
    
    "language": {
        lengthMenu: "",
        zeroRecords: "Desculpe! Não há nenhum registro cadastrado.",
        search:"<i class='fas fa-search'></i> <span>Buscar</span>",
        paginate: { 
            previous: "<i class='fas fa-angle-left'>", 
            next: "<i class='fas fa-angle-right'>" 
        },
        //"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese.json",
    },
    scrollY: "500px",        
          
    scrollCollapse: !0,
    pageLength: 50,
    scroller: !0,
    "fnInitComplete": function () {        
        const ps = new PerfectScrollbar('.dataTables_scrollBody');
    },     
    "fnDrawCallback": function (oSettings) {        
        const ps = new PerfectScrollbar('.dataTables_scrollBody');
    },
  
});
$(document).on('click','.btn-excluir',async function(){
    var excluir = await Swal.fire({
        title:'Excluir este livro??',
        text:'Tem certeza de deseja excluir o livro '+$(this).data('numerolivro'),
        icon:'question',
        confirmButtonText:'Excluir!',
        cancelButtonText:'Cancelar.',        
        showCancelButton:true,

    });
    if(excluir.value){
        
        var excluido = await fetch($(this).data('url'),{
            credentials:'same-origin',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method:'delete',
        }).then((result)=>{
            if(result.ok){
                return result.json();
            }else{
                Swal.fire('OPS!!','Algo deu errado...','error');
            }
        });
      
        if(excluido.excluir){
            await Swal.fire('Excluido!!','O livro foi excluido.','success');            
            location.reload();
        }else{
            Swal.fire('OPS!!','Ocorreu um erro inesperado ao excluir este livro.','error');
        }
        
    }
})
$(document).on('change input','.form-control',function(){
    Swal.resetValidationMessage();
});
$(document).on('click','#btn-add-book',async function(){
    var numLivro = createInput('numero','*Numeração do Livro','number',true);
    var qtdePaginas = createInput('paginas','*Total de Páginas','number',true);
    var dataInicio = createInput('data_inicio','Data de Inicio','date');
    var dataFim = createInput('data_fim','Data de Término','date',true);
    var sacramento = createSelect('sacramento','*Livro de:',sacramentos);
    var observacoes = createTextarea('observacao','Observações','Insira aqui algum comentário ou observações sobre esse livro');
    var cadastrar = await Swal.fire({
        title:"Novo Livro",
        html:"<div class='row'>"
            +"<div class='col-12 text-left'>"+numLivro.label+numLivro.input+"</div>"
            +"<div class='col-12 text-left'>"+qtdePaginas.label+qtdePaginas.input+"</div>"
            +"<div class='col-12 text-left'>"+sacramento.label+sacramento.input+"</div>"
            +"<div class='col-6 text-left'>"+dataInicio.label+dataInicio.input+"</div>"
            +"<div class='col-6 text-left'>"+dataFim.label+dataFim.input+"</div>"
            +"<div class='col-12 text-left'>"+observacoes.label+observacoes.input+"</div>"
            +"</div>",
            showCancelButton:true,
            confirmButtonText:"Cadastrar!",
            cancelButtonText:"Cancelar.",
            preConfirm:()=>{
                if($('#id_numero').val()=='' || $('#id_paginas').val()==''){
                    Swal.showValidationMessage('Os campos com "*" são obrigatórios.');
                    return false;
                }
                if($('#id_numero').val().length>=5){
                    Swal.showValidationMessage('Não é possivel cadastrar um livro com numeração acima de 9999.');
                    return false;

                }
                if($('#id_paginas').val()>1001){
                    Swal.showValidationMessage('Não é possivel cadastrar um livro que tenha mais de 1000 páginas.')
                    return false;
                }
                if($('#id_data_fim').val() < $('#id_data_inicio').val()){
                    Swal.showValidationMessage('A data término insirida é invalida.')
                    return false;
                }
                if($('#id_paginas').val() < 0){
                    Swal.showValidationMessage('A quantidade de paginas deve ser superior a "0".')
                    return false;
                    
                }
                if($('#id_numero').val() < 0){
                    Swal.showValidationMessage('A numerção do livro deve ser superior a "0".')
                    return false;                    
                }
                
            }        
    });    
    
    if(cadastrar.value){
        var form = new FormData();
        form.append('numero',$('#id_numero').val());
        form.append('qtdePaginas',$('#id_paginas').val());
        form.append('sacramento',$('#id_sacramento').val());
        form.append('data_inicio',$('#id_data_inicio').val());
        form.append('data_fim',$('#id_data_fim').val());
        var create = await fetch($('meta[name="url-store-book"]').attr('content'),{
            method:'POST',
            credentials:'same-origin',
            body:form,
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).then((result)=>{
            if(result.ok){
                return result.json();
               
            }else{
                Swal.fire('Ops!!','Aconteceu um erro...<br><p>Código: '+result.status+'</p><br><p>'+result.statusText+'</p>','error');
            }
        });
        if(create.insert){
           await Swal.fire('Muito Bem!!','Esse livro foi cadastrado com sucesso','success');
           location.reload();
        }else{
            if(create.duplicate){
                Swal.fire('Livro Repitido!!','Esse livro já foi cadastrado','warning');
            }else{
                Swal.fire('Ops!!','Algo deu errado...','error');
            }
        }

       /* .then((dados)=>{
            if(dados.insert==false){
                Swal.fire('Ops!!','Aconteceu um erro...<br><p>Código: '+result.status+'</p><br><p>'+result.statusText+'</p>','error');
            }else{
                Swal.fire('Muito Bem!!','Esse livro foi cadastrado com sucesso','success');
                fetch($('meta[name="url-list-pages"]').attr('content')+"/"+dados.livro,{
                    method:'GET',
                    credentials:'same-origin',
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).then((result)=>{
                    if(result.ok){
                        return result.json();
                    }else{
                        console.log('Ocorreu um erro consultar as paginas do livro '+dados.livro);
                    }
                }).then((paginas)=>{
                    var tbody = '';
                    console.log('Passou - 1');
                    $.each(paginas,function(i,dados){          
                        tbody = tbody+"<tr>"
                                +"<td>"+dados.pagina+"</td>"
                                +"<td>"+dados.qtdeFotos+"</td>"
                                +"<td>"+dados.tamanho+"</td>"
                                +"<td>"+dados.observacao+"</td>"
                                +"</tr>";                        

                    });
                    //$('#paginasTable').DataTable().destroy();
                    $('tbody').html(null);
                    //$('tbody').html(tbody);
                    $('#paginasTable').find('tbody').append(tbody);
                    $('#paginasTable').DataTable().draw();
                    //$('#paginasTable').DataTable();           
                    console.log('Passou - 2');         
                });
                fetch($('meta[name="url-index-book"]').attr('content'),{
                    method:'GET',
                    credentials:'same-origin',                    
                }).then((result)=>{
                    if(result.ok){
                        return result.json();
                    }else{
                        console.log('Ocorreu um erro ao buscar lista de livros cadastrados.');
                        return false;
                    }
                }).then((livros)=>{
                    var option = '<option value="0">Selecione</option>';
                    $.each(livros,function(i,dados){
                        option = option
                        +"<option value='"+dados.id+"'>"+dados.numero+"</option>";

                    });
                    $('#id_select_livro').html(option);
                })
            }
        }) */
    
    
    
    
    }
});
function createInput(name,label,type,required){
  
    var id="id_"+name;
    var input = "<input name='"+name+"' id='"+id+"' type='"+type+"'  required='"+required+"' class='form-control'/>";
    var lbl = "<label>"+label+"</label>";
    var campo={}
    campo={
        label:lbl,
        input:input,
    };
                
    
    return campo;
}
function createSelect(name,label,dados){
    var id="id_"+name;
    var input = "<select name='"+name+"' id='"+id+"' class='form-control'/>";
    $.each(dados,function(i,result){      
        input = input+"<option value='"+result.value+"'>"+result.option+"</option>";        
    });
    input = input+"</select>"; 
    var lbl = "<label>"+label+"</label>";
    var campo={}
    campo={
          label:lbl,
          input:input,
      };      
      return campo;
                
      
                
    
    
}
function createTextarea(name,label,placeholder,classes=''){
    var id="id_"+name;
    var input = "<textarea max name='"+name+"' id='"+id+"' class='form-control"+classes+"' rows='3' placeholder='"+placeholder+"'></textarea>";
    var lbl = "<label> "+label+" </label>";
    var campo={}
    campo={
        label:lbl,
        input:input,
    };
                
    
    return campo;
}
