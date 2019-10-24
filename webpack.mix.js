const mix = require('laravel-mix');

const atImport = require('postcss-import');
// const colorFunction = require('postcss-color-function');
// const colorModFunction = require('postcss-color-mod-function');

require('laravel-mix-tailwind');
require('laravel-mix-purgecss');
require('laravel-mix-postcss-config');
require('laravel-mix-svg');
require('laravel-mix-imagemin');

mix.imagemin('resources/img/**/*', 'optimized');

mix.copyDirectory('resources/img', 'public/img');
mix.copyDirectory('resources/favicon', 'public/favicon');

mix.svg({
  class: 'icon fill-current max-w-full h-auto',
  assets: ['./resources/svg/'],
  output: './resources/js/svg.js',
});

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
    .purgeCss({
      folders: ['resources', 'public/vendor/nova']
    });
}
