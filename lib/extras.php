<?php

namespace Chamber\Extras;

use Chamber\Setup;

/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package chamber
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function body_class($classes) {
	// Add page slug if it doesn't exist
	if (is_single() || is_page() && !is_front_page()) {
		if (!in_array(basename(get_permalink()), $classes)) {
			$classes[] = basename(get_permalink());
		}
	}

	// Add class if sidebar is active
	if (Setup\display_sidebar()) {
		$classes[] = 'has-sidebar-primary';
	}

	return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
	return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'chamber') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

/**
 * Add SVG capabilities
 */
function svg_mime_type( $mimes = [] ) {
	$mimes['svg']  = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', __NAMESPACE__ . '\\svg_mime_type' );

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
add_filter('wp_nav_menu_items', __NAMESPACE__ . '\\add_search_box_to_menu', 10, 2);

/**
 * Get the number of widgets in a sidebar and add a class to the parent container.
 *
 * @link: https://wordpress.stackexchange.com/questions/54162/get-number-of-widgets-in-sidebar
 */
function widget_indexer($params) {

	$sidebar_id = $params[0]['id'];

	if ( $sidebar_id == 'sidebar-primary' ) {

			$total_widgets = wp_get_sidebars_widgets();
			$sidebar_widgets = count($total_widgets[$sidebar_id]);

			$params[0]['before_widget'] = str_replace('class="', 'class="widget-1of' . $sidebar_widgets . ' ', $params[0]['before_widget']);
	}

	return $params;
}
add_filter('dynamic_sidebar_params', __NAMESPACE__ . '\\widget_indexer');

/**
 * Display the caption of the featured image
 * 
 * @return array
 */
function the_post_thumbnail_caption() {
	global $post;

	$thumbnail_id    = get_post_thumbnail_id($post->ID);
	$thumbnail_image = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'));

	if ($thumbnail_image && isset($thumbnail_image[0])) {
		return $thumbnail_image[0]->post_excerpt;
	}
}
add_filter('chamber/thumbnail/caption', __NAMESPACE__ . '\\the_post_thumbnail_caption');
