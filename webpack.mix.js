const mix = require('laravel-mix');


mix
.js('resources/js/app.js', 'public/js/main')
.sass('resources/sass/app.scss', 'public/css/main')
/**
 * SCRIPS QUE AFETAM A PARTE DO REGISTRO DE CERTIDÕES
 */
//BATISMA
.sass('resources/sass/certidao/certidao-batismo/table.scss', 'public/admin/certidao-batismo/')
.sass('resources/sass/certidao/certidao-batismo/details.scss', 'public/admin/certidao-batismo/')
.sass('resources/sass/certidao/certidao-batismo/form.scss', 'public/admin/certidao-batismo/')
.styles('resources/css/certidao-batismo/form-styles.css','public/admin/certidao-batismo/form-styles.css')
.js('resources/js/certidoes/certidao-batismo/table.js', 'public/js/certidao/certidao-batismo')
//CRISMA
.sass('resources/sass/certidao/certidao-crisma/table.scss', 'public/admin/certidao-crisma/')
.sass('resources/sass/certidao/certidao-crisma/details.scss', 'public/admin/certidao-crisma/')
.sass('resources/sass/certidao/certidao-crisma/form.scss', 'public/admin/certidao-crisma/')
.styles('resources/css/certidao-crisma/form-styles.css','public/admin/certidao-crisma/form-styles.css')
.js('resources/js/certidoes/certidao-crisma/table.js', 'public/js/certidao/certidao-crisma')
//CASAMENTO
.sass('resources/sass/certidao/certidao-casamento/table.scss', 'public/admin/certidao-casamento/')
.sass('resources/sass/certidao/certidao-casamento/details.scss', 'public/admin/certidao-casamento/')
.sass('resources/sass/certidao/certidao-casamento/form.scss', 'public/admin/certidao-casamento/')
.styles('resources/css/certidao-casamento/form-styles.css','public/admin/certidao-casamento/form-styles.css')
.js('resources/js/certidoes/certidao-casamento/table.js', 'public/js/certidao/certidao-casamento')
    /**
     * SCRIPS PARA MANIPULAR LIVROS DE REGISTRO DE SACRAMENTOS
     */
    .sass('resources/sass/livros/table.scss','public/admin/livros/css/')
    .sass('resources/sass/livros/paginas/form.scss','public/admin/livros/paginas/css/')
    .sass('resources/sass/livros/paginas/table.scss','public/admin/livros/paginas/css/')
    .sass('resources/sass/livros/paginas/details.scss','public/admin/livros/paginas/css/')
    .js('resources/js/livros/table.js','public/admin/livros/js/')
    .js('resources/js/livros/paginas/details.js','public/admin/livros/paginas/js/')
    .js('resources/js/livros/paginas/form.js','public/admin/livros/paginas/js/')
    .js('resources/js/livros/paginas/table.js','public/admin/livros/paginas/js/')
    /**
     * SCRIPS PARA MANIPULAR UPLOAD DE LIVROS DE REGISTRO DE SACRAMENTOS
     */
    .sass('resources/sass/livros/uploads/form.scss','public/admin/livros/uploads/css')
    .js('resources/js/livros/uploads/form.js','public/admin/livros/uploads/js')
    /**
     * SCRIPS INTENÇÕES DE MISSA
     */
    .js('resources/js/intentions/form.js','public/admin/intentions/form.js')
    .js('resources/js/intentions/table.js','public/admin/intentions/table.js')
    .sass('resources/sass/intentions/form.scss','public/admin/intentions/')
    .sass('resources/sass/intentions/table.scss','public/admin/intentions/')
    /** 
     * SCRIPTS AGENDA DE MISSA
     * */    
    .js('resources/js/schedule_celebration/speech_recognize.js','public/admin/schedule_celebration/')
    /**
     * SCRIPTS DIZIMO
     * 
     *  */    
    .sass('resources/sass/tithe/tither/form.scss','public/admin/tithe/tither/css/')
    .js('resources/js/tithe/tither/form.js','public/admin/tithe/tither/js/')

    .sass('resources/sass/tithe/tither/table.scss','public/admin/tithe/tither/css/')
    .js('resources/js/tithe/tither/table.js','public/admin/tithe/tither/js/')

    .sass('resources/sass/tithe/devolution/table.scss','public/admin/tithe/devolution/css/')
    .js('resources/js/tithe/devolution/table.js','public/admin/tithe/devolution/js/')
    
    .sass('resources/sass/tithe/devolution/form.scss','public/admin/tithe/devolution/css/')
    .js('resources/js/tithe/devolution/form.js','public/admin/tithe/devolution/js/')
    
    /**
     * SCRIPTS CONTAGEM
     */
    .sass('resources/sass/contagem/form.scss','public/admin/contagem/css/')
    .js('resources/js/contagem/form.js','public/admin/contagem/js/')
    /**
     * SCRIPTS ESTACIONAMENTO
     */
    .sass('resources/sass/estacionamento/fluxo/table.scss','public/admin/estacionamento/fluxo/css/')
    .js('resources/js/estacionamento/fluxo/table.js','public/admin/estacionamento/fluxo/js/')

    .sass('resources/sass/estacionamento/tablePrice/form.scss','public/admin/estacionamento/table-price/css/')
    .js('resources/js/estacionamento/tablePrice/form.js','public/admin/estacionamento/table-price/js/')
    .version();
