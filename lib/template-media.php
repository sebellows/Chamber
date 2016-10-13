<?php

namespace Chamber\Theme\Template;

/**
 * Media template functions. These functions are meant to handle various features needed in theme templates
 * for media and attachments.
 *
 * @package    HybridCore
 * @subpackage Includes
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2008 - 2015, Justin Tadlock
 * @link       http://themehybrid.com/chamber
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

class Media {
	/**
	 * Splits the attachment mime type into two distinct parts: type / subtype (e.g., image / png).
	 * Returns an array of the parts.
	 *
	 * @since  3.0.0
	 * @access public
	 * @param  int    $post_id
	 * @return array
	 */
	public static function get_attachment_types( $post_id = 0 ) {

		$post_id   = empty( $post_id ) ? get_the_ID() : $post_id;
		$mime_type = get_post_mime_type( $post_id );

		list( $type, $subtype ) = false !== strpos( $mime_type, '/' ) ? explode( '/', $mime_type ) : array( $mime_type, '' );

		return (object) array( 'type' => $type, 'subtype' => $subtype );
	}

	/**
	 * Returns the main attachment mime type.  For example, `image` when the file has an `image / jpeg`
	 * mime type.
	 *
	 * @since  3.0.0
	 * @access public
	 * @param  int    $post_id
	 * @return string
	 */
	public static function get_attachment_type( $post_id = 0 ) {
		return get_attachment_types( $post_id )->type;
	}

	/**
	 * Returns the attachment mime subtype.  For example, `jpeg` when the file has an `image / jpeg`
	 * mime type.
	 *
	 * @since  3.0.0
	 * @access public
	 * @param  int    $post_id
	 * @return string
	 */
	public static function get_attachment_subtype( $post_id = 0 ) {
		return get_attachment_types( $post_id )->subtype;
	}

	/**
	 * Checks if the current post has a mime type of 'audio'.
	 *
	 * @since  1.6.0
	 * @access public
	 * @param  int    $post_id
	 * @return bool
	 */
	public static function attachment_is_audio( $post_id = 0 ) {
		return 'audio' === get_attachment_type( $post_id );
	}

	/**
	 * Checks if the current post has a mime type of 'video'.
	 *
	 * @since  1.6.0
	 * @access public
	 * @param  int    $post_id
	 * @return bool
	 */
	public static function attachment_is_video( $post_id = 0 ) {
		return 'video' === get_attachment_type( $post_id );
	}

	/**
	 * Returns a set of image attachment links based on size.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return string
	 */
	public static function get_image_size_links() {

		// If not viewing an image attachment page, return.
		if ( ! wp_attachment_is_image( get_the_ID() ) )
			return;

		// Set up an empty array for the links.
		$links = array();

		// Get the intermediate image sizes and add the full size to the array.
		$sizes   = get_intermediate_image_sizes();
		$sizes[] = 'full';

		// Loop through each of the image sizes.
		foreach ( $sizes as $size ) {

			// Get the image source, width, height, and whether it's intermediate.
			$image = wp_get_attachment_image_src( get_the_ID(), $size );

			// Add the link to the array if there's an image and if $is_intermediate (4th array value) is true or full size.
			if ( ! empty( $image ) && ( true === $image[3] || 'full' == $size ) ) {

				// Translators: Media dimensions - 1 is width and 2 is height.
				$label = sprintf( esc_html__( '%1$s &#215; %2$s', 'chamber' ), number_format_i18n( absint( $image[1] ) ), number_format_i18n( absint( $image[2] ) ) );

				$links[] = sprintf( '<a class="image-size-link">%s</a>', $label );
			}
		}

		// Join the links in a string and return.
		return join( ' <span class="sep">/</span> ', $links );
	}

	/**
	 * Loads the correct function for handling attachments.  Checks the attachment mime type to call
	 * correct function. Image attachments are not loaded with this function.  The functionality for them
	 * should be handled by the theme's attachment or image attachment file.
	 *
	 * Ideally, all attachments would be appropriately handled within their templates. However, this could
	 * lead to messy template files.
	 *
	 * @since  0.5.0
	 * @access public
	 * @return void
	 */
	public static function attachment() {

		$type = get_attachment_type();

		$attachment = function_exists( "__NAMESPACE__.\\{$type}_attachment" ) ? call_user_func( "__NAMESPACE__.\\{$type}_attachment", get_post_mime_type(), wp_get_attachment_url() ) : '';

		echo apply_filters( 'chamber/attachment', apply_filters( "chamber/{$type}/attachment", $attachment ) );
	}

	/**
	 * Handles application attachments on their attachment pages.  Uses the `<object>` tag to embed media
	 * on those pages.
	 *
	 * @since  0.3.0
	 * @access public
	 * @param  string $mime attachment mime type
	 * @param  string $file attachment file URL
	 * @return string
	 */
	public static function application_attachment( $mime = '', $file = '' ) {
		$embed_defaults = wp_embed_defaults();

		return sprintf(
			'<object type="%1$s" data="%2$s" width="%3$s" height="%4$s"><param name="src" value="%2$s" /></object>',
			esc_attr( $mime ),
			esc_url( $file ),
			absint( $embed_defaults['width'] ),
			absint( $embed_defaults['height'] )
		);
	}

	/**
	 * Handles text attachments on their attachment pages.  Uses the `<object>` element to embed media
	 * in the pages.
	 *
	 * @since  0.3.0
	 * @access public
	 * @param  string $mime attachment mime type
	 * @param  string $file attachment file URL
	 * @return string
	 */
	public static function text_attachment( $mime = '', $file = '' ) {
		$embed_defaults = wp_embed_defaults();

		return sprintf(
			'<object type="%1$s" data="%2$s" width="%3$s" height="%4$s"><param name="src" value="%2$s" /></object>',
			esc_attr( $mime ),
			esc_url( $file ),
			absint( $embed_defaults['width'] ),
			absint( $embed_defaults['height'] )
		);
	}
}
