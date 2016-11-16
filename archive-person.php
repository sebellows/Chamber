<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package chamber
 */
?>

<div class="grid"><?php get_template_part('templates/page', 'header'); ?></div>

<?php

$departments = get_terms('department');

foreach($departments as $department) {
    wp_reset_query();
    $args = [
        'post_type' => 'person',
        'posts_per_page' => -1,
        'meta_key' => 'people_weight',
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
        'tax_query' => [
            [
                'taxonomy' => 'department',
                'field' => 'slug',
                'terms' => $department->slug,
            ],
        ],
    ];

    $loop = new WP_Query($args);

    if ( $loop->have_posts() ) :
    ?>

        <div class="grid-section-header"><h3 class="list-title"><?= $department->name ?></h3></div>

        <div class="grid">

            <?php while($loop->have_posts()) : $loop->the_post(); ?>
                <?php get_template_part( 'templates/content/person' ); ?>
            <?php endwhile; ?>

        </div>

    <?php endif; ?>

<?php } ?>
