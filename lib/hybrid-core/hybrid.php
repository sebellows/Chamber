<?php
/**
 * Hybrid Core - A WordPress theme development framework.
 *
 * Hybrid Core is a framework for developing WordPress themes.  The framework allows theme developers
 * to quickly build themes without having to handle all of the "logic" behind the theme or having to
 * code complex functionality for features that are often needed in themes.  The framework does these
 * things for developers to allow them to get back to what matters the most:  developing and designing
 * themes. Themes handle all the markup, style, and scripts while the framework handles the logic.
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License as published by the Free Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not,
 * write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package   HybridCore
 * @version   3.1.0-dev
 * @author    Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2008 - 2015, Justin Tadlock
 * @link      http://themehybrid.com/hybrid-core
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// if ( ! class_exists( 'Hybrid' ) ) {

/**
 * The Hybrid class launches the framework.  It's the organizational structure behind the
 * entire framework.  This class should be loaded and initialized before anything else within
 * the theme is called to properly use the framework.
 *
 * After parent themes call the Hybrid class, they should perform a theme setup function on
 * the `after_setup_theme` hook with a priority no later than 11.  This allows the class to
 * load theme-supported features at the appropriate time, which is on the `after_setup_theme`
 * hook with a priority of 12.
 *
 * Note that while it is possible to extend this class, it's not usually recommended unless
 * you absolutely know what you're doing and expect your sub-class to break on updates.  This
 * class often gets modifications between versions.
 *
 * @since  0.7.0
 * @access public
 */
class Hybrid {

	/**
	 * Constructor method for the Hybrid class.  This method adds other methods of the
	 * class to specific hooks within WordPress.  It controls the load order of the
	 * required files for running the framework.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function __construct() {

		// Set up an empty object to work with.
		$GLOBALS['hybrid'] = new stdClass;

		// Set up the load order.
		add_action( 'after_setup_theme', array( $this, 'constants' ), 1 );
		add_action( 'after_setup_theme', array( $this, 'core' ), 1 );
		add_action( 'after_setup_theme', array( $this, 'theme_support' ), 2 );
		add_action( 'after_setup_theme', array( $this, 'includes' ), 3 );
		add_action( 'after_setup_theme', array( $this, 'extensions' ), 4 );
		add_action( 'after_setup_theme', array( $this, 'admin' ), 5 );

	}

	/**
	 * Defines the constant paths for use within the core framework, parent theme, and
	 * child theme.
	 *
	 * @since  0.7.0
	 * @access public
	 * @return void
	 */
	public function constants() {

		// Sets the framework version number.
		define( 'HYBRID_VERSION', '3.1.0' );

		// Theme directory paths.
		define( 'HYBRID_PARENT', trailingslashit( get_template_directory() ) );
		define( 'HYBRID_CHILD', trailingslashit( get_stylesheet_directory() ) );

		// Theme directory URIs.
		define( 'HYBRID_PARENT_URI', trailingslashit( get_template_directory_uri() ) );
		define( 'HYBRID_CHILD_URI', trailingslashit( get_stylesheet_directory_uri() ) );

		// Sets the path to the core framework directory.
		if ( ! defined( 'HYBRID_DIR' ) ) {
			define( 'HYBRID_DIR', trailingslashit( HYBRID_PARENT . 'lib' . DS . basename( dirname( __FILE__ ) ) ) );
		}

		// Sets the path to the core framework directory URI.
		if ( ! defined( 'HYBRID_URI' ) ) {
			define( 'HYBRID_URI', trailingslashit( HYBRID_PARENT_URI . basename( dirname( __FILE__ ) ) ) );
		}

		// Core framework directory paths.
		define( 'HYBRID_ADMIN', trailingslashit( HYBRID_DIR . 'admin' ) );
		define( 'HYBRID_CLASSES', trailingslashit( HYBRID_DIR . 'classes' ) );
		define( 'HYBRID_FUNCTIONS', trailingslashit( HYBRID_DIR . 'functions' ) );
		define( 'HYBRID_TEMPLATES', trailingslashit( HYBRID_DIR . 'templates' ) );
		define( 'HYBRID_EXTENSIONS', trailingslashit( HYBRID_DIR . 'extensions' ) );
		define( 'HYBRID_CUSTOMIZE', trailingslashit( HYBRID_DIR . 'customize' ) );

		// Core framework directory URIs.
		define( 'HYBRID_CSS', trailingslashit( HYBRID_URI . 'css' ) );
		define( 'HYBRID_JS', trailingslashit( HYBRID_URI . 'js' ) );
	}

