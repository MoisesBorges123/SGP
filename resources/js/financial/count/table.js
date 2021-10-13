const swal = require('sweetalert2');
window._ = require('lodash');
// @ts-ignore
window.$ = window.jQuery = require('jquery');
require('datatables.net-bs4');
require('datatables.net-dt');
import 'jquery-mask-plugin';
import { result } from 'lodash';
import PerfectScrollbar from 'perfect-scrollbar';
import Swal from 'sweetalert2';
import 'timepicki';
const _token = $('meta[name="csrf-token"]').attr('content');
const myTable = $('#titherTable').DataTable({
    "searching": true,
    "ordering": true,
    'paging': true,
    "info": false,

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
});

$(document).on('click', '#print', async function () {
    // @ts-ignore
    var print = await swal.fire({
        title: 'Quais Controles??',
        text:'Informe o periodo de referência que você deseja imprimir.',
        icon: 'question',
        confirmButtonText: 'Imprimir!',
        showCancelButton: true,
        cancelButtonText: 'Cancelar.',
        html: "<form id='form-print' action='" + $(this).data('link') + "' method='GET' target='_blank'><div class='row'>"
            + "<div class='col-6'>"
            + "<label>Data Inicial</label>"
            + "<input type='date' name='date_start' class='form-control'/>"
            + "</div>"
            + "<div class='col-6'>"
            + "<label>Data final</label>"
            + "<input type='date' name='date_end' class='form-control'/>"
            + "</div>"
            + "</div></form>",
        onRender: () => {

            $('.time').mask('00:00');
        }
    });
    if (print.value) {
        $('#form-print').submit()
    }

});
$(document).on('click', '#btn-filter', async function () {
    // @ts-ignore
    var print = await swal.fire({
        title: 'Quais Controles??',
        text:'Informe o periodo de referência que você deseja visualizar.',
        icon: 'question',
        confirmButtonText: 'Buscar!',
        showCancelButton: true,
        cancelButtonText: 'Cancelar.',
        html: "<form id='form_filter'  action='" + $(this).data('link')+"' method='GET' ><div class='row'>"
            + "<div class='col-6'>"
            + "<label>Data Inicial</label>"
            + "<input type='date' name='date_start' class='form-control'/>"
            + "</div>"
            + "<div class='col-6'>"
            + "<label>Data final</label>"
            + "<input type='date' name='date_end' class='form-control'/>"
            + "</div>"
            + "</div></form>",
        onRender: () => {
            
        }
    });
    $('#form_filter').submit();
   

});
$(document).on('click','.btn-delete', async function(){
    swal.fire({
        title:'Excluir Controle??',
        text:'Tem certeza que deseja excluir essa controle (entrada)?',
        icon:'question',
        showCancelButton:true,
        cancelButtonText:'Sair.',
        confirmButtonText:'Excluir!',        
    }).then((question)=>{
        if(question.isConfirmed){
            return fetch($(this).data('link'),{
                headers:{
                    'X-CSRF-TOKEN':_token
                },
                method:'DELETE',
                credentials:'same-origin'
            }).then((result)=>{
                if(result.ok){
                    return result.json();
                }else{
                    return false;
                }
            }).then((resposta)=>{
                if(resposta){
                    Toast.fire({
                        icon: 'success',
                        title: 'Controle Excluido com sucesso. ;)'
                      })
                      setTimeout(function(){
                          window.location.reload();
                      },3000)
                }else{
                    Toast.fire({
                        icon: 'warning',
                        title: 'Ops! Algo deu errado. :/'
                      })
                }
            })
        }
    })
});