<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package chamber
 */

get_template_part('templates/page', 'header');

while (have_posts()) : the_post();
	get_template_part( 'templates/content' );
endwhile;
