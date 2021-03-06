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

mix.js('resources/assets/js/app.js', 'public/js')
mix.js('resources/assets/js/profile.js', 'public/js')
mix.js('resources/assets/js/welcome.js', 'public/js')
mix.js('resources/assets/js/start.js', 'public/js')
mix.js('resources/assets/js/searchJobs.js', 'public/js')
mix.js('resources/assets/js/group.js', 'public/js')
mix.js('resources/assets/js/groupIndex.js', 'public/js')
mix.js('resources/assets/js/search.js', 'public/js')
mix.js('resources/assets/js/notifi.js', 'public/js')
mix.js('resources/assets/js/friends.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
   .sass('resources/assets/sass/welcome.scss', 'public/css');
