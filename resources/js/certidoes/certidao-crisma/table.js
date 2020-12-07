window._ = require( 'lodash' );
window.$ = window.jQuery = require( 'jquery' );
window.Popper = require('popper.js').default;
require( 'datatables.net-bs4' );
require( 'datatables.net' );
const Swal = require('sweetalert2');
import PerfectScrollbar from 'perfect-scrollbar';
var finalidades = buscaFinalidade();

const myTable = $('#certidoesTable').DataTable({
    "searching": true,
    "ordering": true,
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
    /**
     * CÓDIGO PARA EMBELAZAR A BARRA DE ROLAGEM VERTICAL     *
     */ 
    scrollX: "500px",        
          
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
$(document).on('click','.btn-delete', async function(){
   var destroy = await Swal.fire({
        title:'Excluir registro?',
        text: 'Tem certeza que deseja excluir esse registro?',
        icon:'question',
        showCancelButton:true,
        confirmButtonText:'Excluir!',
        cancelButtonText:'Cancelar.',
    });
    if(destroy.value){
        var destroied = fetch($(this).data('url'),{
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method:'DELETE',
        }).then((result)=>{
            if(result.ok){
                return result.json();
            }else{
                return false;
            }
        });
        if(!destroied){
            Swal.fire('Algo deu Errado!','Erro ao excluir esse registro.','error');
        }else{
            await Swal.fire('Excluido!','Registro excluido com sucesso.','success');
            window.location.reload();

        }
        
    }
});
$(document).on('click','.btn-emitir',async function(){
    
    var obs = createTextarea('observacao','Observações','Informações adicionais','');
    var finalidade = await createSelect('finalidade','Finalidade',finalidades);    
    console.log(finalidade.input);
    var emitir = await Swal.fire({
        title:'Para qual é a finalidade desse certidão?',
        icon:'question',
        html:"<div class='row'>"
            +"<div class='col-12 text-left'>"+finalidade.label+finalidade.input+"</div>"
            +"<div class='col-12 text-left'>"+obs.label+obs.input+"</div>"
        +"</div>",
            
        confirmButtonText:'Emitir!',
        cancelButtonText:'Sair.',
        showCancelButton:true,
        preConfirm: function(){
            if($('#id_finalidade').val()==''){
                return false;
            }          
        },
    });
    if(emitir.value){
        
        window.open($(this).data('url')+"/"+$('#id_finalidade').val()+"/"+$('#id_observacao').val(),'_blank');
    }   
    
    return false;
});

async function buscaFinalidade(){
   
   var dados = await fetch($('meta[name="url-search-finalidades"]').attr('content'),{
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method:'GET',
        credentials:'same-origin'
    }).then((result)=>{
        if(result.ok){            
            return result.json();
        }
    });    
    return dados;
    
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
function createTextarea(name,label,placeholder,classes){
  var id="id_"+name;
  var input = "<textarea max name='"+name+"' id='"+id+"' maxlength='80' class='form-control"+classes+"' rows='4' placeholder='"+placeholder+"'></textarea>";
  var lbl = "<label> "+label+" </label>";
  var campo={}
  campo={
      label:lbl,
      input:input,
  };
              
  
  return campo;
}
async function createSelect(name,label,dados,classes=''){
  var id="id_"+name;
  var input = "<select name='"+name+"' id='"+id+"' class='form-control "+classes+"'/>";
  var select  = await dados.then((result)=>{          
      $.each(result,function(i,result){          
        input = input+"<option value='"+result.value+"'>"+result.option+"</option>";        
      });
      input = input+"</select>";
      return input;
  });  
  
    var lbl = "<label>"+label+"</label>";
    var campo={}
    campo={
        label:lbl,
        input:select,
    };
    return campo;
              
  
  
}

function fill_datatable(filter_book='')
{
    var dataTable = $('#certidoesTable').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "searching":false,
        "ajax":{
            url:$('meta[name="url-search-book"').attr('content'),
            type:"POST",
            data:{
                _token:_token,filter_book:filter_book
            }
        }
    })
}