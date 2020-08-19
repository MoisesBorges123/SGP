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

mix.js('resources/js/certidoes/certidao-batismo/table.js', 'public/js/certidao/certidao-batismo')
    .js('resources/js/app.js', 'public/js/main')
    .sass('resources/sass/app.scss', 'public/css/main')
    /**
     * SCRIPS QUE AFETAM A PARTE DO REGISTRO DE CERTIDÕES
     */
    .sass('resources/sass/certidao/certidao-batismo/table.scss', 'public/admin/certidao-batismo/')
    .sass('resources/sass/certidao/certidao-batismo/details.scss', 'public/admin/certidao-batismo/')
    .sass('resources/sass/certidao/certidao-batismo/form.scss', 'public/admin/certidao-batismo/')
    .styles('resources/css/certidao-batismo/form-styles.css','public/admin/certidao-batismo/form-styles.css')
    .version();
