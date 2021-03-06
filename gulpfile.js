var elixir = require('laravel-elixir');

// require('laravel-elixir-vue');
require('laravel-elixir-svgstore');

// Vue.config.devtools = true

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir.config.css.autoprefix.options.browsers = ['last 2 versions', 'ie >= 10'];

// elixir.config.sourcemaps = false;

elixir(function (mix) {

    // Main theme CSS file
    mix.sass('app.scss');

    // Admin theme CSS
    mix.sass('chamber-admin.scss');

    mix.copy([
        'node_modules/motion-ui/dist/motion-ui.js',
        'node_modules/what-input/what-input.js',
        'node_modules/flickity/dist/flickity.pkgd.js'
        // 'node_modules/vue-resource/dist/vue-resource.js',
        // 'node_modules/vue-router/dist/vue-router.js'
    ], 'resources/assets/js/vendor');

    mix.copy([
        'node_modules/isotope-layout/dist/isotope.pkgd.js',
        'node_modules/foundation-sites/dist/plugins'
    ], 'resources/assets/js');

    mix.copy('resources/assets/images', 'public/images');

    // mix.rollup( './resources/assets/js/navigation.js', './resources/assets/js/navigation.babel.js' );
    mix.rollup('./resources/assets/js/media-block.js', './resources/assets/js/media-block.babel.js');

    mix.scriptsIn('resources/assets/js/vendor', 'public/js/vendor.js');

    mix.scripts([
        'foundation.core.js',
        'foundation.util.mediaQuery.js',
        'foundation.util.box.js',
        'foundation.util.keyboard.js',
        'foundation.util.motion.js',
        'foundation.util.nest.js',
        'foundation.util.timerAndImageLoader.js',
        'foundation.util.touch.js',
        'foundation.util.triggers.js',
        'foundation.abide.js',
        'foundation.responsiveToggle.js',
        'foundation.reveal.js',
        'foundation.toggler.js',
        'foundation.tooltip.js',
        'foundation.dropdown.js'
    ], 'resources/assets/js/foundation.js');

    mix.scripts([
        'navigation.babel.js',
        'skip-link-focus-fix.js',
        'media-block.babel.js',
        'app.js',
        'datatables.js',
        'mlive.js',
        'scroll-scope.js'
    ], 'public/js/app.js');

    mix.scripts('modernizr.js');

    mix.scripts('customizer.js');

    mix.scripts('isotope.pkgd.js');

    mix.scripts('contact-form.js');

    mix.rollup('./resources/assets/js/foundation.js');

    mix.svgstore('resources/assets/images/icons', 'public/images/icons', 'chamber-icons.svg');
    // mix.webpack('filter.js');

    mix.browserSync({
        files: ['{lib,templates}/**/*.php', '*.php', 'public'],
        proxy: 'flintandgenesee.dev:8888',
        host: 'flintandgenesee.dev:8888'
    });

});
