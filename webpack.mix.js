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

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');


//mix.js('resources/assets/js/app.js', 'public/js');

///////////////////////////////////////////////
//mix.js('resources/assets/js/app.js', 'public/assets/js').autoload({ jquery: ['$', 'window.jQuery', 'jQuery'] });
/////////////


/*
const webpack = require('webpack');

//...
plugins: [
    new webpack.ProvidePlugin({
        $: 'jquery',
        jQuery: 'jquery',
        'window.jQuery': 'jquery'
    }),
],
//...
*/
