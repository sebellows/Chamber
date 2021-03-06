<?php

namespace Chamber\Theme;

/**
 * Sample implementation of the Custom Header feature.
 *
 * You can add an optional custom header image to header.php like so…
 *
	<?php if ( get_header_image() ) : ?>
	<a href="<?= esc_url( home_url( '/' ) ); ?>" rel="home">
		<img src="<?php header_image(); ?>" width="<?= esc_attr( get_custom_header()->width ); ?>" height="<?= esc_attr( get_custom_header()->height ); ?>" alt="">
	</a>
	<?php endif; // End header image check. ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package    Soil
 * @author     roots.io
 * @copyright  Copyright (c) Roots
 * @link       https://github.com/roots/soil
 */
class CustomHeader 
{

	/**
	 * Boot custom header module.
	 * 
	 * @return void
	 */
	public function boot()
	{
		$this->register_default_headers();

		add_action( 'after_setup_theme', [$this, 'custom_header_setup'] );
		add_filter( 'chamber/custom/header/style', [$this, 'header_style'] );
	}
	
	public function register_default_headers() {
		register_default_headers( [
		    'fgcc-logo' => [
		        'url'   => chamber_asset_path() . 'images/fgcc-logo.svg',
		        'thumbnail_url' => chamber_asset_path() . 'images/fgcc-logo.svg',
		        'description'   => __( 'Flint & Genesee Logo', 'chamber' )
		    ]
		]);
	}

	/**
	 * Set up the WordPress core custom header feature.
	 *
	 * @uses header_style()
	 */
	public function custom_header_setup() {
		add_theme_support( 'custom-header', [
			'default-image'          => chamber_asset_path() . 'images/fgcc-logo.svg',
			'default-text-color'     => '000000',
			'width'                  => 315,
			'height'                 => 108,
			'flex-width'             => true,
			'flex-height'            => true,
			'header-selector'		 => '.site-title a',
			'header-text'			 => false,
			'wp-head-callback'       => [$this, 'header_style'],
		] );
	}

	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see custom_header_setup().
	 */
	public function header_style() {
		$header_text_color = get_header_textcolor();

		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: HEADER_TEXTCOLOR.
		 */
		if ( HEADER_TEXTCOLOR === $header_text_color ) {
			return;
		}

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php
			// Has the text been hidden?
			if ( ! display_header_text() ) :
		?>
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
		<?php
			// If the user has set a custom color for the text use that.
			else :
		?>
			.site-title a,
			.site-description {
				color: #<?= esc_attr( $header_text_color ); ?>;
			}
		<?php endif; ?>
		</style>
		<?php
	}

}

// (new CustomHeader)->boot();
