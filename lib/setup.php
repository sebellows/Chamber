<?php

namespace Chamber\Setup;

use Chamber\Config;
use Chamber\Assets;

/**
 * Theme setup
 */
function setup() {
	// Enable features from Soil when plugin is activated
	// https://roots.io/plugins/soil/
	add_theme_support('soil-clean-up');
	add_theme_support('soil-nav-walker');
	add_theme_support('soil-nice-search');
	add_theme_support('soil-jquery-cdn');
	add_theme_support('soil-relative-urls');
	add_theme_support('soil-js-to-footer');

	// Enable plugins to manage the document title
	// http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
	add_theme_support('title-tag');

	// Register wp_nav_menu() menus
	// http://codex.wordpress.org/Function_Reference/register_nav_menus
	register_nav_menus([
		'site_navigation'           => __('Site Navigation Menu', 'chamber'),
		'quick_links'               => __('Quick Links Menu', 'chamber'),
		'social_links'              => __('Social Links Menu', 'chamber'),
		'site_information'          => __('Site Information Menu', 'chamber'),
		'about_menu'                => __('About Menu', 'chamber'),
		'news_menu'                 => __('News Menu', 'chamber'),
		'cvb_menu'                  => __('CVB Menu', 'chamber'),
		'member_services_menu'      => __('Member Services Menu', 'chamber'),
		'economic_development_menu' => __('Development Menu', 'chamber'),
		'education_training_menu'   => __('Education Training Menu', 'chamber'),
		'shared_services_menu'      => __('Shared Services Menu', 'chamber')
	]);

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

/**
 * Register sidebars
 */
function widgets_init() {
	// Front Page
	register_sidebar([
		'name'          => __('Primary Sidebar', 'chamber'),
		'id'            => 'sidebar-primary',
		'before_widget' => '<section class="widget %1$s %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>'
	]);

	// Share this Post
	register_sidebar([
		'name'          => __('Post Footer Sidebar', 'chamber'),
		'id'            => 'sidebar-post-footer',
		'before_widget' => '<section class="widget %1$s %2$s" role="complementary">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>'
	]);

	register_sidebar([
		'name'          => __('Footer Sidebar', 'chamber'),
		'id'            => 'sidebar-footer',
		'before_widget' => '<div class="widget %1$s %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>'
	]);

	register_sidebar([
		'name'          => __('Sortable Menu', 'chamber'),
		'id'            => 'sidebar-isotope-menu',
		'before_widget' => '<menu class="isotope-widget %1$s %2$s">',
		'after_widget'  => '</menu>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>'
	]);

	// ------------------------------------------------------
	// SECTION SIDEBARS
	// ------------------------------------------------------

	// About Sidebar
	register_sidebar([
		'name'          => __('About Sidebar', 'chamber'),
		'id'            => 'sidebar-about',
		'before_widget' => '<section class="widget %1$s %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>'
	]);

	// News Room Sidebar
	register_sidebar([
		'name'          => __('News Room Sidebar', 'chamber'),
		'id'            => 'sidebar-news',
		'before_widget' => '<section class="widget %1$s %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>'
	]);

	// CVB Sidebar
	register_sidebar([
		'name'          => __('CVB Sidebar', 'chamber'),
		'id'            => 'sidebar-cvb',
		'before_widget' => '<section class="widget %1$s %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>'
	]);

	// Economic Development Sidebar
	register_sidebar([
		'name'          => __('Development Sidebar', 'chamber'),
		'id'            => 'sidebar-economic-development',
		'before_widget' => '<section class="widget %1$s %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>'
	]);

	// Education and Training Sidebar
	register_sidebar([
		'name'          => __('Education & Training Sidebar', 'chamber'),
		'id'            => 'sidebar-education-training',
		'before_widget' => '<section class="widget %1$s %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>'
	]);

	// Member Services Sidebar
	register_sidebar([
		'name'          => __('Member Services Sidebar', 'chamber'),
		'id'            => 'sidebar-member-services',
		'before_widget' => '<section class="widget %1$s %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>'
	]);

	// Shared Services Sidebar
	register_sidebar([
		'name'          => __('Shared Services Sidebar', 'chamber'),
		'id'            => 'sidebar-shared-services',
		'before_widget' => '<section class="widget %1$s %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>'
	]);
}
add_action('widgets_init', __NAMESPACE__ . '\\widgets_init');

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
		is_front_page(),
		is_single(),
		is_page_template('landing-page.php'),
		is_page_template('app.php')
	]);

	return apply_filters('chamber/display_sidebar', $display);
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
	wp_enqueue_style('chamber/css', get_template_directory_uri() . '/public/css/app.css');
	wp_enqueue_style('chamber/vendor/css', get_template_directory_uri() . '/public/css/vendor.css');

	if (is_single() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
	// wp_register_script('googlemaps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyAq5p4b7K-qhSlhT-QTckh_qLE8RiYrZdo');
	
	if (is_archive()) {
		wp_enqueue_script('chamber/js/isotope', get_template_directory_uri() . '/public/js/isotope.pkgd.js');
	}

	wp_enqueue_script('chamber/js/modernizr', get_template_directory_uri() . '/public/js/modernizr.js');
	wp_enqueue_script('chamber/foundation/js', get_template_directory_uri() . '/public/js/foundation.js', ['jquery'], null, true);
	wp_enqueue_script('chamber/vendor/js', get_template_directory_uri() . '/public/js/vendor.js', ['jquery'], null, true);
	wp_enqueue_script('chamber/js', get_template_directory_uri() . '/public/js/app.js', ['jquery'], null, true);
	// wp_enqueue_script('googlemaps');
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\assets', 100);

/**
 * Enqueue custom styles in the WordPress admin, excluding edit.php.
 *
 * @param int $hook Hook suffix for the current admin page.
 */
function enqueue_admin_script() {
    wp_register_style( 'chamber/admin/css', get_template_directory_uri() . '/public/css/chamber-admin.css');
    wp_enqueue_style( 'chamber/admin/css' );
}
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\enqueue_admin_script' );

/**
 * Google API Key for adding Google Maps in ACF Pro
 */
if (class_exists('acf')) {
	function acf_init() {

	   acf_update_setting('google_api_key', 'AIzaSyAS0yll51lLq5yVbqysc6gtKExyIKdURzE');

	}
	add_action('acf/init', __NAMESPACE__ . '\\acf_init');
}

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images
 *
 * @link https://github.com/WordPress/twentysixteen/blob/master/functions.php
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	840 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px';

	if (get_page_template_slug() === 'template-landing.php' || 'single.php') {
		840 > $width && $sizes = '(max-width: ' . $width . 'px) 100vw, ' . $width . 'px';
	} else {
		840 > $width && 600 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
		600 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', __NAMESPACE__.'\\content_image_sizes_attr', 10 , 2 );

/**
 * Make ACF create the correct srcset code for images added to custom fields.
 * 
 * @link https://support.advancedcustomfields.com/forums/topic/wordpress-4-4-responsive-images/
 */
add_filter( 'acf_the_content', 'wp_make_content_images_responsive' );

/**
 * Callback function to insert 'styleselect' into the $buttons array
 *
 * @link http://alisothegeek.com/2011/05/tinymce-styles-dropdown-wordpress-visual-
 *
 * @param  object(s) $buttons
 * @return object(s) $buttons
 */
function mce_buttons_2( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}
// Register our callback to the appropriate filter
add_filter( 'mce_buttons_2', __NAMESPACE__.'\\mce_buttons_2' );

/**
 * Callback function to filter the MCE settings
 *
 * @link http://alisothegeek.com/2011/05/tinymce-styles-dropdown-wordpress-visual-
 *
 * @param  array $init_array
 * @return array
 */
function mce_before_init_insert_formats( $init_array ) {  
	// Define the style_formats array
	$style_formats = [
		// Each array child is a format with it's own settings
		[  
			'title' => 'Inspire Blockquote',
			'classes' => 'intro-blockquote',
			'block' => 'blockquote',  
			'wrapper' => true
		],  
		[  
			'title' => 'Cite',  
			'inline' => 'cite'
		],
		[  
			'title' => 'Button',  
			'selector' => 'a',  
			'classes' => 'button'
		],
		[  
			'title' => 'Button Alt',  
			'selector' => 'a',  
			'classes' => 'alt button'
		],
		[  
			'title' => 'Button Outline',  
			'selector' => 'a',  
			'classes' => 'hollow button'
		],
		[  
			'title' => 'Button Reverse Outline',  
			'selector' => 'a',  
			'classes' => 'reverse hollow button'
		],
		[  
			'title' => 'Button Flat',  
			'selector' => 'a',  
			'classes' => 'flat button'
		]
	];  
	// Insert the array, JSON ENCODED, into 'style_formats'
	$init_array['style_formats'] = json_encode( $style_formats );  
	
	return $init_array;  
	
} 
// Attach callback to 'tiny_mce_before_init' 
add_filter( 'tiny_mce_before_init', __NAMESPACE__.'\\mce_before_init_insert_formats' );  

/**
 * Add thumbnails to the RSS Widget
 * 
 * @param  array $content
 * @return array
 */
function rss_post_thumbnail($content) {
	global $post;

	if( has_post_thumbnail($post->ID) ) {
		$content = '<div class="thumbnail">' . get_the_post_thumbnail($post->ID, 'thumbnail') .
		'</div>' . '<div class="list-content">' . get_the_content() . '</div>';
	}
	return $content;
}
add_filter('the_excerpt_rss', __NAMESPACE__.'\\rss_post_thumbnail');
add_filter('the_content_feed', __NAMESPACE__.'\\rss_post_thumbnail');
