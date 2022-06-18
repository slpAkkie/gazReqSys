const mix = require('laravel-mix')
const webpack = require('webpack')

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

mix.webpackConfig({
    plugins: [
        new webpack.DefinePlugin({
            __VUE_OPTIONS_API__: true,
            __VUE_PROD_DEVTOOLS__: true,
        })
    ],
})

mix.js('resources/js/app.js', 'public/js')
    // .js(['Modules/ReqSys/resources/js/ReqSys.js'], 'public/js')
    .sass('resources/scss/app.scss', 'public/css')
    .sass('Modules/ReqSys/resources/scss/ReqSys.scss', 'public/css')
    .disableNotifications()
