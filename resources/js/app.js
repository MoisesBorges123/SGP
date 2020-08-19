import PerfectScrollbar from 'perfect-scrollbar';


const ps2 = new PerfectScrollbar('.navbar', {
    wheelSpeed: 2,
    wheelPropagation: true,
    minScrollbarLength: 20
});

async function notificacao_certidao(url,notificacao){
    var form = new FormData();
    form.append('texto',notificacao)
    fetch(url,{
      method:'POST',
      headers:{

      },
      credentials:'same-origin',
      body:form

    }).then((result)=>{
      if(result.ok){
        return result.json();
      }else{
        return false;
      }
    });
}


