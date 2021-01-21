$(document).on('click','.btn_plus',function(){
    var value = $('#'+$(this).attr('for')).val()*1;
    value++;
    $('#'+$(this).attr('for')).val(value);
});
$(document).on('click','.btn_less',function(){
    var value = $('#'+$(this).attr('for')).val()*1;
    value--;
    if(value<0){
        value=0;
    }
    $('#'+$(this).attr('for')).val(value);
});