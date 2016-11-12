<?php

namespace Chamber\Theme\Media;

/**
 * Get the first image from a post if it has one.
 *
 * If there is no feature-image for the post, try to 
 * use the first image from it if possible.
 * 
 * @param  int    $post_id      the post ID
 * @param  mixed  $post_content the post content
 * @param  string $classname    class name to append to the wrapper tag
 * @return mixed               the first image in the post content
 */
function get_first_image($post_id, $post_content, $classname) {
  $first_img = '';

  if (get_the_post_thumbnail( $post_id ) === '') {
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post_content, $matches);
    $matches = array_filter($matches);
	$first_img = !empty($matches) ? $matches[1][0] : '';
	$first_img = !empty($matches) ? '<img class="duplo-image" src="' . $first_img . '">' : '';	    	
  }
  else {
    $first_img = get_the_post_thumbnail( $post_id, 'large', ['class' => $classname]);
  }

  return $first_img;
}

/**
 * Get all image sizes.
 *
 * @source https://gist.github.com/eduardozulian/6467854
 */
function _get_all_image_sizes() {
	global $_wp_additional_image_sizes;
	$default_image_sizes = [ 'thumbnail', 'medium', 'medium_large', 'large' ];
	 
	foreach ( $default_image_sizes as $size ) {
		$image_sizes[$size]['width']	= intval( get_option( "{$size}_size_w") );
		$image_sizes[$size]['height'] = intval( get_option( "{$size}_size_h") );
		$image_sizes[$size]['crop']	= get_option( "{$size}_crop" ) ? get_option( "{$size}_crop" ) : false;
	}
	
	if ( isset( $_wp_additional_image_sizes ) && count( $_wp_additional_image_sizes ) )
		$image_sizes = array_merge( $image_sizes, $_wp_additional_image_sizes );
		
	return $image_sizes;
}

/**
 * Set the predefined image sizes to use at each breakpoint.
 * 
 * @param array $sizes Associative array of size aliases and predefined image sizes
 */
function set_image_sizes( $sizes = [] )
{
	$defaults = [
	  'small'  => 'medium',
	  'medium' => 'post-thumbnail',
	  'large'  => 'large',
	  'xlarge' => 'fullwidth'
  ];

	if ( empty($sizes) ) {
		$sizes = $defaults;
  }

	return $sizes;
}

/**
 * Get the image sizes.
 * 
 * @return array Associative array of size aliases and predefined image sizes
 */
function get_image_sizes()
{
	return set_image_sizes();
}

/**
 * Set the min- and max-width for each breakpoint.
 * 
 * @param array $breakpoints
 */
function set_breakpoints( $breakpoints = [] )
{
	$default_breakpoints = [
	  'small'  => [ 0, 639 ],
	  'medium' => [ 640, 1023 ],
	  'large'  => [ 1024, 1199 ],
	  'xlarge' => [ 1200, 9999 ]
  ];

	if ( empty( $breakpoints ) ) {
		$breakpoints = $default_breakpoints;
  } else {
	$breakpoint_sizes = get_breakpoint_sizes();

	foreach( $breakpoint_sizes as $breakpoint_size) {
		$breakpoints[] = [ $breakpoint_size => [ $breakpoints[0][0], $breakpoints[0][1] ] ];
	}
  }

	return $breakpoints;
}

/**
 * Get the breakpoints.
 * 
 * @return array
 */
function get_breakpoints()
{
	return set_breakpoints();
}

/**
 * Set the aliases to use for each breakpoint.
 * 
 * @param array $breakpoint_sizes Aliases for breakpoint sizes
 */
function set_breakpoint_sizes( $breakpoint_sizes = [] )
{
	$default_breakpoint_sizes = [ 'small', 'medium', 'large', 'xlarge' ];

	if ( empty($breakpoint_sizes) ) {
		$breakpoint_sizes = $default_breakpoint_sizes;
  }

	return $breakpoint_sizes;
}

/**
 * Get the breakpoint sizes.
 * 
 * @return array
 */
function get_breakpoint_sizes()
{
	return set_breakpoint_sizes();
}

