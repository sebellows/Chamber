<?php

namespace Chamber\Theme;

/**
 * Register metaboxes.
 *
 * @package    Chamber Theme
 * @author     Sean Bellows <sean@seanbellows.com>
 * @copyright  Copyright (c) 2016, Sean Bellows
 * @link       https://github.com/sebellows/chamber
 * @license    http://www.gnu.org/licenses/gpl-3.0.html
 */
class MetaBox
{
	/**
	 * Register the sidebars.
	 */
	public function __construct() {}

	/**
	 * Boot metabox class.
	 * 
	 * @return void
	 */
	public function boot()
	{
		add_action( 'add_meta_boxes', [ $this, 'add_featured_meta' ] );
		add_action( 'save_post', [ $this, 'save_featured_meta' ] );
	}

	/**
	 * Add a Featured Post meta box.
	 * 
	 * @return void
	 */
	function add_featured_meta() {
	    add_meta_box( 'featured_meta', 'Featured Post', [ $this, 'render_featured_meta' ], 'post', 'side', 'high' );
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

}

// (new Metabox)->boot();
