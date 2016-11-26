<?php
/**
 * The template for displaying archive pages of custom post types.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Chamber
 */

?>

<div id="app" class="isotope-archive">

    <?php get_template_part('menu/isotope'); ?>

    <?php
        $params = [
            'post_type' => 'attraction',
            'posts_per_page'   => -1,
            'orderby' => 'rand',
            'meta_query' => array(array('key' => '_thumbnail_id')) 
        ];
        $attractions_query = new WP_Query( $params );
    ?>

    <?php if ($attractions_query->have_posts()) : ?>

        <div class="card-grid">

            <?php while ($attractions_query->have_posts()) : $attractions_query->the_post(); ?>
                <?php get_template_part('templates/archive/attraction'); ?>
            <?php endwhile; ?>

        </div><!-- .card-grid -->

        <?php wp_reset_postdata(); ?>

    <?php endif; ?>

</div><!-- .isotope-archive -->
