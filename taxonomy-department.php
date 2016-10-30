<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package chamber
 */
// dd($taxonomy);
?>

<div class="grid"><?php get_template_part('templates/page', 'header'); ?></div>

<div class="grid">

    <?php while( have_posts()) : the_post(); ?>
        <?php get_template_part( 'templates/content/person' ); ?>
    <?php endwhile; ?>

</div>

