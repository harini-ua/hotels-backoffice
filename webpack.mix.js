const mix = require('laravel-mix');
const glob = require('glob')
require('dotenv').config();

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

const sassOptions = {
    // precision: 5
};

function mixAssetsDir(query, cb) {
    (glob.sync('resources/' + query) || []).forEach(f => {
        f = f.replace(/[\\\/]+/g, '/');
        cb(f, f.replace('resources', 'public'));
    });
}

mix.copyDirectory('resources/images', 'public/images');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

// Pages stylesheets
mixAssetsDir(
    'sass/pages/**/!(_)*.scss',
    (src, dest) => mix.sass(src, dest.replace(/(\\|\/)sass(\\|\/)/, '$1css$2').replace(/\.scss$/, '.css'), sassOptions)
);

// Pages scripts
mix.js('resources/js/pages/**/*.js', 'public/js/pages')
