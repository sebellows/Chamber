<?php

namespace Chamber\Theme\TemplateTags;

/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package chamber
 */

# Flush out the transients used in categorized_blog.
add_action( 'edit_category', __NAMESPACE__ . '\\category_transient_flusher' );
add_action( 'save_post',     __NAMESPACE__ . '\\category_transient_flusher' );


/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', __NAMESPACE__ ) );

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', __NAMESPACE__ ) );

		if ( $categories_list && categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Categories: %1$s', __NAMESPACE__ ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		if ( $categories_list && categorized_blog() && $tags_list ) {
			printf( '<s>' . esc_html('|') . '</s>' );
		}

		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tags: %1$s', __NAMESPACE__ ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', __NAMESPACE__ ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so categorized_blog should return false.
		return false;
	}
}

/**
 * Utility function to check if a gravatar exists for a given email or id
 * @param int|string|object $id_or_email A user ID,	email address, or comment object
 * @return bool if the gravatar exists or not
 * Original found at https://gist.github.com/justinph/5197810
 */
function validate_gravatar($id_or_email) {
	//id or email code borrowed from wp-includes/pluggable.php
	$email = '';
	if ( is_numeric($id_or_email) ) {
		$id = (int) $id_or_email;
		$user = get_userdata($id);
		if ( $user )
			$email = $user->user_email;
	} elseif ( is_object($id_or_email) ) {
		// No avatar for pingbacks or trackbacks
		$allowed_comment_types = apply_filters( 'get_avatar_comment_types', array( 'comment' ) );
		if ( ! empty( $id_or_email->comment_type ) && ! in_array( $id_or_email->comment_type, (array) $allowed_comment_types ) )
			return false;
		if ( !empty($id_or_email->user_id) ) {
			$id = (int) $id_or_email->user_id;
			$user = get_userdata($id);
			if ( $user)
				$email = $user->user_email;
		} elseif ( !empty($id_or_email->comment_author_email) ) {
			$email = $id_or_email->comment_author_email;
		}
	} else {
		$email = $id_or_email;
	}
	$hashkey = md5(strtolower(trim($email)));
	$uri = 'http://www.gravatar.com/avatar/' . $hashkey . '?d=404';
	$data = wp_cache_get($hashkey);
	if (false === $data) {
		$response = wp_remote_head($uri);
		if( is_wp_error($response) ) {
			$data = 'not200';
		} else {
			$data = $response['response']['code'];
		}
			wp_cache_set($hashkey, $data, $group = '', $expire = 60*5);
	}	 
	if ($data == '200'){
		return true;
	} else {
		return false;
	}
}

/**
 * Customizing `the_posts_pagination`
 *
 * Get rid of the container class `nav-links` and use Foundation's pagination
 * 
 */
function post_pagination($args = [], $class = 'pagination') {

    if ($GLOBALS['wp_query']->max_num_pages <= 1) return;

    $args = wp_parse_args( $args, [
        'mid_size'           => 2,
        'prev_next'			 => false,
        'prev_text'          => __('Previous', __NAMESPACE__),
        'next_text'          => __('Next', __NAMESPACE__),
        'screen_reader_text' => __('Posts navigation', __NAMESPACE__),
        'type'				 => 'list',
    ]);

    $links     = paginate_links($args);
    $prev_link = get_previous_posts_link($args['prev_text']);
    $next_link = get_next_posts_link($args['next_text']);
    $template  = apply_filters( 'navigation_markup_template', '
    <nav class="%1$s" role="navigation">
        <h2 class="screen-reader-text">%2$s</h2>
        <span class="pagination-previous">%3$s</span>
        <div class="pagination-numbers">%4$s</div>
        <span class="pagination-next">%5$s</span>
    </nav>', $args, $class);

    echo sprintf($template, $class, $args['screen_reader_text'], $prev_link, $links, $next_link);
}

/**
 * Flush out the transients used in categorized_blog.
 */
function category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'categories' );
}
