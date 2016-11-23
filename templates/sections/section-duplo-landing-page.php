<?php

use Chamber\Theme\Helper;
use Chamber\Theme\Media;

if( get_row_layout('duplo_set') ) :

    if (have_rows('duplo')) :

    // To get a counter for adding a class to the duplo row that
    // gives us the number of blocks, we need to duplicate the 
    // `while` loop on the `duplo` rows. This is different
    // for repeater fields that are not nested in flexible content
    // fields where the counter can run outside of the `while` loop.
    // 
    $counter = count( the_field('duplo') );

    // loop through the `duplo` rows
    while ( have_rows('duplo') ) : the_row();
        $counter++;
    endwhile;

    ?>

    <section class="stripe duplo-set">

        <div class="duplo-blocks" m-DuploCount="<?= $counter; ?>">

            <?php 
                while ( have_rows( 'duplo' ) ) : the_row();

                $index = get_row_index();

                // Check whether it is a `relationship` (i.e., page, post, or taxonomy) or a `custom tile`
                $type = get_sub_field( 'duplo_type' );

                ?>

                <?php 
                if ($type == 'custom') :
                    while ( have_rows( 'duplo_custom' ) ) : the_row();

                    $image        = get_sub_field('duplo_image');
                    $title        = get_sub_field('duplo_title');
                    $summary      = get_sub_field('duplo_summary');
                    $link         = get_sub_field('duplo_link');
                    $color_class  = get_sub_field('duplo_background_color');
                    $text_only    = !$image ? ' display-type' : '';
                ?>

                <div class="duplo<?= $text_only; ?>" m-Duplo="<?= $index; ?>" m-UI="<?= chamber_color($color_class); ?>">

                    <?= Media\get_duplo_media( $image['id'], $counter, $index ); ?>

                    <div class="duplo-content">
                        <?php

                        if ($title) { echo '<h2>' . $title . '</h2>'; }

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
                    $post_object = get_sub_field('duplo_post');
                    $post_array  = $post_object[0];
                    $post        = get_post($post_array, ARRAY_A);
                    $post_id     = $post['ID'];
                    $title       = $post['post_title'];
                    $content     = $post['post_content'];
                    $summary     = $post['post_excerpt'];
                    $link        = get_permalink($post['ID']);
                    $alt_text    = get_post_meta($post_id, '_wp_attachment_image_alt', true);
                ?>

                <div class="duplo" m-Duplo="<?= $index; ?>">
                    <?= Media\get_duplo_media( $post['ID'], $counter, $index ); ?>

                    <div class="duplo-skrim" aria-hidden="true"></div>

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

                <?php endif; ?>

            <?php endwhile; ?>

        </div>
    </section>

    <?php endif; ?>

<?php endif; ?>
