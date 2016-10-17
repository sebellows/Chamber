<?php
/**
 * Custom functions that help setup the theme.
 *
 * @package    Chamber Theme
 * @author     Sean Bellows <sean@seanbellows.com>
 * @copyright  Copyright (c) 2016, Sean Bellows
 * @link       https://github.com/sebellows/chamber
 * @license    http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Chamber\Theme\Extras;

use Chamber\Theme\Setup;
use Chamber\Theme\Sidebar;

# Adds custom classes to the array of body classes.
// add_filter('body_class', __NAMESPACE__ . '\\body_class');

# Modify the read more link text for the_excerpt()
add_filter('excerpt_more', __NAMESPACE__ . '\\custom_excerpt_more');
# Modify the read more link text for the_content()
add_filter('the_content_more_link', __NAMESPACE__ . '\\custom_content_more');

# Add SVG capabilities
add_filter( 'upload_mimes', __NAMESPACE__ . '\\svg_mime_type' );

# Add search form to nav bar
add_filter('wp_nav_menu_items', __NAMESPACE__ . '\\add_search_box_to_menu', 10, 2);

# Display the caption of the featured image
add_filter('chamber/thumbnail/caption', __NAMESPACE__ . '\\the_post_thumbnail_caption');
# Add custom image sizes attribute to enhance responsive image functionality
add_filter( 'wp_calculate_image_sizes', __NAMESPACE__.'\\content_image_sizes_attr', 10 , 2 );

# Make ACF create the correct srcset code for images added to custom fields.
# @link https://support.advancedcustomfields.com/forums/topic/wordpress-4-4-responsive-images/
add_filter( 'acf_the_content', 'wp_make_content_images_responsive' );

# Register our callback to the appropriate filter
add_filter( 'mce_buttons_2', __NAMESPACE__.'\\mce_buttons_2' );
# Attach callback to 'tiny_mce_before_init' 
add_filter( 'tiny_mce_before_init', __NAMESPACE__.'\\tiny_mce_before_init' );
# Callback function to filter the MCE settings
add_filter( 'tiny_mce_before_init', __NAMESPACE__.'\\mce_before_init_insert_formats' );  

# Add thumbnails to the RSS Widget
add_filter('the_excerpt_rss', __NAMESPACE__.'\\rss_post_thumbnail');
add_filter('the_content_feed', __NAMESPACE__.'\\rss_post_thumbnail');

# Disable Comments
# see http://codex.wordpress.org/Function_Reference/comments_open
add_filter('comments_open', '__return_false');

# Custom Gallery Styles
add_filter('use_default_gallery_style', '__return_false');

# Set up the Isotope.js archive page initial display.
add_action( 'pre_get_posts', __NAMESPACE__.'\\archive_query' );

# Register additional fields to use with Rest API
add_action( 'rest_api_init', __NAMESPACE__.'\\register_api_addon_filters' );

# Remove those damn emojis.
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

/**
 * Set up the Isotope.js archive page initial display.
 *
 * @param mixed $query WP_Query instance.
 * @return mixed
 */
function archive_query( $query ) {
	if ( $query->is_archive() && $query->is_main_query() && !is_admin() ) {
		$query->set( 'posts_per_page', 100 );
		$query->set( 'offset', 100 );
        $query->set( 'orderby', 'rand' );
    }
}

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
// function body_class($classes) {
// 	// Add page slug if it doesn't exist
// 	if (is_single() || is_page() && !is_front_page()) {
// 		if (!in_array(basename(get_permalink()), $classes)) {
// 			$classes[] = basename(get_permalink());
// 		}
// 	}

// 	// Add class of hfeed to non-singular pages.
// 	if ( ! is_singular() )
// 		$classes[] = 'hfeed';

// 	// Add class if sidebar is active
// 	if (Sidebar::display())
// 		$classes[] = 'has-sidebar-primary';

// 	// Add class if we're viewing the Customizer for easier styling of theme options.
// 	if ( is_customize_preview() )
// 		$classes[] = 'customizer-is-active';

