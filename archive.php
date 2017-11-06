<?php
/**
 * The template for displaying archive pages.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package chamber
 */
?>

<div class="row">

    <div class="page-content-body">

        <?php get_template_part('templates/page', 'header'); ?>

        <?php while (have_posts()) : the_post(); ?>
            <?php get_template_part('templates/content/archive'); ?>
        <?php endwhile; ?>

    </div>
    
</div>