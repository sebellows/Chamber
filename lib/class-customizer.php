<?php

namespace Chamber\Theme;

/**
 * chamber Theme Customizer.
 *
 * @package chamber
 */
class Customizer 
{

	/**
	 * Boot Customizer module.
	 * 
	 * @return void
	 */
	public function boot()
	{
		add_action( 'customize_register', [$this, 'register'], 11 );
		add_action( 'customize_preview_init', [$this, 'previewJS'] );
	}

	/**
	 * Add postMessage support for site title and description for the Theme Customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function register( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	}

	/**
	 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
	 */
	public function previewJS() {
		wp_enqueue_script( 'customizer-is-active', chamber_asset_path() . 'js/customizer.js', [ 'customize-preview' ], '20161016', true );
	}

}

// (new Customizer)->boot();
