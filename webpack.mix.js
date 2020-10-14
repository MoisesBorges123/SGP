const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

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
    .version();
