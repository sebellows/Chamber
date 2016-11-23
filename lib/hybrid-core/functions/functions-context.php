<?php
/**
 * Contextual functions and filters, particularly dealing with the body, post, and comment classes.
 *
 * @package    HybridCore
 * @subpackage Includes
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2008 - 2015, Justin Tadlock
 * @link       http://themehybrid.com/hybrid-core
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Filters the WordPress 'body_class' early.
add_filter( 'body_class', 'hybrid_body_class_filter', 0, 2 );

# Filters the WordPress 'post_class' early.
add_filter( 'post_class', 'hybrid_post_class_filter', 0, 3 );

# Filters the WordPress 'comment_class' early.
add_filter( 'comment_class', 'hybrid_comment_class_filter', 0, 3 );

/**
 * Hybrid's main contextual function.  This allows code to be used more than once without running
 * hundreds of conditional checks within the theme.  It returns an array of contexts based on what
 * page a visitor is currently viewing on the site.  This function is useful for making dynamic/contextual
 * classes, action and filter hooks, and handling the templating system.
 *
 * Note that time and date can be tricky because any of the conditionals may be true on time-/date-
 * based archives depending on several factors.  For example, one could load an archive for a specific
 * second during a specific minute within a specific hour on a specific day and so on.
 *
 * @since  0.7.0
 * @access public
 * @return array
 */
function hybrid_get_context() {

	// Set some variables for use within the function.
	$context   = array();
	$object    = get_queried_object();
	$object_id = get_queried_object_id();

	// Front page of the site.
	if ( is_front_page() )
		$context[] = 'home';

	// Blog page.
	if ( is_home() ) {
		$context[] = 'blog';
	}

	// Singular views.
	elseif ( is_singular() ) {
		$context[] = 'singular';
		$context[] = "singular-{$object->post_type}";
		$context[] = "singular-{$object->post_type}-{$object_id}";
	}

	// Archive views.
	elseif ( is_archive() ) {
		$context[] = 'archive';

		// Post type archives.
		if ( is_post_type_archive() ) {
			$post_type = get_query_var( 'post_type' );

			if ( is_array( $post_type ) )
				reset( $post_type );

			$context[] = "archive-{$post_type}";
		}

		// Taxonomy archives.
		if ( is_tax() || is_category() || is_tag() ) {
			$context[] = 'taxonomy';
			$context[] = "taxonomy-{$object->taxonomy}";

			$slug = 'post_format' == $object->taxonomy ? str_replace( 'post-format-', '', $object->slug ) : $object->slug;

			$context[] = "taxonomy-{$object->taxonomy}-" . sanitize_html_class( $slug, $object->term_id );
		}

		// User/author archives.
		if ( is_author() ) {
			$user_id = get_query_var( 'author' );
			$context[] = 'user';
			$context[] = 'user-' . sanitize_html_class( get_the_author_meta( 'user_nicename', $user_id ), $user_id );
		}

		// Date archives.
		if ( is_date() ) {
			$context[] = 'date';

			if ( is_year() )
				$context[] = 'year';

			if ( is_month() )
				$context[] = 'month';

			if ( get_query_var( 'w' ) )
				$context[] = 'week';

			if ( is_day() )
				$context[] = 'day';
		}

		// Time archives.
		if ( is_time() ) {
			$context[] = 'time';

			if ( get_query_var( 'hour' ) )
				$context[] = 'hour';

			if ( get_query_var( 'minute' ) )
				$context[] = 'minute';
		}
	}

	// Search results.
	elseif ( is_search() ) {
		$context[] = 'search';
	}

	// Error 404 pages.
	elseif ( is_404() ) {
		$context[] = 'error-404';
	}

	return array_map( 'esc_attr', apply_filters( 'hybrid_context', array_unique( $context ) ) );
}

/**
 * Filters the WordPress body class with a better set of classes that are more consistently handled and
 * are backwards compatible with the original body class functionality that existed prior to WordPress
 * core adopting this feature.
 *
 * @since  2.0.0
 * @access public
 * @param  array        $classes
 * @param  string|array $class
 * @return array
 */
