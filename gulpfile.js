var elixir = require('laravel-elixir-svgstore');
var elixir = require('laravel-elixir');
var del = require('del');
 
// elixir.extend("remove", function(path) {
//   gulp.task("remove", function() {
//     del(path);
//   });
//   return gulp.start("remove");
// });
 
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

elixir(function(mix) {

	// Main theme CSS file
	mix.sass('app.scss');

	// Admin theme CSS
	mix.sass('chamber-admin.scss');

	mix.copy([
		'node_modules/motion-ui/dist/motion-ui.js',
		'node_modules/what-input/dist/what-input.js'
		// 'node_modules/flickity/dist/flickity.pkgd.js',

		// Fitie.js has a concatenation order problem
		// (see https://github.com/jonathantneal/fitie/issues/2#issue-156840198)
		// 'node_modules/fitie/lib/fitie.init.js',
		// 'node_modules/fitie/lib/fitie.js'
	], 'resources/assets/js/vendor');

	mix.copy('node_modules/isotope-layout/dist/isotope.pkgd.js', 'resources/assets/js');

	mix.copy([
		'node_modules/foundation-sites/dist/plugins/foundation.core.js',
		'node_modules/foundation-sites/dist/plugins/foundation.util.mediaQuery.js',
		'node_modules/foundation-sites/dist/plugins/foundation.util.box.js',
		'node_modules/foundation-sites/dist/plugins/foundation.util.keyboard.js',
		'node_modules/foundation-sites/dist/plugins/foundation.util.motion.js',
		'node_modules/foundation-sites/dist/plugins/foundation.util.nest.js',
		'node_modules/foundation-sites/dist/plugins/foundation.util.timerAndImageLoader.js',
		'node_modules/foundation-sites/dist/plugins/foundation.util.touch.js',
		'node_modules/foundation-sites/dist/plugins/foundation.util.triggers.js',
		'node_modules/foundation-sites/dist/plugins/foundation.orbit.js',
		'node_modules/foundation-sites/dist/plugins/foundation.responsiveMenu.js',
		'node_modules/foundation-sites/dist/plugins/foundation.responsiveToggle.js',
		'node_modules/foundation-sites/dist/plugins/foundation.reveal.js',
		'node_modules/foundation-sites/dist/plugins/foundation.toggler.js',
		'node_modules/foundation-sites/dist/plugins/foundation.tooltip.js'
	], 'resources/assets/js/penis');

	mix.copy('resources/assets/images', 'public/images');

	mix.scriptsIn('resources/assets/js/vendor', 'public/js/vendor.js');

	mix.scriptsIn('resources/assets/js/foundation', 'resources/assets/js/foundation.js');

	mix.scripts([
		'navigation.js',
		'skip-link-focus-fix.js',
		'app.js'
	], 'public/js/app.js');

	mix.scripts('modernizr.js');

	mix.scripts('customizer.js');

	mix.scripts('isotope.pkgd.js');

	// mix.copy([
	// 	'node_modules/flickity/dist/flickity.min.css'
	// ], 'resources/assets/css/vendor')
	// .stylesIn('resources/assets/css/vendor', './public/css/vendor.css');

	mix.svgstore('resources/assets/images/icons', 'public/images/icons', 'chamber-icons.svg');

	mix.rollup('./resources/assets/js/foundation.js');

	mix.browserSync({
		files: ['{lib,templates}/**/*.php', '*.php', 'public'],
		proxy: 'flintandgenesee.dev:8888',
		host: 'flintandgenesee.dev:8888'
	});

});