import PerfectScrollbar from 'perfect-scrollbar';

/*
const ps2 = new PerfectScrollbar('.navbar', {
    wheelSpeed: 2,
    wheelPropagation: true,
    minScrollbarLength: 20
});
*/
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
function number_format (number, decimals, dec_point, thousands_sep) {
  number = number.toFixed(decimals);

  var nstr = number.toString();
  nstr += '';
  x = nstr.split('.');
  x1 = x[0];
  x2 = x.length > 1 ? dec_point + x[1] : '';
  var rgx = /(\d+)(\d{3})/;

  while (rgx.test(x1))
      x1 = x1.replace(rgx, '$1' + thousands_sep + '$2');

  return x1 + x2;
}