/**
 * Set a `srcset` to use for responsive images.
 * 
 * @param mixed $srcset
 */
function set_srcset( $attachment_id )
{
	$sizes = get_image_sizes();
	$srcset = [];

	$srcsetSizes = get_image_sizes();

	foreach ( $srcsetSizes as $src ) {
	// dd(wp_get_attachment_image_src( $attachment_id, 'fullwidth' )[0]);
	// dd($sizes[$src]);
	$url = wp_get_attachment_image_src( $attachment_id, 'fullwidth' )[0];

	$srcset[] = $url;
  }

	return $srcset;
}

/**
 * Get the `srcset`.
 * 
 * @return mixed
 */
function get_srcset( $attachment_id )
{
	return set_srcset( $attachment_id );
}

function get_thumbnail_src( $attachment_id, $imgSize )
{
	$thumbnail_src = wp_get_attachment_image( $attachment_id ) ? wp_get_attachment_image_src( $attachment_id, $imgSize )[0] : get_the_post_thumbnail_url( $attachment_id, $imgSize );

	return $thumbnail_src;
}

function has_thumbnail_image( $attachment_id )
{
	$check = false;

	if ( wp_attachment_is_image( $attachment_id ) || has_post_thumbnail( $attachment_id ) ) {
		$check = true;
	}

	return $check;
}

/**
 * Get the post_thumbnail width.
 * 
 * @param  [type] $attachment_id [description]
 * @return [type]                [description]
 */
function get_post_thumbnail_width( $attachment_id )
{
	// Check if there is an image
	if ( has_thumbnail_image( $attachment_id ) === false ) {
		throw new \Exception( print_r( '<p class="warning alert">Post (id = $post->ID) does not have an image attachment or featured thumbnail!</p>' ) );
	}

	// Get the ID's post type
	$type = get_post_type( $attachment_id );

	$thumbnail_width = null;

	// Get the post thumbnail ID if the post type is not 'attachment' 
	if ( $type !== 'attachment' ) {
		$thumbnail_width = wp_get_attachment_image_src( get_post_thumbnail_id( $attachment_id ), 'post_thumbnail' )[1];
	} else {
		$thumbnail_width = wp_get_attachment_metadata( $attachment_id )['width'];
	}

	return $thumbnail_width;
}

/**
 * Generate a `style` tag that sets media-queries with an image size to use as a background.
 * 
 * @param int $attachment_id    The post ID
 * @param string $selector      The selector to apply CSS to in the `style` tag
 *
 * @return mixed A style tag containing the media-queried CSS
 */
function set_thumbnail_images_to_background( $attachment_id, $duploSize = 'banner', $selector )
{
	if ( ! is_int( $attachment_id ) ) {
		throw new \Exception( print_r( '<p class="warning alert">$attachment_id is not an integer! A post ID is required!</p>' ) );
	}

	$duploSizes  = get_duplo_sizes( $duploSize );
	$breakpoints = get_breakpoints();

	// Check that image is large enough for using media-queries.
	$thumbnail_width = get_post_thumbnail_width( $attachment_id );

	if ( wp_attachment_is_image( $attachment_id ) || has_post_thumbnail( $attachment_id ) ) :

		echo '<style>';

		if ( $thumbnail_width > 800 ) :
				
			foreach ( $duploSizes as $index => $duploSize ) {
			?>

				@media (min-width: <?= $breakpoints[$index][0]; ?>px) and (max-width: <?= $breakpoints[$index][1]; ?>px) {
					<?= $selector; ?> {
						background-image: url("<?= get_thumbnail_src( $attachment_id, $duploSize ); ?>");
					}
				}

			<?php } ?>

		<?php else : ?>

			<?= $selector; ?> {
				background-image: url("<?= get_thumbnail_src( $attachment_id, $duploSize ); ?>");
			}

		<?php endif;

		echo '</style>';

	endif;

}

/**
 * Set some screen reader text using an thumbnail's `alt` text.
 * 
 * @param int $attachment_id  The post ID
 *
 * @return mixed A paragraph of screen reader text
 */