// 	// Add class on front page.
// 	if ( is_front_page() && 'posts' !== get_option( 'show_on_front' ) )
// 		$classes[] = 'front-page';

// 	// Add class for one or two column page layouts.
// 	if ( is_page() && ! is_front_page() && ! is_home() )
// 		$classes[] = 'one-column' === get_theme_mod( 'page_options' ) ? 'page-one-column' : 'page-two-column';

// 	// Merge base contextual classes with $classes.
// 	$classes = array_merge( $classes, hybrid_get_context() );

// 	return array_map( 'esc_attr', $classes );

// 	// return $classes;
// }

/**
 * Modify the read more link text for the_excerpt()
 */
function custom_excerpt_more($more) {
	global $post;

	return '<a class="readmore" href="' . get_permalink($post->ID) . '">Read More ' . '<svg class="icon" m-Icon="xsmall" role="presentation" viewBox="0 0 32 32"><use xlink:href="#icon-fat-arrow"></use></svg></a>';
}

/**
 * Modify the read more link text for the_content()
 */
function custom_content_more() {
	return '<a class="readmore" href="' . get_permalink() . '">Read More ' . '<svg class="icon" m-Icon="xsmall" role="presentation" viewBox="0 0 32 32"><use xlink:href="#icon-fat-arrow"></use></svg></a>';
}

/**
 * Add SVG capabilities
 */
function svg_mime_type( $mimes = [] ) {
	$mimes['svg']  = 'image/svg+xml';
	return $mimes;
}

/**
 * Add search form to nav bar
 *
 * @link https://wordpress.org/support/topic/add-search-box-to-nav-menu
 */
function add_search_box_to_menu( $items, $args ) {
	if( $args->theme_location == 'primary' )
		return $items.get_search_form();

	return $items;
}

/**
 * Display the caption of the featured image
 * 
 * @return array
 */
function the_post_thumbnail_caption() {
	global $post;

	$thumbnail_id    = get_post_thumbnail_id($post->ID);
	$thumbnail_image = get_posts( [ 'p' => $thumbnail_id, 'post_type' => 'attachment' ] );

	if ($thumbnail_image && isset($thumbnail_image[0])) {
		return $thumbnail_image[0]->post_excerpt;
	}
}

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

	960 <= $width && $sizes = '(max-width: ' . $width . 'px) 100vw, ' . $width . 'px';

	if (get_page_template_slug() === 'template-landing.php' || 'single.php') {
		960 > $width && $sizes = '(max-width: ' . $width . 'px) 100vw, ' . $width . 'px';
	} else {
		960 > $width && 600 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
		640 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
	}

	return $sizes;
}

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

/**
 * Adds the <body> class to the visual editor.
 *
 * @param  array  $settings
 * @return array
 */
