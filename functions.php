<?php
/**
 * chamber functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package chamber
 */

/**
 * Chamber includes
 *
 * The $chamber_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 */
$chamber_includes = [
	'lib/loader.php',			// Load theme customization modules
	'lib/config.php',			// Config file
	'lib/assets.php',			// Scripts and stylesheets
	'lib/helper.php',			// Helper functions
	'lib/extras.php',			// Custom functions
	'lib/menus.php',			// Theme setup
	'lib/sidebars.php',			// Theme setup
	'lib/setup.php',		 	// Theme setup
	'lib/metaboxes.php',		// Theme setup
	'lib/titles.php',			// Page titles
	'lib/wrapper.php',	 		// Theme wrapper class
	'lib/custom-header.php', 	// Implement the Custom Header feature
	'lib/customizer.php', 		// Customizer additions
	'lib/color.php', 			// Theme color helpers
	'lib/icon.php', 			// Icon helpers
	'lib/template-tags.php' 	// Custom template tags
];

foreach ($chamber_includes as $file) {
	if (!$filepath = locate_template($file)) {
		trigger_error(sprintf(__('Error locating %s for inclusion', 'chamber'), $file), E_USER_ERROR);
	}

	require_once $filepath;
}
unset($file, $filepath);
