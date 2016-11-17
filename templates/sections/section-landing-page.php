<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package chamber
 */

# check if the flexible content field has rows of data
if ( have_rows('landing_page_content') ) : 

    while ( have_rows('landing_page_content') ) : the_row();

        get_template_part('templates/sections/section', 'duplo-landing-page');

        get_template_part('templates/sections/section', 'highlights');

        get_template_part('templates/sections/section', 'mediablock');

        get_template_part('templates/sections/section', 'whitesheet');

        get_template_part('templates/sections/section', 'keyresults');

        get_template_part('templates/sections/section', 'calls-to-action');

        get_template_part('templates/sections/section', 'connections');

        get_template_part('templates/sections/section', 'dynamic-whitesheet');

        get_template_part('templates/sections/section', 'gallery');

        get_template_part('templates/sections/section', 'contact');

    endwhile;

endif;