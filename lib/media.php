<?php

namespace Chamber\Theme\Media;

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
	$duploSizes  = get_duplo_sizes( $duploSize );
	$breakpoints = get_breakpoints();

	if ( !empty(wp_get_attachment_image( $attachment_id )) || !empty(get_the_post_thumbnail_url( $attachment_id )) || has_post_thumbnail() ) :
		echo '<style>';

		foreach ( $duploSizes as $index => $duploSize ) {
			if ( !empty( wp_get_attachment_image( $attachment_id ) ) ) :
			?>

				@media (min-width: <?= $breakpoints[$index][0]; ?>px) and (max-width: <?= $breakpoints[$index][1]; ?>px) {
					<?= $selector; ?> {
						background-image: url("<?= wp_get_attachment_image_src( $attachment_id, $duploSize )[0]; ?>");
						content: '<?= $duploSize; ?>';
					}
				}

			<?php else :
			?>

				@media (min-width: <?= $breakpoints[$index][0]; ?>px) and (max-width: <?= $breakpoints[$index][1]; ?>px) {
					<?= $selector; ?> {
						background-image: url("<?= get_the_post_thumbnail_url( $attachment_id, $duploSize ); ?>");
						content: '<?= $duploSize; ?>';
					}
				}

			<?php endif;
		}

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


function get_custom_duplo_image( $attachment_id, $counter ) {
	$image_url = $counter === 1 ? wp_get_attachment_image_url( $attachment_id, 'fullwidth' ) : wp_get_attachment_image_url( $attachment_id, 'medium_large' );

	return $image_url;
}

function get_post_duplo_image( $attachment_id, $counter ) {
	$image_url = $counter === 1 ? get_the_post_thumbnail_url( $attachment_id, 'fullwidth' ) : get_the_post_thumbnail_url( $attachment_id, 'medium_large' );

	return $image_url;
}