function set_thumbnail_alt( $attachment_id )
{
	return sprintf('<p class="screen-reader-text">' . get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) . '</p>');
}

/**
 * Get the responsive image sizes to use in a Duplo.
 * 
 * @param  string $duploSize  The size of the Duplo block
 * 
 * @return array
 */
function get_duplo_sizes( $duploSize = 'banner' )
{
	$small = [
	'small'  => 'vignette',
	'medium' => 'small',
	'large'  => 'medium_large',
	'xlarge' => 'post-thumbnail'
  ];

	$medium = [
	  'small'  => 'small',
	  'medium' => 'medium',
	  'large'  => 'medium_large',
	  'xlarge' => 'post-thumbnail'
  ];

	$large = [
	  'small'  => 'medium',
	  'medium' => 'medium_large',
	  'large'  => 'post-thumbnail',
	  'xlarge' => 'large'
  ];

	$banner = get_image_sizes();

	switch ($duploSize) {
	case 'small':
		return $small;
		break;
	case 'medium':
		return $medium;
		break;
	case 'large':
		return $large;
		break;
	case 'banner':
		return $banner;
  }
}

/**
 * Get the index of the Duplo block in order to determine 
 * the required image size.
 * 
 * @param  integer  $attachment_id the post ID
 * @param  integer $counter        the total number of blocks
 * @param  integer $index          the index number of a block
 * @return mixed                   the sized image
 */
function get_duplo_size_from_counter( $attachment_id, $counter = 0, $index = 0 )
{
	$bgImgs = [];

	switch ($counter) {
		case 1:
			return [ $attachment_id, 'banner' ];
			break;
		case 2:
			switch ($index) {
				case 1:
					return [ $attachment_id, 'banner' ];
					break;
				case 2:
					return [ $attachment_id, 'large' ];
			};
			break;
		case 3:
			switch ($index) {
				case 1:
					return [ $attachment_id, 'large' ];
					break;
				case 2:
					return [ $attachment_id, 'medium' ];
					break;
				case 3:
					return [ $attachment_id, 'medium' ];
			}
			break;
		case 4:
			switch ($index) {
				case 1:
					return [ $attachment_id, 'large' ];
					break;
				case 2:
					return [ $attachment_id, 'medium' ];
					break;
				case 3:
					return [ $attachment_id, 'small' ];
					break;
				case 4:
					return [ $attachment_id, 'small' ];
			}
	}
}

/**
 * Get the image for a Duplo block and set it as a background image.
 * 
 * @param  int $attachment_id   The post ID
 * @return mixed                The view for a `.duplo-media` container
 */
function get_duplo_media( $attachment_id, $counter = 1, $index = 1, $selector = '.duplo-image', $duploSize = null )
{
	if ( $attachment_id !== null ) :
		$duploIndex = get_duplo_size_from_counter( $attachment_id, $counter, $index );
	?>
	<div class="duplo-media">
		<?php
			set_thumbnail_images_to_background($duploIndex[0], $duploIndex[1], '[m-Duplo="'.$index.'"] '.$selector);
		?>
		<div class="duplo-image">
		  <?php if ( !empty($image['alt']) ) : ?>
			  <p class="screen-reader-text"><?= $image['alt']; ?></p>
		  <?php endif; ?>
			<?= set_thumbnail_alt( $attachment_id ); ?>
		</div>

		<div class="duplo-skrim" aria-hidden="true"></div>
	</div>

	<?php
	endif;
}

/**
 * Get the ID from a URL in an embedded YouTube video.
 *
 * @source  http://jeromejaglale.com/doc/php/youtube_generate_embed_from_url
 * 
 * @param  string $url
 * @return string the video's unique ID
 */
function get_youtube_embed_url( $url )
{
    $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9-_]+)\??/i';
    $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))([a-zA-Z0-9-_]+)/i';

    if (preg_match($longUrlRegex, $url, $matches)) {
    $id = $matches[count($matches) - 1];
    }

    if (preg_match($shortUrlRegex, $url, $matches)) {
    $id = $matches[count($matches) - 1];
    }

    return isset($id) ? $id : 'error';
}
