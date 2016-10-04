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
 * Modify the read more link text for the_excerpt()
 */
function custom_excerpt_more($more) {
	global $post;

	return '<a class="readmore" href="' . get_permalink($post->ID) . '">Read More ' . '<svg class="icon" m-Icon="xsmall" role="presentation" viewBox="0 0 32 32"><use xlink:href="#icon-fat-arrow"></use></svg></a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\custom_excerpt_more');

/**
 * Modify the read more link text for the_content()
 */
function custom_content_more() {
	return '<a class="readmore" href="' . get_permalink() . '">Read More ' . '<svg class="icon" m-Icon="xsmall" role="presentation" viewBox="0 0 32 32"><use xlink:href="#icon-fat-arrow"></use></svg></a>';
}
add_filter('the_content_more_link', __NAMESPACE__ . '\\custom_content_more');

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

/**
 * Add a Featured Post meta box.
 * 
 * @return void
 */
function add_featured_meta() {
    add_meta_box( 'featured_meta', 'Featured Post', __NAMESPACE__ . '\\render_featured_meta', 'post' );
}

/**
 * Render a view of the Featured Post meta box.
 * 
 * @param  mixed $post
 * @return the meta box view
 */
function render_featured_meta( $post ) {
    $featured = get_post_meta( $post->ID );
    ?>
 
	<p>
	    <div class="featured-callout">
	        <label class="selectit">
	            <input type="checkbox" name="featured-post-meta" id="featured-post-meta" value="yes" <?php if ( isset ( $featured['featured-post-meta'] ) ) checked( $featured['featured-post-meta'][0], 'yes' ); ?> />
	            Feature this post
	        </label>
	    </div>
	</p>
    <?php
}
add_action( 'add_meta_boxes', __NAMESPACE__ . '\\add_featured_meta' );

/**
 * Saves the featured post meta input.
 * 
 * @param  int $post_id
 * @return void
 */
function save_featured_meta( $post_id ) {
 
    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'chamber_nonce' ] ) && wp_verify_nonce( $_POST[ 'chamber_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
 
	// Checks for input and saves
	if( isset( $_POST[ 'featured-post-meta' ] ) ) {
	    update_post_meta( $post_id, 'featured-post-meta', 'yes' );
	} else {
	    update_post_meta( $post_id, 'featured-post-meta', '' );
	}
}
add_action( 'save_post', __NAMESPACE__ . '\\save_featured_meta' );


/**
 * Disable Comments
 *
 *  see http://codex.wordpress.org/Function_Reference/comments_open
 */
add_filter('comments_open', '__return_false');

/**
 * Custom Gallery Styles
 */
add_filter('use_default_gallery_style', '__return_false');

/**
 * Remove those damn emojis.
 */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );