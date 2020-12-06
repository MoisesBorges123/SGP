const swal = require ('sweetalert2');
window._ = require( 'lodash' );
window.$ = window.jQuery = require( 'jquery' );
import 'timepicki';
import 'jquery-mask-plugin';
$(document).on('click','#sextou',async function(){
    var s19 = false;
    var d07 = false;
    var d10 = false;
    var d17 = false;
    var d19 = false;
    var imprimir = await swal.fire({
        title:'#Sextou!! :)',
        html:'<div class="row">'+
            '<div class="col-12 text-center">'+
                '<h3>Selecione as celebrações desejadas</h3>'+
            '</div>'+
            '<div class="col-6 text-left">'
                    +'<div class="custom-control custom-checkbox">'
                    +'<input type="checkbox" class="custom-control-input" checked=true id="sabado" value="1"></input>'
                    +'<label class="custom-control-label" for="sabado">Sábado</label>'
                    +'</div>' 
            +'</div>'+
            '<div class="col-6 text-left">'
                    +'<div class="custom-control custom-checkbox">'
                    +'<input type="checkbox" class="custom-control-input" checked=true id="domingo07" value="2"></input>'
                    +'<label class="custom-control-label" for="domingo07">Domingo 07h</label>'
                    +'</div>' 
            +'</div>'+
            '<div class="col-6 text-left">'
                    +'<div class="custom-control custom-checkbox">'
                    +'<input type="checkbox" class="custom-control-input" checked=true id="domingo10" value="3"></input>'
                    +'<label class="custom-control-label" for="domingo10">Domingo 10h</label>'
                    +'</div>' 
            +'</div>'+
            '<div class="col-6 text-left">'
                    +'<div class="custom-control custom-checkbox">'
                    +'<input type="checkbox" class="custom-control-input"  id="domingo17" value="4"></input>'
                    +'<label class="custom-control-label" for="domingo17">Domingo 17h</label>'
                    +'</div>' 
            +'</div>'+
            '<div class="col-6 text-left">'
                    +'<div class="custom-control custom-checkbox">'
                    +'<input type="checkbox" class="custom-control-input" checked=true  id="domingo19" value="5"></input>'
                    +'<label class="custom-control-label" for="domingo19">Domingo 19h</label>'
                    +'</div>' 
            +'</div>'
        +'</div>',
        
        showCancelButton:true,
        confirmButtonText:"Imprimir!",
        cancelButtonText:'Cancelar.',
        preConfirm: function(){
            s19 = $('#sabado').val();
            d07 = $('#domingo07').val();
            d10 = $('#domingo10').val();
            d17 = $('#domingo17').val();
            d19 = $('#domingo19').val();
        }
        
      
    });
    
    if(imprimir.value){
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
       var link=$(this).data('link');
       var x = 6 - d.getDay(); //Diferença entre o dia atual da semana até sabado, sabendo que sabado vale 6
       var sabado = d.getDate()+x;
       var domingo = sabado+1;
       var d_sabado =  d.getFullYear()+'-'+(d.getMonth()+1)+'-'+sabado;
       var d_domingo = d.getFullYear()+'-'+(d.getMonth()+1)+'-'+domingo;
       //console.log("Proximo Sábado: "+d_sabado+"\n Proximo Domingo: "+d_domingo);
        //?date_schedule=2020-12-11&time_schedule=12%3A00
        //console.log(s19);
       if(s19!=''){
        //console.log('Entrou');
        window.open(link+"?date_schedule="+d_sabado+"&time_schedule=19:00", '_blank');
       }
       if(d07!=''){

        window.open(link+"?date_schedule="+d_domingo+"&time_schedule=07:00", '_blank');
       }
       if(d10!=''){

        window.open(link+"?date_schedule="+d_domingo+"&time_schedule=10:00", '_blank');
       }
       if(d17!=''){
           
        window.open(link+"?date_schedule="+d_domingo+"&time_schedule=17:00", '_blank');
       }
       if(d19!=''){
           
        window.open(link+"?date_schedule="+d_domingo+"&time_schedule=19:00", '_blank');
       }
       // console.log(x);
        //console.log(s19+d07+d10+d17+d19);
    }
    //window.open($(this).data('link'), '_blank');
});
$(document).on('click','#old_intentions', async function(){

    var busca = await swal.fire({
        title: 'Intenções Antigas',
        html:"<form method='GET' id='search-intention' action='"+$(this).data('link')+"'>"+
                "<div class='row'>"+
                    "<div class='col-6'>"+
                        "<label>Data Inicio</label>"+
                        "<input class='form-control' name='begin' type='date'/>"+
                    "</div>"+
                    "<div class='col-6'>"+
                        "<label>Data Fim</label>"+
                        "<input class='form-control' name='end' type='date'/>"+
                    "</div>"+
                   
                "</div>"+
            "</form>",
            confirmButtonText:"Buscar...",
    });
    if(busca.value){
        $('#search-intention').submit();
    }
});
$(document).on('click','#print',async function(){
    var print = await swal.fire({
        title:'Qual horário??',
        icon:'question',
        confirmButtonText:'Imprimir!',
        showCancelButton:true,        
        cancelButtonText:'Cancelar.',
        html: "<form id='form-print' action='"+$(this).data('link')+"' method='GET' target='_blank'><div class='row'>"
                +"<div class='col-6'>"
                +"<label>Data</label>"
                +"<input type='date' name='date_schedule' class='form-control'/>"
                +"</div>"
                +"<div class='col-6'>"
                +"<label>Hora</label>"
                +"<input type='text' name='time_schedule' id='in_time_schedule' class='form-control time' />"
                +"</div>"
            +"</div></form>",
        onRender:()=>{
            
            $('.time').mask('00:00');
        }
    });
    if(print.value){
        $('#form-print').submit()
    }
    
});
$(document).on('input','.time',function(){
    timerValidate($(this));
})
function timerValidate(horario){
    var x;
    var y;               
    var caracteres=horario.val().length;
    
//alert(caracteres);
if(caracteres==1){
   if(horario.val()>2){
       horario.val(null);
   }
   
}else if(caracteres==2){
   if(horario.val()>23){
       horario.val(null);
   }
}else if(caracteres==4){
    x=horario.val();
    y=x.substring(3,4);

   if(y>6){
       horario.val(x.substring(0,3));
   }
}else if(caracteres==5){
    x=horario.val();
    y=x.substring(3,5);

   if(y>59){
       horario.val(x.substring(0,3));
   }
}

}