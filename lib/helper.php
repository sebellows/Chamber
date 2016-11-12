<?php

namespace Chamber\Theme;

/**
 * HELPERS
 */

class Helper
{

	/**
	 * Get first paragraph of 'post_content'.
	 *
	 * If the post does not have an excerpt, fake one 
	 * using the first paragraph of the post.
	 * 
	 * @param  int    $post_id         the post ID
	 * @param  mixed  $post_content    the post content
	 * @param  int    $character_count character limit for fake excerpt
	 * @param  string $continued_mark  abbreviated text indication mark at end of fake excerpt
	 * @return string                  the excerpt (or fake excerpt)
	 */
	public static function get_first_paragraph($post_id, $post_content, $character_count, $continued_mark = '&hellip;') {
	    $content = '';

	    if (get_the_excerpt() === '') {
	        $content = wpautop( $post_content );
	        $content = preg_match_all('%(<p[^>]*>.*?</p>)%i', $content, $matches);
	        $matches = array_filter($matches);
	        $content = !empty($matches) ? $matches [1] [0] : '';
	        $content = wordwrap($content, $character_count);
	        $content = preg_replace("/&amp;/", "&",$content);
	        $content = substr($content,0,strpos($content, "\n"));
	        $content = $content . $continued_mark;
	    }
	    else {
	        $post    = $post_id;
	        $content = get_the_excerpt();
	    }

	    return $content;
	}

	/**
	 * Get the content of the post if there is no excerpt.
	 *
	 * @param int $limit the character count limit
	 * @param  str $continued_mark glyph or text to communicate that this is abbreviated text
	 * @return str excerpt text
	 */
	public static function limit_content($content = '', $limit = 120, $continued_mark = '[&hellip;]') {
		$content = wordwrap($content, $limit);

		if ( strlen($content) > $limit ) {
			$content = substr($content,0,strpos($content, "\n")) . $continued_mark;
		}

		return $content;
	}

	/**
	 * Limit the content length in the home feed.
	 * 
	 * @param  mixed   $content `the_content()`
	 * @param  integer $limit   the character limit
	 * 
	 * @return mixed            the abbreviated content
	 */
	public static function limit_content_length( $content = '', $limit = 300 ) {
		// Do not cut if too short
		if ( strlen( $content ) < $limit+10 ) {
			return $content;
		}

		// Remove inline images if there are any
		$content = preg_replace("/<img[^>]+\>/i", " ", $content);

		// Find the next space after `$limit` to prevent sudden word break
		$break = strpos( $content, ' ', $limit );

	    // Take the existing content and return a subset of it
	    $chunk = substr( $content, 0, $break );

	    // Make sure any tags don't get left off in the cut
	    return balanceTags( $chunk );
	}

	/**
	 * Get the name of the current page.
	 *
	 * @link http://stackoverflow.com/questions/4837006/how-to-get-the-current-page-name-in-wordpress#answer-4837800
	 * 
	 * @return str the name of the page
	 */
	public static function get_current_page_name() {
		$pagename = get_query_var('pagename');  

		if ( !$pagename && $id > 0 ) {  
		    // If a static page is set as the front page, $pagename will not be set. Retrieve it from the queried object  
		    $post = $wp_query->get_queried_object();  
		    $pagename = $post->post_name;  
		}

		return $pagename;
	}

	/**
	 * Get all fo the pages.
	 * 
	 * @return array  An array of all pages
	 */
	public static function get_all_pages() {
		$pages = [];

		$children = collect(get_child_pages(get_current_page_name()))->map(function($key) {
			return $key->post_name;
		})->toArray();

		$pages = array_merge($sections,$children);

		return $pages;
	}

	/**
	 * Get the parent page of the current post/page.
	 *
	 * @see https://codex.wordpress.org/Function_Reference/wp_get_post_parent_id
	 * 
	 * @return mixed The page object
	 */
	public static function get_parent_page() {
		return get_post(wp_get_post_parent_id($post->ID));
	}


	public static function get_child_pages($page_name) {
		$children = [];

		// Get the page as an Object
		$page = get_page_by_title(get_current_page_name());

		$children = get_pages( [ 'child_of' => $page->ID ] );

		return $children;
	}

	/**
	 * Determine if current page is a child of a parent page.
	 * 
	 * @param  int  $post_id The ID of the parent page.
	 * 
	 * @return boolean
	 */
	public static function is_child($post_id) {
	    global $post;

	    if(is_page()&&($post->post_parent==$post_id)) {
	       return true;  
	    }
	    else {
	       return false; 
	    }
	}

	/**
	 * Get all sub pages of the current parent.
	 * 
	 * @return array WP_Query object containing all sub pages of parent
	 */
	public static function get_all_sub_pages() {
		// Determine parent page ID
		$parent_page_id = ( '0' != $post->post_parent ? $post->post_parent : $post->ID );
		// Build WP_Query() argument array
		$page_tree_query_args = [ 'post_parent' => $parent_page_id ];
		// Get child pages as a WP_Query() object
		$page_tree_query = new WP_Query( $page_tree_query_args );

		return $page_tree_query;
	}

}