
const swal = require('sweetalert2');
window._ = require('lodash');
// @ts-ignore
window.$ = window.jQuery = require('jquery');
require('datatables.net-bs4');
require('datatables.net-dt');
require('jquery-mask-plugin');
require('jquery-tabledit');
import PerfectScrollbar from 'perfect-scrollbar';


const url_save_devolution=$('meta[name="url-save-devolution"]').attr('content');
const _token = $('meta[name="csrf-token"]').attr('content');
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': _token
    }
});
$('#devolucoes').Tabledit({
    url:url_save_devolution,     
    editButton: false,
    deleteButton: false,
    hideIdentifier: true,
    inputClass:'form-control input-lg money2 table-edit-input',
    columns: {
        identifier: [0, 'id'],
        editable: [[1, 'Ano'], [2, 'Janeiro'], [3,'Fevereiro'], [4,'Março'], [5,'Abril'], [6,'Maio'], [7,'Junho'], [8,'Julho'], [9,'Agosto'], [10,'Setembro'], [11,'Outubro'],[12,'Novembro'],[13,'Dezembro']]
    },
    onSuccess:async function(data, textStatus, jqXHR){
         await swal.fire('OK!','Devolução Salva','success');
         window.location.reload();
    }
});
$('.money2').mask("#.##0,00", {reverse: true});
$(document).on('focus','.money2',function(){
    $(this).val(null);
})

