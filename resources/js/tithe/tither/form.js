//@ts-ignore
window.Vue = require ('vue');
import {mask} from 'vue-the-mask'

$(document).on('click','#search_cep', async function(){    
    $('#icon_busca_cep').addClass('fa fa-spinner fa-pulse fa-fw');
    $('#icon_busca_cep').removeClass('fas fa-search');
    let form = new FormData();
   //@ts-ignore
    form.append('cep',$('#cep').val());
    var endereco =  await fetch( 
        $(this).data('url'),{
        method:'POST',
        credentials:'same-origin',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'
        },
        body:form,
    }).then((result)=>{
        
        if(result.ok){
            $('#icon_busca_cep').addClass('fas fa-search');
            $('#icon_busca_cep').removeClass('fa fa-spinner fa-pulse fa-fw');
            return result.json();
        }else{
            return false            
        }
    }).catch(err => {
        // Do something for an error here
        console.log("Error Reading data " + err);
    });
    $('#street').val(endereco.logradouro).attr('readonly',true).addClass('block');
    $('#neighborood').val(endereco.bairro).attr('readonly',true).addClass('block');
    $('#city').val(endereco.cidade).attr('readonly',true).addClass('block');
    $('#state').val(endereco.nome_estado).attr('readonly',true).addClass('block');
    $('#complement').val(endereco.complemento);
    $('#ibge').val(endereco.ibge);
    $('#dd_local').val(endereco.dd_local);
    
    
});
const phone = new Vue({
    el: '#phone',
    directives: {mask},
});
const cep = new Vue({
    el: '#cep',
    directives: {mask},
});
