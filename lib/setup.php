<?php
/**
 * Sets up custom filters and actions for the theme, as well as configures 
 * sidebars, menus, images, scripts, and other assets.
 * 
 * @package    Chamber Theme
 * @author     Sean Bellows <sean@seanbellows.com>
 * @copyright  Copyright (c) 2016, Sean Bellows
 * @link       https://github.com/sebellows/chamber
 * @license    http://www.gnu.org/licenses/gpl-3.0.html
 */
namespace Chamber\Theme\Setup;

use Chamber\Theme\Helper;
use Chamber\Theme\Config;
use Chamber\Theme\Assets;
use Chamber\Theme\Extras;
use Chamber\Theme\Menu;
use Chamber\Theme\API;
use Chamber\Theme\Sidebar;
use Hybrid;

// Set up the Hybrid Core framework.
require_once( trailingslashit( get_template_directory() ) . 'lib/hybrid-core/hybrid.php' );
new Hybrid();

add_action('after_setup_theme', __NAMESPACE__ . '\\setup');

/**
 * Theme setup
 */
function setup() {

	/**
	 * Required: include TGM.
	 */
	// require_once( trailingslashit( get_template_directory() ) . 'lib/class-tgm-plugin-activation.php' );

	/**
	 * Originally came with Soil plugin by roots.io, but Composer had to be nixed 
	 * due to issues w/ no qualified person in organization with required technical skills.
	 */
	add_theme_support('chamber-clean-up');
	add_theme_support('chamber-nav-walker');
	add_theme_support('chamber-nice-search');
	add_theme_support('chamber-jquery-cdn');
	add_theme_support('chamber-relative-urls');

	add_theme_support( 'hybrid-core-template-hierarchy' );
	add_theme_support( 'get-the-image' );
	add_theme_support( 'breadcrumb-trail' );
	add_theme_support( 'cleaner-gallery' );

	/**
	 * Chamber-CMS plugin supports Blade templating language
	 */
	add_theme_support('blade-templates');

	/**
	 * Moves all scripts to wp_footer.
	 *
	 * Note: also from Soil plugin by roots.io
	 */
	function js_to_footer() {
	  remove_action('wp_head', 'wp_print_scripts');
	  remove_action('wp_head', 'wp_print_head_scripts', 9);
	  remove_action('wp_head', 'wp_enqueue_scripts', 1);
	}
	add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\js_to_footer');

	// Enable plugins to manage the document title
	// http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
	add_theme_support('title-tag');

	(new Menu)->register();

	// Enable post thumbnails
	// http://codex.wordpress.org/Post_Thumbnails
	// http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
	// http://codex.wordpress.org/Function_Reference/add_image_size
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size( 1024, '', false ); // ~4:3, max-height of 768

	// Update the `medium_large` image size set by WP
	update_option( 'medium_large', 960, '', false );

	// Used for: small screen duplo blocks, galleries, gallery stripes
	add_image_size( 'vignette', 240, 240, true ); // 1:1

	// Used for: small screen duplo blocks, galleries, gallery stripes
	add_image_size( 'small', 480, 480, false ); // 1:1

	// Used for: single-block duplo, dynamic whitesheet
	add_image_size( 'fullwidth', 1600, '', false ); // ~3:1 (Panorama) | ~12:5 (35mm 1970+, Blu-ray 1920x800)

	//// Module-specific sizes
	// Used for: Isotope/Masonry/cards on small devices
	add_image_size( 'card-small', 360, 240, true ); // 3:2

	// Used for: Isotope/Masonry/cards on larger devices
	add_image_size( 'card-large', 480, 360, true ); // 3:2

	// Enable post formats
	// http://codex.wordpress.org/Post_Formats
	add_theme_support('post-formats', [
		'aside',
		'audio',
		'gallery',
		'image',
		'quote',
		'video'
	]);

	// Enable HTML5 markup support
	// http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
	add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

	// Use main stylesheet for visual editor
	// To add custom styles edit /assets/styles/layouts/_tinymce.scss
	add_editor_style( [ Assets\asset_path('css/app.css'), __NAMESPACE__ . '\\fonts_url' ] );
}

Sidebar::init();

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Seventeen 1.0
 */
function javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', __NAMESPACE__.'\\javascript_detection', 0 );

/**
 * Register Google fonts.
 *
 * @return string Google fonts URL for the theme.
 */
function fonts_url() {
	$fonts_url = '';
	$fonts     = [];

	$fonts[] = 'Roboto:400italic,700italic,400,700';
	$fonts[] = 'Roboto Slab:400,700';

	$fonts_url = add_query_arg(
		[ 'family' => urlencode( implode( '|', $fonts ) ) ],
		'https://fonts.googleapis.com/css'
	);

	return $fonts_url;
}

/**
 * UM-Flint assets
 */
function assets() {
	wp_enqueue_style( __NAMESPACE__ . '\\fonts_url', fonts_url(), [], null );
	wp_enqueue_style('chamber/theme/css', get_template_directory_uri() . '/public/css/app.css');
	wp_enqueue_style('chamber/theme/vendor/css', get_template_directory_uri() . '/public/css/vendor.css');

	if (is_single() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

	if (is_archive()) {
		wp_enqueue_script('chamber/theme/js/isotope', get_template_directory_uri() . '/public/js/isotope.pkgd.js');
	}

	wp_enqueue_script('chamber/theme/js/modernizr', get_template_directory_uri() . '/public/js/modernizr.js');
	wp_enqueue_script('chamber/theme/js/foundation', get_template_directory_uri() . '/public/js/foundation.js', ['jquery'], null, true);
	wp_enqueue_script('chamber/theme/js/vendor', get_template_directory_uri() . '/public/js/vendor.js', ['jquery'], null, true);
	wp_enqueue_script('chamber/theme/js/app', get_template_directory_uri() . '/public/js/app.js', ['jquery'], null, true);

	// if (is_page_template('app.php')) {
	// 	wp_enqueue_script('chamber/theme/js/datagrid', get_template_directory_uri() . '/public/js/data-grid.js', ['jquery'], null, true);
	// }
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\assets', 100);

/**
 * Enqueue custom styles in the WordPress admin, excluding edit.php.
 *
 * @param int $hook Hook suffix for the current admin page.
 */
function enqueue_admin_script() {
    wp_register_style( 'chamber/theme/admin/css', get_template_directory_uri() . '/public/css/chamber-admin.css');
    wp_enqueue_style( 'chamber/theme/admin/css' );
}
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\enqueue_admin_script' );
