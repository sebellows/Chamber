<?php

namespace Chamber\Theme\Jetpack;

/**
 * Jetpack Compatibility File.
 *
 * @link https://jetpack.com/
 *
 * @package chamber
 */

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.com/support/infinite-scroll/
 * See: https://jetpack.com/support/responsive-videos/
 */
function jetpack_setup() {
	// Add theme support for Infinite Scroll.
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => __NAMESPACE__ . '\\infinite_scroll_render',
		'footer'    => 'page',
	) );

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\\jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		if ( is_search() ) :
			get_template_part( 'templates/content', 'search' );
		else :
			get_template_part( 'templates/content', get_post_format() );
		endif;
	}
}
// add_filter( 'chamber/infinite/scroll', __NAMESPACE__ . '\\jetpack_setup' );
