<?php

namespace Chamber\Theme\PostAPI;

// Add various fields to the JSON output
function register_fields() {
	// Add Featured Image
	register_api_field( 'post',
		'featured_image_src',
		[
			'get_callback'    => __NAMESPACE__.'\\get_image_src',
			'update_callback' => null,
			'schema'      => null
		]
	);
}

function get_image_src( $object, $field_name, $request ) {
	$feat_img_array = wp_get_attachment_image_src( $object[ 'featured_image' ], 'thumbnail', true );
	return $feat_img_array[0];
}

add_action( 'rest_api_init', __NAMESPACE__.'\\register_fields');


// Hook in all the important things
function scripts() {
	if( is_single() && is_main_query() ) {
		wp_enqueue_script( 'chamber/theme/post/api', get_template_directory_uri( __FILE__ ) . '/public/js/chamber-theme-api.ajax.js', ['jquery'], '0.1', true );

		// Get the current post ID
		global $post;
		$post_id = $post->ID;

		// Use wp_localize_script to pass values to gofurther.ajax.js
		wp_localize_script( 'chamber/theme/post/api', 'postdata',
			[
				'post_id' => $post_id,
				'json_url' => get_json_query()
			]
		);

	}
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__.'\\scripts' );


/**
 * Create JSON Route for the WP-API:
 * - Get current post ID
 * - Get IDs of current categories
 * - Create arguments array for categories and posts-per-page
 * - Create the Route
 */
function get_json_query() {
	// Set up the query variables for category IDs and posts per page
	$args = [
		'per_page' => 10,
		'page'     => 2
	];

	// Stitch everything together in a URL
	$url = add_query_arg( $args, rest_url( 'wp/v2/posts') );

	return $url;

}

// Base HTML to be added to the bottom of a post
function baseline_html() {
	// Set up container etc
	$baseline  = '<section id="more-posts" class="more-posts">';
	$baseline .= '<a href="#" class="get-more-posts">See More Stories</a>';
	$baseline .= '<div class="ajax-loader"><svg id="spinner" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><title>spinner</title><path d="M12 4c0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.209-1.791 4-4 4s-4-1.791-4-4zM20.485 7.515c0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.209-1.791 4-4 4s-4-1.791-4-4zM26 16c0-1.105 0.895-2 2-2s2 0.895 2 2c0 1.105-0.895 2-2 2s-2-0.895-2-2zM22.485 24.485c0-1.105 0.895-2 2-2s2 0.895 2 2c0 1.105-0.895 2-2 2s-2-0.895-2-2zM14 28c0 0 0 0 0 0 0-1.105 0.895-2 2-2s2 0.895 2 2c0 0 0 0 0 0 0 1.105-0.895 2-2 2s-2-0.895-2-2zM5.515 24.485c0 0 0 0 0 0 0-1.105 0.895-2 2-2s2 0.895 2 2c0 0 0 0 0 0 0 1.105-0.895 2-2 2s-2-0.895-2-2zM4.515 7.515c0 0 0 0 0 0 0-1.657 1.343-3 3-3s3 1.343 3 3c0 0 0 0 0 0 0 1.657-1.343 3-3 3s-3-1.343-3-3zM1.75 16c0-1.243 1.007-2.25 2.25-2.25s2.25 1.007 2.25 2.25c0 1.243-1.007 2.25-2.25 2.25s-2.25-1.007-2.25-2.25z"></path></svg></div>';
	$baseline .= '</section><!-- .more-posts -->';

	return $baseline;
}

// Bootstrap this whole thing onto the bottom of single posts
function display($content){
	if( is_home() && is_main_query() ) {
			$content .= baseline_html();
	}
	return $content;
}
add_filter('the_content', __NAMESPACE__.'\\display');
