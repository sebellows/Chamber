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

use Chamber\Theme\Config;
use Chamber\Theme\Assets;
use Chamber\Theme\Menu;
use Chamber\Theme\Sidebar;

/**
 * Theme setup
 */
function setup() {
	// https://roots.io/plugins/soil/
	add_theme_support('chamber-clean-up');
	add_theme_support('chamber-nav-walker');
	add_theme_support('chamber-nice-search');
	add_theme_support('chamber-jquery-cdn');
	add_theme_support('chamber-relative-urls');

	// Chamber-CMS plugin supports Blade templates
	add_theme_support('blade-templates');

	/**
	 * Moves all scripts to wp_footer
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

	Menu::register_nav_menus();

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
		'link',
		'quote',
		'status',
		'video'
	]);

	// Enable HTML5 markup support
	// http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
	add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

	// Use main stylesheet for visual editor
	// To add custom styles edit /assets/styles/layouts/_tinymce.scss
	add_editor_style( [ Assets\asset_path('css/app.css'), __NAMESPACE__ . '\\fonts_url' ] );
}
add_action('after_setup_theme', __NAMESPACE__ . '\\setup');

Sidebar::init();


/**
 * Determine which pages should NOT display the sidebar
 */
function display_sidebar() {
	static $display;

	isset($display) || $display = !in_array(true, [
		// The sidebar will NOT be displayed if ANY of the following return true.
		// @link https://codex.wordpress.org/Conditional_Tags
		is_archive(),
		is_404(),
		is_home(),
		is_single(),
		is_page_template('app.php')
	]);

	return apply_filters( 'chamber/sidebar/display', $display );
}

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
	// wp_register_script('googlemaps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyAq5p4b7K-qhSlhT-QTckh_qLE8RiYrZdo');
	
	if (is_archive()) {
		wp_enqueue_script('chamber/theme/js/isotope', get_template_directory_uri() . '/public/js/isotope.pkgd.js');
	}

	wp_enqueue_script('chamber/theme/js/modernizr', get_template_directory_uri() . '/public/js/modernizr.js');
	wp_enqueue_script('chamber/theme/foundation/js', get_template_directory_uri() . '/public/js/foundation.js', ['jquery'], null, true);
	wp_enqueue_script('chamber/theme/vendor/js', get_template_directory_uri() . '/public/js/vendor.js', ['jquery'], null, true);
	wp_enqueue_script('chamber/theme/js', get_template_directory_uri() . '/public/js/app.js', ['jquery'], null, true);
	// wp_enqueue_script('googlemaps');
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
