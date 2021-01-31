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
$(document).on('click', '#sextou', async function () {
    var s19 = false;
    var d07 = false;
    var d10 = false;
    var d17 = false;
    var d19 = false;
    // @ts-ignore
    var imprimir = await swal.fire({
        title: '#Sextou!! :)',
        html: '<div class="row">' +
            '<div class="col-12 text-center">' +
            '<h3>Selecione as celebrações desejadas</h3>' +
            '</div>' +
            '<div class="col-6 text-left">'
            + '<div class="custom-control custom-checkbox">'
            + '<input type="checkbox" class="custom-control-input" checked=true id="sabado" value="1"></input>'
            + '<label class="custom-control-label" for="sabado">Sábado</label>'
            + '</div>'
            + '</div>' +
            '<div class="col-6 text-left">'
            + '<div class="custom-control custom-checkbox">'
            + '<input type="checkbox" class="custom-control-input" checked=true id="domingo07" value="2"></input>'
            + '<label class="custom-control-label" for="domingo07">Domingo 07h</label>'
            + '</div>'
            + '</div>' +
            '<div class="col-6 text-left">'
            + '<div class="custom-control custom-checkbox">'
            + '<input type="checkbox" class="custom-control-input" checked=true id="domingo10" value="3"></input>'
            + '<label class="custom-control-label" for="domingo10">Domingo 10h</label>'
            + '</div>'
            + '</div>' +
            '<div class="col-6 text-left">'
            + '<div class="custom-control custom-checkbox">'
            + '<input type="checkbox" class="custom-control-input"  id="domingo17" value="4"></input>'
            + '<label class="custom-control-label" for="domingo17">Domingo 17h</label>'
            + '</div>'
            + '</div>' +
            '<div class="col-6 text-left">'
            + '<div class="custom-control custom-checkbox">'
            + '<input type="checkbox" class="custom-control-input" checked=true  id="domingo19" value="5"></input>'
            + '<label class="custom-control-label" for="domingo19">Domingo 19h</label>'
            + '</div>'
            + '</div>'
            + '</div>',

        showCancelButton: true,
        confirmButtonText: "Imprimir!",
        cancelButtonText: 'Cancelar.',
        preConfirm: function () {
            // @ts-ignore
            s19 = $('#sabado').val();
            // @ts-ignore
            d07 = $('#domingo07').val();
            // @ts-ignore
            d10 = $('#domingo10').val();
            // @ts-ignore
            d17 = $('#domingo17').val();
            // @ts-ignore
            // @ts-ignore
            d19 = $('#domingo19').val();
        }


    });

    if (imprimir.value) {
        var d = new Date();
        var sexta = d.getDay();
        /*
        if(sexta != 6 ){
            swal.fire({
                title:"Sextou??",
                text:'Hoje não é sexta-feira ainda deseja imprimir todas as intenções do fim de semana mesmo assim?',
                icon:'question',

            });
        }
        */
        var link = $(this).data('link');
        var x = 6 - d.getDay(); //Diferença entre o dia atual da semana até sabado, sabendo que sabado vale 6
        var sabado = d.getDate() + x;
        var domingo = sabado + 1;
        var d_sabado = d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + sabado;
        var d_domingo = d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + domingo;
        //console.log("Proximo Sábado: "+d_sabado+"\n Proximo Domingo: "+d_domingo);
        //?date_schedule=2020-12-11&time_schedule=12%3A00
        //console.log(s19);
        // @ts-ignore
        if (s19 != '') {
            //console.log('Entrou');
            window.open(link + "?date_schedule=" + d_sabado + "&time_schedule=19:00", '_blank');
        }
        // @ts-ignore
        if (d07 != '') {

            window.open(link + "?date_schedule=" + d_domingo + "&time_schedule=07:00", '_blank');
        }
        // @ts-ignore
        if (d10 != '') {

            window.open(link + "?date_schedule=" + d_domingo + "&time_schedule=10:00", '_blank');
        }
        // @ts-ignore
        if (d17 != '') {

            window.open(link + "?date_schedule=" + d_domingo + "&time_schedule=17:00", '_blank');
        }
        // @ts-ignore
        if (d19 != '') {

            window.open(link + "?date_schedule=" + d_domingo + "&time_schedule=19:00", '_blank');
        }
        // console.log(x);
        //console.log(s19+d07+d10+d17+d19);
    }
    //window.open($(this).data('link'), '_blank');
});
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