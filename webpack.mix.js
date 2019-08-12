const mix = require('laravel-mix');

mix.js([
        // 'resources/assets/js/import/jquery.min.js',
//        'resources/assets/js/import/bootstrap.min.js',
          'resources/assets/js/main.js',
          'resources/assets/js/import/light-bootstrap-dashboard.js',
          'resources/assets/js/import/knob.js',
          // 'resources/assets/js/import/bootstrap-switch.js',
        ], 'public/js/main.js')
   .styles([
          'resources/assets/css/bootstrap.min.css',
          // 'resources/assets/css/demo.css',
          'resources/assets/css/light-bootstrap-dashboard.css',
        ], 'public/css/app.css')

mix.webpackConfig({
    resolve: {
        alias: {
          '@': path.resolve(__dirname, 'resources/assets/js'),
        }
      }
  });