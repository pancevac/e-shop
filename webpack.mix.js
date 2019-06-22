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

// Admin side
mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .copy('resources/js/dist/css/style.min.css', 'public/css/style.min.css');

// Client side
mix.js('resources/client/scripts/main.js', 'public/client/js')
  .sass('resources/client/styles/scss/main.scss', 'public/client/css')
  .sass('resources/client/styles/scss/bootstrap.scss', 'public/client/css');

mix.browserSync('http://localhost:8000');

// Added jquery selector support
mix.webpackConfig(webpack => {
  return {
    plugins: [
      new webpack.ProvidePlugin({
        $: 'jquery',
        jQuery: 'jquery',
        'window.jQuery': 'jquery',
      })
    ]
  };
});