	/**
	 * Loads the core framework files.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function core() {

		// Load the class files.
		require_once( HYBRID_CLASSES . 'class-media-meta.php' );
		require_once( HYBRID_CLASSES . 'class-media-meta-factory.php' );
		require_once( HYBRID_CLASSES . 'class-media-grabber.php' );

		// Load the functions files.
		require_once( HYBRID_FUNCTIONS . 'functions-attr.php' );
		require_once( HYBRID_FUNCTIONS . 'functions-context.php' );
		require_once( HYBRID_FUNCTIONS . 'functions-customize.php' );
		require_once( HYBRID_FUNCTIONS . 'functions-filters.php' );
		require_once( HYBRID_FUNCTIONS . 'functions-fonts.php' );
		require_once( HYBRID_FUNCTIONS . 'functions-head.php' );
		require_once( HYBRID_FUNCTIONS . 'functions-meta.php' );
		require_once( HYBRID_FUNCTIONS . 'functions-sidebars.php' );
		require_once( HYBRID_FUNCTIONS . 'functions-scripts.php' );
		require_once( HYBRID_FUNCTIONS . 'functions-styles.php' );
		require_once( HYBRID_FUNCTIONS . 'functions-utility.php' );

		// Load the template files.
		require_once( HYBRID_TEMPLATES . 'template.php' );
		require_once( HYBRID_TEMPLATES . 'template-general.php' );
		require_once( HYBRID_TEMPLATES . 'template-media.php' );
		require_once( HYBRID_TEMPLATES . 'template-post.php' );
	}

	/**
	 * Adds theme support for features that themes should be supporting.  Also, removes
	 * theme supported features from themes in the case that a user has a plugin installed
	 * that handles the functionality.
	 *
	 * @since  1.3.0
	 * @access public
	 * @return void
	 */
	public function theme_support() {

		// Automatically add <title> to head.
		// add_theme_support( 'title-tag' );

		// Enable HTML5 markup support
		// http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
		// add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

		// Remove support for the the Breadcrumb Trail extension if the plugin is installed.
		if ( function_exists( 'breadcrumb_trail' ) || class_exists( 'Breadcrumb_Trail' ) ) {
			remove_theme_support( 'breadcrumb-trail' );
		}

		// Remove support for the the Cleaner Gallery extension if the plugin is installed.
		if ( function_exists( 'cleaner_gallery' ) || class_exists( 'Cleaner_Gallery' ) ) {
			remove_theme_support( 'cleaner-gallery' );
		}

		// Remove support for the the Get the Image extension if the plugin is installed.
		if ( function_exists( 'get_the_image' ) || class_exists( 'Get_The_Image' ) ) {
			remove_theme_support( 'get-the-image' );
		}
	}

	/**
	 * Loads the framework files supported by themes.  Functionality in these files should
	 * not be expected within the theme setup function.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	public function includes() {

		// Load the template hierarchy if supported.
		require_if_theme_supports( 'hybrid-core-template-hierarchy', HYBRID_TEMPLATES . 'template-hierarchy.php' );

		// Load the post format functionality if post formats are supported.
		require_if_theme_supports( 'post-formats', HYBRID_FUNCTIONS . 'functions-formats.php' );
		require_if_theme_supports( 'post-formats', HYBRID_CLASSES . 'class-chat.php' );

		// Load the Theme Layouts extension if supported.
		require_if_theme_supports( 'theme-layouts', HYBRID_CLASSES . 'class-layout.php' );
		require_if_theme_supports( 'theme-layouts', HYBRID_CLASSES . 'class-layout-factory.php' );
		require_if_theme_supports( 'theme-layouts', HYBRID_FUNCTIONS . 'functions-layouts.php' );
	}

	/**
	 * Load extensions (external projects).  Extensions are projects that are included
	 * within the framework but are not a part of it.  They are external projects
	 * developed outside of the framework.  Themes must use `add_theme_support( $extension )`
	 * to use a specific extension within the theme.  This should be declared on
	 * `after_setup_theme` no later than a priority of 11.
	 *
	 * @since  0.7.0
	 * @access public
	 * @return void
	 */
	public function extensions() {

		hybrid_require_if_theme_supports( 'breadcrumb-trail', HYBRID_EXTENSIONS . 'breadcrumb-trail.php' );
		hybrid_require_if_theme_supports( 'cleaner-gallery', HYBRID_EXTENSIONS . 'cleaner-gallery.php' );
		hybrid_require_if_theme_supports( 'get-the-image', HYBRID_EXTENSIONS . 'get-the-image.php' );
	}

	/**
	 * Load admin files for the framework.
	 *
	 * @since  0.7.0
	 * @access public
	 * @return void
	 */
	public function admin() {

		if ( is_admin() ) {
			require_once( HYBRID_ADMIN . 'admin.php' );
		}
	}
}
// }
