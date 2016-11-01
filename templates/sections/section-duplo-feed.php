<?php

use Chamber\Theme\Titles;
use Chamber\Theme\Media;

$args = array(
    'posts_per_page' => 3,
    'meta_key' => 'featured-post-meta',
    'meta_value' => 'yes'
);
$featured = new WP_Query($args);

if ($featured->have_posts()) : 

    // Count the number of Duplos (start at '1' in order to count header)
    $counter = 1;

    while($featured->have_posts()) : $featured->the_post();
        $counter++;
    endwhile;

    $title = Titles\title();

?>

<section class="duplo-feed duplo-set">

    <div class="duplo-blocks" m-DuploCount="<?= $counter; ?>">

        <header class="duplo news-header" m-Duplo="1">
            <h1><?= wordwrap($title,3,"<br>\n"); ?></h1>
        </header>

        <?php
            while($featured->have_posts()) : $featured->the_post();

            $index = $featured->current_post + 2;
        ?>

        <div class="duplo" m-Duplo="<?= $index; ?>">

            <?php if ( has_post_thumbnail() ) : ?>
                <div class="duplo-media">
                    <div class="duplo-image" style="background-image:url(<?= get_the_post_thumbnail_url( $post->ID, 'medium_large' ); ?>);">
                        <?php if ( !empty($alt_text) ) : ?>
                            <p class="screen-reader-text"><?= $alt_text; ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="duplo-skrim" aria-hidden="true"></div>
                </div>
            <?php endif; ?>

            <div class="duplo-content">
                <time><?= get_the_date('F j, Y'); ?></time>
                <h2><?php the_title(); ?></h2>
                <?php if ( $index === 2 ) : ?>
                    <p><?php the_excerpt();?></p>
                <?php endif; ?>
            </div>

            <a href="<?php the_permalink(); ?>" class="duplo-link"></a>
        </div>

        <?php endwhile; ?>

    </div>

</section>

<?php endif; ?>