function hybrid_body_class_filter( $classes, $class ) {
	// Add page slug if it doesn't exist
	if (is_single() || is_page() && !is_front_page()) {
		if (!in_array(basename(get_permalink()), $classes)) {
			$classes[] = basename(get_permalink());
		}
	}

	// Add class of hfeed to non-singular pages.
	if ( ! is_singular() )
		$classes[] = 'hfeed';

	// Add class if sidebar is active
	if (chamber('sidebar')->display())
		$classes[] = 'has-sidebar-primary';

	// Add class if we're viewing the Customizer for easier styling of theme options.
	if ( is_customize_preview() )
		$classes[] = 'customizer-is-active';

	// Add class on front page.
	if ( is_front_page() && 'posts' !== get_option( 'show_on_front' ) ) {
		$classes[] = 'front-page';
	}

	// Add class for one or two column page layouts.
	if ( is_page() && ! is_front_page() && ! is_home() ) {
		$classes[] = 'one-column' === get_theme_mod( 'page_options' ) ? 'page-one-column' : 'page-two-column';
	}

	// Is the current user logged in.
	$classes[] = is_user_logged_in() ? 'logged-in' : 'logged-out';

	// WP admin bar.
	if ( is_admin_bar_showing() )
		$classes[] = 'admin-bar';

	// Use the '.custom-background' class to integrate with the WP background feature.
	if ( get_background_image() || get_background_color() )
		$classes[] = 'custom-background';

	// Add the '.custom-header' class if the user is using a custom header.
	if ( get_header_image() || ( display_header_text() && get_header_textcolor() ) )
		$classes[] = 'custom-header';

	// Add the `.custom-logo` class if user is using a custom logo.
	if ( function_exists( 'has_custom_logo' ) && has_custom_logo() )
		$classes[] = 'wp-custom-logo';

	// Add the '.display-header-text' class if the user chose to display it.
	if ( display_header_text() )
		$classes[] = 'display-header-text';

	// Plural/multiple-post view (opposite of singular).
	if ( hybrid_is_plural() )
		$classes[] = 'plural';

	// Merge base contextual classes with $classes.
	$classes = array_merge( $classes, hybrid_get_context() );

	// Singular post (post_type) classes.
	if ( is_singular() ) {

		// Get the queried post object.
		$post = get_queried_object();

		// Checks for custom template.
		$template = str_replace( array ( "{$post->post_type}-template-", "{$post->post_type}-" ), '', basename( hybrid_get_post_template( $post->ID ), '.php' ) );

		if ( $template )
			$classes[] = "{$post->post_type}-template-{$template}";

		// Post format.
		if ( current_theme_supports( 'post-formats' ) && post_type_supports( $post->post_type, 'post-formats' ) ) {
			$post_format = get_post_format( get_queried_object_id() );
			$classes[] = $post_format && ! is_wp_error( $post_format ) ? "{$post->post_type}-format-{$post_format}" : "{$post->post_type}-format-standard";
		}

		// Attachment mime types.
		if ( is_attachment() ) {
			foreach ( explode( '/', get_post_mime_type() ) as $type )
				$classes[] = "attachment-{$type}";
		}
	}

	// Paged views.
	if ( is_paged() ) {
		$classes[] = 'paged';
		$classes[] = 'paged-' . intval( get_query_var( 'paged' ) );
	}

	// Singular post paged views using <!-- nextpage -->.
	elseif ( is_singular() && 1 < get_query_var( 'page' ) ) {
		$classes[] = 'paged';
		$classes[] = 'paged-' . intval( get_query_var( 'page' ) );
	}

	// Theme layouts.
	if ( current_theme_supports( 'theme-layouts' ) )
		$classes[] = sanitize_html_class( 'layout-' . hybrid_get_theme_layout() );

	// Input class.
	if ( $class ) {
		$class   = is_array( $class ) ? $class : preg_split( '#\s+#', $class );
		$classes = array_merge( $classes, $class );
	}

	return array_map( 'esc_attr', $classes );
}

/**
 * Filters the WordPress post class with a better set of classes that are more consistently handled and
 * are backwards compatible with the original post class functionality that existed prior to WordPress
 * core adopting this feature.
 *
 * @since  2.0.0
 * @access public
 * @param  array        $classes
 * @param  string|array $class
 * @param  int          $post_id
 * @return array
 */
function hybrid_post_class_filter( $classes, $class, $post_id ) {

	if ( is_admin() )
		return $classes;

	$_classes    = array();
	$post        = get_post( $post_id );
	$post_type   = get_post_type();

	// Password-protected posts.
	if ( post_password_required() )
		$_classes[] = 'protected';

	// Has excerpt.
	if ( post_type_supports( $post_type, 'excerpt' ) && has_excerpt() )
		$_classes[] = 'has-excerpt';

	// Has <!--more--> link.
	if ( ! is_singular() && false !== strpos( $post->post_content, '<!--more' ) )
		$_classes[] = 'has-more-link';

	// Has <!--nextpage--> links.
	if ( false !== strpos( $post->post_content, '<!--nextpage' ) )
		$_classes[] = 'has-pages';

	return array_map( 'esc_attr', array_unique( array_merge( $_classes, $classes ) ) );
}

/**
 * Adds custom classes to the WordPress comment class.
 *
 * @since  2.0.0
 * @access public
 * @param  array        $classes
 * @param  string|array $class
 * @param  int          $comment_id
 * @return array
 */
function hybrid_comment_class_filter( $classes, $class, $comment_id ) {

	$comment = get_comment( $comment_id );

	// User classes to match user role and user.
	if ( 0 < $comment->user_id ) {

		// Create new user object.
		$user = new WP_User( $comment->user_id );

		// Set a class with the user's role(s).
		if ( is_array( $user->roles ) ) {
			foreach ( $user->roles as $role )
				$classes[] = sanitize_html_class( "role-{$role}" );
		}
	}

	// Get comment types that are allowed to have an avatar.
	$avatar_types = apply_filters( 'get_avatar_comment_types', array( 'comment' ) );

	// If avatars are enabled and the comment types can display avatars, add the 'has-avatar' class.
	if ( get_option( 'show_avatars' ) && in_array( $comment->comment_type, $avatar_types ) )
		$classes[] = 'has-avatar';

	return array_map( 'esc_attr', array_unique( $classes ) );
}
