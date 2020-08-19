window._ = require( 'lodash' );
window.$ = window.jQuery = require( 'jquery' );
window.Popper = require('popper.js').default;
require( 'datatables.net-bs4' );
require( 'datatables.net' );
const Swal = require('sweetalert2');
import PerfectScrollbar from 'perfect-scrollbar';

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
    
    var emitir = await Swal.fire({
        title:'Para qual é a finalidade desse certidão?',
        icon:'question',
        html:"<label>Finalidade:</label><input name='finalidade' id='id_finalidade' class='form-control'/>",
        confirmButtonText:'Emitir!',
        cancelButtonText:'Sair.',
        showCancelButton:true,
    });
    if(emitir.value){
        
        window.open($(this).data('url')+"/"+$('#id_finalidade').val(),'_blank');
    }   
    
    return false;
});

$('document').ready(function(){
    
});