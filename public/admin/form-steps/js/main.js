$(function(){
    var formBatismo = $('#form-batismo');
    $("#form-total").steps({
        headerTag: "h2",
        bodyTag: "section",
        transitionEffect: "fade",
        enableAllSteps: true,
        autoFocus: true,
        transitionEffectSpeed: 500,
        titleTemplate : '<div class="title">#title#</div>',
        labels: {
            previous : 'Voltar',
            next : 'Avançar',
            finish : 'Salvar',
            current : ''
        },
    onFinished: function (event, currentIndex){
        formBatismo.submit();
    }
    });
    $("#date").datepicker({
        dateFormat: "MM - DD - yy",
        showOn: "both",
        buttonText : '<i class="zmdi zmdi-chevron-down"></i>',
    });
});
