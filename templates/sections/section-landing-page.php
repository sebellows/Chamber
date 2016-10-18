<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package chamber
 */

?>

<?php

// check if the flexible content field has rows of data
if ( have_rows('landing_page_content') ) : ?>

    <?php while ( have_rows('landing_page_content') ) : the_row(); ?>

        <?php get_template_part('templates/sections/section', 'duplo-landing-page'); ?>

        <?php get_template_part('templates/sections/section', 'highlights'); ?>

        <?php get_template_part('templates/sections/section', 'mediablock'); ?>

        <?php get_template_part('templates/sections/section', 'whitesheet'); ?>

        <?php get_template_part('templates/sections/section', 'keyresults'); ?>

        <?php get_template_part('templates/sections/section', 'calls-to-action'); ?>

        <?php get_template_part('templates/sections/section', 'connections'); ?>

    <?php endwhile; ?>

<?php endif; ?>