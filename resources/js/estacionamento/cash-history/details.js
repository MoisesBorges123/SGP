const { default: Swal } = require('sweetalert2');


$(document).on('click','.btn-details',function(){
    Swal.fire({
        title:'Mais Informações',
        html:'Carro: '+$(this).data('vehicle')+'<br>'+'Proprietário: '+$(this).data('owner'),
        icon:'info'
    })
});