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
 * @param int $attachment_id  	The post ID
 * @param string $selector      The selector to apply CSS to in the `style` tag
 *
 * @return mixed A style tag containing the media-queried CSS
 */
function set_thumbnail_images_to_background( $attachment_id, $duploSize = 'banner', $selector )
{
	$srcset      = get_srcset( $attachment_id );
	$sizes       = get_breakpoint_sizes();
	$imgSizes    = get_duplo_sizes( $duploSize );
	$breakpoints = get_breakpoints();

    if ( $attachment_id !== null ) {
        echo '<style>';

        foreach ( $srcset as $index => $src ) {
            ?>
            @media (min-width: <?= $breakpoints[$sizes[$index]][0]; ?>px) and (max-width: <?= $breakpoints[$sizes[$index]][1]; ?>px) {
                <?= $selector; ?> {
                    background-image: url("<?= wp_get_attachment_image_src( $attachment_id, $imgSizes[$sizes[$index]] )[0]; ?>");
                }
            }
            <?php
        }

        echo '</style>';
    }
}

/**
 * Set some screen reader text using an thumbnail's `alt` text.
 * 
 * @param int $attachment_id	The post ID
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
 * @param  string $duploSize 	The size of the Duplo block
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

function get_duplo_size_from_counter( $counter = 0 )
{
	switch ($counter) {
		case 1:
			return 'banner';
			break;
		case 2:
			return 'large';
			break;
		case 3:
			return 'medium';
			break;
		case 4:
			return 'medium';
	}
}

/**
 * Get the image for a Duplo block and set it as a background image.
 * 
 * @param  int $attachment_id 	The post ID
 * @return mixed                The view for a `.duplo-media` container
 */
function get_duplo_media( $attachment_id, $duploSize = 'banner' )
{
	if ( $attachment_id !== null ) :
    ?>
    <div class="duplo-media">
        <?= set_thumbnail_images_to_background( $attachment_id, $duploSize, '.duplo-image' ); ?>
        <div class="duplo-image">
        <h1 style="color:red;">The ID is: <?= $attachment_id; ?></h1>
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
