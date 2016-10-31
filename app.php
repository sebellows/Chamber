<?php
/**
 * Template Name: Application
 *
 * @package chamber
 */

if ( is_page( 'data-grid-attractions' || 'attractions' ) ) {
	get_template_part('templates/app/attractions');
}
