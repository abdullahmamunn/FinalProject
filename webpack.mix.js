const mix = require('laravel-mix');
let minifier = require('minifier');
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

mix.js('resources/js/user/role/manage-role.js', 'public/js/user')
    .js('resources/js/user/user/manage-user.js', 'public/js/user')
    .js('resources/js/mess/meal/member/manage-member.js', 'public/js')
    .js('resources/js/mess/meal/market/market-list.js', 'public/js')
    .js('resources/js/mess/meal/meal/meal-list.js', 'public/js')
    .js('resources/js/mess/meal/balance/balance-credit-list.js', 'public/js')
    .js('resources/js/mess/meal/dashboard/meal-dashboard.js', 'public/js')
    .js('resources/js/settings/settings.js', 'public/js')
    .sass('resources/sass/master.scss', 'public/css',{
        outputStyle: 'nested'
    });

mix.then(() => {
    minifier.minify('public/css/master.css')
});