window._ = require('lodash');
// @ts-ignore
window.$ = window.jQuery = require('jquery');
require('datatables.net-bs4');
require('datatables.net-dt');
import 'sweetalert2';
import 'jquery-mask-plugin';
import { result } from 'lodash';
import PerfectScrollbar from 'perfect-scrollbar';
import 'timepicki';
var _token = $('meta[name="csrf-token"]').attr('content');
$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': _token
}
});
const swal = require('sweetalert2');
const Toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', swal.stopTimer)
        toast.addEventListener('mouseleave', swal.resumeTimer)
    }
})
const myTable = $('#certidoesTable').DataTable({
    "searching": true,
    "ordering": true,
    'paging': true,
    "info": false,
    "order": false,
    "pageLength": 5,
    "language": {
        lengthMenu: "",
        zeroRecords: "Desculpe! Não há nenhum registro cadastrado.",
        search: "<i class='fas fa-search'></i> <span>Buscar</span>",
        // @ts-ignore
        paginate: {
            previous: "<i class='fas fa-angle-left'>",
            next: "<i class='fas fa-angle-right'>"
        },
        //"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese.json",
    },

    // @ts-ignore
    scrollX: "500px",

    scrollCollapse: true,
    pageLength: 50,
    scroller: true,
    "fnInitComplete": function () {
        const ps = new PerfectScrollbar('.dataTables_scrollBody');
    },
    "fnDrawCallback": function (oSettings) {
        const ps = new PerfectScrollbar('.dataTables_scrollBody');
    },


});
$(document).on('click','.print',async function(){
    var dados = await fetch($(this).data('link'))
    .then((result)=>{
        if(result.ok){
            return result.json();
        }
    });
    if(dados != '' ){
        var data = new FormData();
        console.log(dados);
        console.log(dados.valor);
        data.append('valor',dados.valor);
        data.append('desconto',dados.desconto);
        data.append('troco',dados.troco);
        data.append('dinheiro',dados.dinheiro);
        data.append('proprietario',dados.proprietario);
        data.append('placa',dados.placa);
        data.append('data_inicio',dados.data_inicio);
        data.append('data_fim',dados.data_fim);
        data.append('valor_pagar',dados.valor_pagar);
        fetch($('meta[name="printMonthly"]').attr('content'),{ 
            method:'POST',
            credentials:'same-origin',
            body:data,
            mode: 'no-cors'
        });
    }
});
$(document).on('click','.btn-delete',async function(){
    var resposta = await swal.fire({ 
        title:"Excluir Pagamento??",
        text:'Tem certeza que deseja excluir esse pagamento?',
        icon: 'question',
        showCancelButton:true,
        confirmButtonText:'Excluir!!',
        cancelButtonText:'Cancelar.'
    });

    if(resposta.value){
        fetch($(this).data('link'),{ 
        method:'DELETE',
        credentials:'same-origin',
        headers:{
            'X-CSRF-TOKEN':_token,
        }, 
        }).then((result)=>{
            if(result.ok){
                return result.json();
            }else{
                false;
            }
        }).then((resposta)=>{
            if(resposta){
                Toast.fire({
                    icon: 'success',
                    title: 'Pagamento excluido com sucesso!!'
                });
                setTimeout(() =>{
                    window.location.reload();
                 },1200)
                
            }else{
                Toast.fire({
                    icon: 'error',
                    title: 'Erro ao excluir pagamento'
                });
            }
        });
        
    }
    
});
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











