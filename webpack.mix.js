let mix = require('laravel-mix');

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

mix.autoload({
  jquery: ['$', 'window.jQuery', 'jQuery']
});

/*mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');*/
mix.js('resources/assets/js/app.js', 'public/js')
  .js('resources/assets/client/js/index.js',
    'public/themes/eleganza/js/app.bundle.js')
  .js('resources/assets/client/js/instashop.js',
    'public/themes/eleganza/js/instashop.js');

mix.sass('resources/assets/client/scss/main.scss',
  'public/themes/eleganza/css/instashop.css');
