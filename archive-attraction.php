<?php
/**
 * The template for displaying archive pages of custom post types.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Chamber
 */

// Get the post types that will get the Isotope.js treatment from the config file.
$isotope = (new \Chamber\Theme\Config)->get('isotope');

// Get the names, not the labels
$posttypes = array_keys($isotope);
?>

<div class="isotope-archive">

    <?php get_template_part('templates/archive/isotope', 'menu'); ?>

<?php 
if ( in_array( is_post_type_archive(), $posttypes ) ) :
    // get the post type name from the config file and make it plural if it's not.
    // Note: `get_post_type_object( get_post_type() )->rewrite['slug']` caused errors on category archive pages.
    $slug = substr($posttypes[0], -1) != 's' ? $posttypes[0] . 's' : $posttypes[0];

    $params = [
        'posts_per_page' => 100,
        'post_type' => $posttypes[0],
        'offset' => 100,
        'orderby' => 'rand'
    ];
    $archived = new WP_Query( $params );

    ?>

        <div class="card-grid">

            <?php while ($archived->have_posts()) : $archived->the_post(); ?>
                <?php get_template_part('templates/archive/isotope', 'card'); ?>
            <?php endwhile; ?>

        </div><!-- .card-grid -->

    </div><!-- .isotope-archive -->

<?php endif; ?>