function tiny_mce_before_init( $settings ) {

	$settings['body_class'] = join( ' ', get_body_class() );
	// $settings[] = hybrid_attr_body();

	return $settings;
}

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
			'title' => '2-Column',  
			'block' => 'div',
			'classes' => 'column-text-2',
			'wrapper' => true
		],  
		[  
			'title' => '2-Column Ruled',  
			'block' => 'div',
			'classes' => 'column-text-2--ruled',
			'wrapper' => true
		],  
		[  
			'title' => 'Span Columns',
			'block' => 'div',
			'classes' => 'column-text-2--span-all',
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


/**
 * Register the Rest API.
 *
 * @return str
 */
function register_api_addon_filters() {
	if ( function_exists('register_api_field') ) {
		register_api_field( 'post',
	        'chamber/api/addon/fields',
	        array(
	            'get_callback'    => __NAMESPACE__.'\\get_api_addon_fields',
	            'update_callback' => null,
	            'schema'          => null,
	        )
	    );
	}
}

/**
 * Add additional return fields for Rest API.
 *
 * @return str
 */
function get_api_addon_fields( $object, $field_name, $request ) {
	if ( isset($object['featured_media']) ) {
		$image_id = (int) $object['featured_media'];
		$img = wp_get_attachment_image_src( $object['featured_media'], 'card-small' );
		$image_src = $img['0'];
	} else {
		$image_src = null;
	}

	$addons = array();
	$addons['image_src'] = $image_src;
	$addons['tag_list'] = tag_list( $object['id'], true );
	$addons['category_list'] = category_list( $object['id'], true );
	$addons['date_ago'] = human_time_diff(get_the_time('U', $object['id']), current_time('timestamp')) .  ' '.__('ago', 'boron');
	$addons['comments'] = comment_count( $object['id'] );
	$addons['post_template'] = get_single_post( $object['id'] );
	$addons['post_side_template'] = get_single_post_side( $object['id'] );
	$addons['post_classes'] = implode( ' ', get_post_class('', $object['id'] ) );

    return $addons;
}


/**
 * Returns a view for a single post.
 *
 * @return str
 */
function get_single_post( $post_id ) {
	$output = '';
	// Check if thumbnail exists
	$img = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full-width' );
	if ( !empty($img) ) {
		$output .= '<div class="open-post-image"><img src="'.$img['0'].'" class="single-open-post-image" alt="Post with image"></div>';
	}
	$output .= '<h1>' . get_the_title( $post_id ) . '</h1>';
	$content_post = get_post( $post_id );
	$content = $content_post->post_content;
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]&gt;', $content);
	$content = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $content);
	// Sets the post content
	if ( post_password_required( $post_id ) ) {
		$output .= get_the_password_form( $post_id );
	} else {
		$output .= $content;
		$output .= get_single_post_pagination();
	}
	global $withcomments;
	$withcomments = 1;
	ob_start();
	comments_template();
	$comment_form = ob_get_clean();
	$comment_form = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $comment_form);
	$output .= '<div class="clearfix"></div><div class="comments-container">' . $comment_form . '</div>';
	return $output;
}

/**
 * Return the view for single post pagination.
 *
 * @return str
 */
function get_single_post_pagination( $post_id = '' ) {
	$output = '<nav class="nav-single blog">';
		$prev_post = get_previous_post();
		$next_post = get_next_post();
		if (!empty( $prev_post )) {
			$output .= '
			<div class="nav_button left">
				<h3 class="prev-post-text">'. __('Previous post', 'boron').'</h3>
				<div class="prev-post-link">
					<a href="'. get_permalink( $prev_post->ID ).'" class="prev_blog_post icon-left">'.get_the_title( $prev_post->ID ).'</a>
				</div>
			</div>';
		}
		if (!empty( $next_post )) {
			$output .= '
			<div class="nav_button right">
				<h3 class="next-post-text">'.__('Next post', 'boron').'</h3>
				<div class="next-post-link">
					<a href="'. get_permalink( $next_post->ID ).'" class="next_blog_post icon-right">'. get_the_title( $next_post->ID ).'</a>
				</div>
			</div>';
		}
		$output .= '
		<div class="clearfix"></div>
	</nav>';
	return $output;
}


/**
 * Returns list of categories for Boron 1.0.
 *
 * @return string
 */
function category_list( $post_id, $return = false ) {
	$category_list = get_the_category_list( ', ', '', $post_id );
	$entry_utility = '';
	if ( $category_list ) {
		$entry_utility .= '
		<div class="category-link">
			<svg class="icon" role="presentation" viewbox="0 0 24 24"><use xlink:href="#icon-folder"></use></svg>' . $category_list . '
		</div>';
	}
	if ( $return ) {
		return $entry_utility;
	} else {
		echo $entry_utility;
	}
}

/**
 * Returns list of categories with links for Boron 1.0.
 *
 * @return string
 */
function category_link_list( $post_id, $return = false ) {
	$category_list = get_the_category_list( ', ', '', $post_id );
	$entry_utility = '';
	if ( $category_list ) {
		$entry_utility .= '
		<div class="category-link">
			<span class="category-text">' . __('Categories', 'boron') . '</span>' . $category_list . '
		</div>';
	}
	if ( $return ) {
		return $entry_utility;
	} else {
		echo $entry_utility;
	}
}
