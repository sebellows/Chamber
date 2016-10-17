<?php

namespace Chamber\Theme\Customizer;

use Chamber\Theme\Assets;

/**
 * chamber Theme Customizer.
 *
 * @package chamber
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', __NAMESPACE__ . '\\customize_register', 11 );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function customize_preview_js() {
	wp_enqueue_script( 'customizer-is-active', Assets\asset_path('js/customizer.js'), [ 'customize-preview' ], '20161016', true );
}
add_action( 'customize_preview_init', __NAMESPACE__ . '\\customize_preview_js' );
