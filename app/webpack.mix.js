const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .js('Modules/GReqSys/resources/js/GReqSys.js', 'public/js/GReqSys')
    .postCss('resources/css/app.css', 'public/css')
    .sass('resources/scss/app.scss', 'public/css')
    .sass('Modules/GReqSys/resources/scss/GReqSys.scss', 'public/css');
