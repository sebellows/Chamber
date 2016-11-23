<?php

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

    $title = chamber_title();

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

            <?= Media\get_duplo_media( $post->ID, $counter, $index ); ?>

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

