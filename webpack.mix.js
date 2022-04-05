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

function mixAssetsDir(query, cb) {
    (glob.sync('resources/' + query) || []).forEach(f => {
        f = f.replace(/[\\\/]+/g, '/');
        cb(f, f.replace('resources', 'public'));
    });
}

// Other resources
mix.copyDirectory('resources/images', 'public/images');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

// Stylesheets
mixAssetsDir(
    'sass/pages/**/!(_)*.scss',
    (src, dest) => mix.sass(src, dest.replace(/(\\|\/)sass(\\|\/)/, '$1css$2').replace(/\.scss$/, '.css'), {})
);

// Scripts
mixAssetsDir('js/pages/**/*.js', (src, dest) => mix.scripts(src, dest, {}));
mixAssetsDir('js/scripts/**/*.js', (src, dest) => mix.scripts(src, dest, {}));

