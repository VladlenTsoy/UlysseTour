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

mix.js('resources/js/bootstrap.js', 'public/js')
    .js('resources/js/app.js', 'public/js').version()
    .js('resources/js/admin.js', 'public/js').version()
// Style
    .styles([
        'resources/css/style.css',
        'resources/css/tour.css',
        'resources/css/tours.css',
    ], 'public/css/style.css').version()
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/admin.scss', 'public/css');

mix.copy('resources/files/*.*', 'public/files');