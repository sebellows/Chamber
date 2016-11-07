<?php
/**
 * Template Name: Landing Page
 */

function empty_content($str) {
    return trim(str_replace('&nbsp;','',strip_tags($str))) == '';
}

?>

<?php get_template_part('templates/sections/section', 'landing-page'); ?>
