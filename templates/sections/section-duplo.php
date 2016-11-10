                                    <?php

use Chamber\Theme\Color;
use Chamber\Theme\Helper;
use Chamber\Theme\Media;

// check if the flexible content field has rows of data
if ( have_rows('duplo_block') ) :

    $customCount = 0;
    $postCount = 0;
    $counter = 0;
    // To get a counter for adding a class to the duplo row that
    // gives us the number of blocks, we need to duplicate the 
    // `while` loop on the `duplo` rows. This is different
    // for repeater fields that are not nested in flexible content
    // fields where the counter can run outside of the `while` loop.
    while ( have_rows( 'duplo_block' ) ) : the_row();
        $duploRow = get_row('duplo_block');

        if($duploRow['duplo_block_type'] == 'custom') {
            $customCount = $customCount + count($duploRow['duplo_block_custom']);
        }

        if($duploRow['duplo_block_type'] == 'post') {
            $postCount = $postCount + count($duploRow['duplo_block_post']);
        }

    endwhile;
    $counter = $customCount + $postCount;
?>

    <section class="duplo-banner duplo-set">

        <div class="duplo-blocks" m-DuploCount="<?= $counter; ?>">
            <?php 
                while ( have_rows( 'duplo_block' ) ) : the_row();
                $index = get_row_index();

                // Check whether it is a `relationship` (i.e., page, post, or taxonomy) or a `custom tile`
                $type = get_sub_field( 'duplo_block_type' );

                if ($type == 'custom') :
                    while ( have_rows( 'duplo_block_custom' ) ) : the_row();

                    $image        = get_sub_field('duplo_block_image');
                    $image_src    = wp_get_attachment_image_url( $image['id'], 'post-thumbnail' );
                    $image_srcset = wp_get_attachment_image_srcset( $image['id'], 'post-thumbnail' );
                    $title        = get_sub_field('duplo_block_title');
                    $summary      = get_sub_field('duplo_block_summary');
                    $link         = get_sub_field('duplo_block_link');
                    $color_class  = get_sub_field('duplo_block_background_color');
                    ?>

                    <div class="duplo<?php !$image && $counter === 1 ? print_r(' duplo-hallmark"') : '' ?>"  m-Duplo="<?= $index++; ?>" m-UI="<?= Color::set($color_class); ?>">

                        <?= Media\get_duplo_media( $image['id'], $counter, $index - 1 ); ?>

                        <div class="duplo-content">
                            <?php

                            if ($title) { echo '<h2 class="duplo-title">' . $title . '</h2>'; }

                            if ($summary) { echo $summary; }

                            ?>
                        </div>

                        <?php if ($link) : ?>
                            <a href="<?= $link; ?>" class="duplo-link"></a>
                        <?php endif; ?>
                    </div>

                    <?php endwhile; ?>

                <?php 

                elseif ($type == 'post') :
                    $post_id     = get_sub_field('duplo_block_post');
                    $post        = get_post($post_id[0]);
                    $title       = $post->post_title;
                    $content     = $post->post_content;
                    $summary     = $post->post_excerpt;
                    $link        = get_permalink($post->ID);
                    $alt_text    = get_post_meta($post_id, '_wp_attachment_image_alt', true);
                    $duploIndex  = $index+1;
                ?>

                <div class="duplo" m-Duplo="<?= $duploIndex; ?>">

                    <?= Media\get_duplo_media( $post, $counter, $duploIndex ); ?>

                    <div class="duplo-content">
                        <?php

                        if ($title) { echo '<h2>' . $title . '</h2>'; }

                        if ($summary) { echo '<p>' . $summary . '</p>'; }

                        ?>
                    </div>

                    <?php if ($link) : ?>
                        <a href="<?= $link; ?>" class="duplo-link"></a>
                    <?php endif; ?>
                </div>

                <?php 

                endif;

            endwhile;
            ?>

        </div>
    </section>

<?php endif; ?>

<?php wp_reset_postdata(); ?>