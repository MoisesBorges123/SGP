const swal = require('sweetalert2');
window._ = require('lodash');
// @ts-ignore
window.$ = window.jQuery = require('jquery');
require('datatables.net-bs4');
require('datatables.net-dt');
import 'jquery-mask-plugin';
import { result } from 'lodash';
import PerfectScrollbar from 'perfect-scrollbar';
import 'timepicki';
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















$(document).on('click', '#old_intentions', async function () {

    // @ts-ignore
    var busca = await swal.fire({
        title: 'Filtrar Intenções por data',
        html: "<form method='GET' id='search-intention' action='" + $(this).data('link') + "'>" +
            "<div class='row'>" +
            "<div class='col-6'>" +
            "<label>Data Inicio</label>" +
            "<input class='form-control' name='begin' type='date'/>" +
            "</div>" +
            "<div class='col-6'>" +
            "<label>Data Fim</label>" +
            "<input class='form-control' name='end' type='date'/>" +
            "</div>" +

            "</div>" +
            "</form>",
        confirmButtonText: "Buscar...",
    });
    if (busca.value) {
        $('#search-intention').submit();
    }
});
$(document).on('click', '#print', async function () {
    // @ts-ignore
    var print = await swal.fire({
        title: 'Qual horário??',
        icon: 'question',
        confirmButtonText: 'Imprimir!',
        showCancelButton: true,
        cancelButtonText: 'Cancelar.',
        html: "<form id='form-print' action='" + $(this).data('link') + "' method='GET' target='_blank'><div class='row'>"
            + "<div class='col-6'>"
            + "<label>Data</label>"
            + "<input type='date' name='date_schedule' class='form-control'/>"
            + "</div>"
            + "<div class='col-6'>"
            + "<label>Hora</label>"
            + "<input type='text' name='time_schedule' id='in_time_schedule' class='form-control time' />"
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
$(document).on('click', '#btn-excluir', async function () {
    // @ts-ignore
    var excluir = await swal.fire({
        title: 'Excluir??',
        text: 'Tem certeza que deseja excluir essa intenção?',
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
            await swal.fire('Excluido!!', 'Intenção excluida com sucesso.', 'success');
            window.location.reload();
        } else {
            // @ts-ignore
            swal.fire('Ops!!', 'Ocorreu um erro ao tentar excluir essa intenção.', 'error');
        }

    }
});
$(document).on('input', '.time', function () {
    timerValidate($(this));
});
$(document).on('input', '.phone', function () {
    phoneValidate($(this));
});
$(document).on('click', '.avisos', async function () {
    var url = $('meta[name="fetch-notice"]').attr('content');
    var aviso = await fetch(url, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },  
        credentials:'same-origin'
    }).then((result) => {
        if (result.ok) {            
            return result.json();
        } else {
            return false;
        }
    });
    
    if (aviso) {
        // @ts-ignore
        swal.fire({
            title: 'Avisos',
            background: 'linear-gradient(35deg,#f5365c,#f56036)',
            html: "<br><br>"+aviso.observations,
            icon: 'warning',
            showCloseButton: true,
            showConfirmButton: false,
            iconHtml: '<span class="fas fa-bell"></span>',
            customClass: {
                container: 'text-warning',
                popup: '...',
                header: '...',
                title: 'text-white',
                closeButton: '...',
                icon: '...',
                image: '...',
                content: 'text-white text-justify',
                input: '...',
                validationMessage: '...',
                actions: '...',
                confirmButton: '...',
                denyButton: '...',
                cancelButton: '...',
                loader: '...',
                footer: '....'
            }
        });
        console.log(aviso);
    } else {
        // @ts-ignore
        swal.fire({
            title: 'Avisos',
            text: 'Não há nenhum aviso por hora.',
            icon: 'warning',
            showCloseButton: false,
            showConfirmButton: true,

        });
    }
});
function timerValidate(horario) {
    var x;
    var y;
    var caracteres = horario.val().length;

    //alert(caracteres);
    if (caracteres == 1) {
        if (horario.val() > 2) {
            horario.val(null);
        }

    } else if (caracteres == 2) {
        if (horario.val() > 23) {
            horario.val(null);
        }
    } else if (caracteres == 4) {
        x = horario.val();
        y = x.substring(3, 4);

        if (y > 6) {
            horario.val(x.substring(0, 3));
        }
    } else if (caracteres == 5) {
        x = horario.val();
        y = x.substring(3, 5);

        if (y > 59) {
            horario.val(x.substring(0, 3));
        }
    }

}
function phoneValidate(telefone) {
    var caracteres = telefone.val().length;
    if (caracteres >= 5) {
        var x = telefone.val();
        var y = x.substr(5, 1);

        if (y == 9) {
            //Montar Função para o telefone funcionar tanto com celular como fixo
            $('.phone').mask('(00) 00000-0000');
        } else {
            $('.phone').mask('(00) 0000-0000');
        }
    }
}