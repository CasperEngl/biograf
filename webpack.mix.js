const mix = require('laravel-mix');

const atImport = require('postcss-import');
// const colorFunction = require('postcss-color-function');
// const colorModFunction = require('postcss-color-mod-function');

require('laravel-mix-tailwind');
require('laravel-mix-purgecss');
require('laravel-mix-postcss-config');

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

mix
  .js('resources/js/app.js', 'public/js')
  .postCss('resources/css/app.css', 'public/css')
  .postCssConfig({
    plugins: [
      atImport(),
      // colorFunction({ preserveCustomProps: true }),
      // colorModFunction(),
    ],
  })
  .tailwind('./tailwind.config.js');

if (mix.inProduction()) {
  mix
    .version()
    .purgeCss();
}
