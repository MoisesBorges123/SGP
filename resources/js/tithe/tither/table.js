const swal = require('sweetalert2');
window._ = require('lodash');
window.$ = window.jQuery = require('jquery');
require('datatables.net-bs4');
require('datatables.net-dt');
import 'jquery-mask-plugin';
import PerfectScrollbar from 'perfect-scrollbar';
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
$(document).on('click', '#btn-excluir', async function () {
    // @ts-ignore
    var excluir = await swal.fire({
        title: 'Excluir??',
        text: 'Tem certeza que deseja excluir esse dizimista e todas as suas devoluções?',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Cancelar.',
        confirmButtonText: 'Excluir!'
    });
    if (excluir.value) {
        var excluido = await fetch($(this).data('link'), {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'DELETE',
        }).then((result) => {
            if (result.ok) {
                return result.json();
            } else {
                return false;
            }
        });
        console.log(excluido);
        if (excluido && !excluido.erro) {
            // @ts-ignore
            await swal.fire('Excluido!!', 'Dizimista excluido com sucesso.', 'success');
            window.location.reload();
        } else {
            // @ts-ignore
            swal.fire('Ops!!', 'Ocorreu um erro ao tentar excluir esse dizimista.', 'error');
        }

    }
});