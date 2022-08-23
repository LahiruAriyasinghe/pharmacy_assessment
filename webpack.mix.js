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

    .js('resources/js/users/create.js', 'public/js/users')
    .js('resources/js/users/edit.js', 'public/js/users')

    .js('resources/js/roles/create.js', 'public/js/roles')
    .js('resources/js/roles/edit.js', 'public/js/roles')

    .js('resources/js/specialties/create.js', 'public/js/specialties')
    .js('resources/js/specialties/edit.js', 'public/js/specialties')

    .js('resources/js/otherServices/create.js', 'public/js/otherServices')
    .js('resources/js/otherServices/edit.js', 'public/js/otherServices')

    .js('resources/js/sessions/create.js', 'public/js/sessions')
    .js('resources/js/sessions/edit.js', 'public/js/sessions')

    .js('resources/js/labReports/create.js', 'public/js/labReports')
    .js('resources/js/labReports/edit.js', 'public/js/labReports')

    .js('resources/js/products/create.js', 'public/js/product')
    .js('resources/js/products/edit.js', 'public/js/product')

    .js('resources/js/stock/create.js', 'public/js/stock')
    .js('resources/js/stock/edit.js', 'public/js/stock')

    .js('resources/js/invoices/opd.js', 'public/js/invoices')
    .js('resources/js/invoices/lab.js', 'public/js/invoices')
    .js('resources/js/invoices/channeling.js', 'public/js/invoices')
    .js('resources/js/invoices/other.js', 'public/js/invoices')
    .js('resources/js/invoices/product.js', 'public/js/invoices')

    .js('resources/js/units/create.js', 'public/js/units')
    .js('resources/js/units/edit.js', 'public/js/units')

    .js('resources/js/test-data/result-categories/create.js', 'public/js/test-data/result-categories')
    .js('resources/js/test-data/result-categories/edit.js', 'public/js/test-data/result-categories')

    .js('resources/js/test-data/categories/create.js', 'public/js/test-data/categories')
    .js('resources/js/test-data/categories/edit.js', 'public/js/test-data/categories')

    .js('resources/js/test-data/create.js', 'public/js/test-data')
    .js('resources/js/test-data/edit.js', 'public/js/test-data')

    .js('resources/js/labReports/categories/create.js', 'public/js/labReports/categories')
    .js('resources/js/labReports/categories/edit.js', 'public/js/labReports/categories')

    .js('resources/js/labReports/results/edit.js', 'public/js/labReports/results')

    .js('resources/js/invoices-reverse/create.js', 'public/js/invoices-reverse')

    .sass('resources/sass/app.scss', 'public/css')

    .copyDirectory('resources/img', 'public/img');


if (mix.inProduction()) {

    mix.options({
        terser: {
            terserOptions: {
                compress: {
                    drop_console: true
                }
            }
        }
    });

    mix.version();
}