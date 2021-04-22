window._ = require('lodash');
// @ts-ignore
window.$ = window.jQuery = require('jquery');
require('datatables.net-bs4');
require('datatables.net-dt');
import 'jquery-mask-plugin';
const myTable = $('#certidoesTable').DataTable({
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