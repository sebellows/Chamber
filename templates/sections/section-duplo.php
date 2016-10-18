<?php

use Chamber\Theme\Color;
use Chamber\Theme\Helper;

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
                        <?php if ($image) : ?>

                            <img 
                                class="duplo-image" 
                                src="<?= esc_url( $image_src ); ?>"
                                srcset="<?= esc_attr( $image_srcset ); ?>"
                                sizes="(max-width: 100vw) 480px"
                                alt="<?= $image['alt']; ?>"
                            >

                            <div class="duplo-skrim" aria-hidden="true"></div>
    
                        <?php endif; ?>

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
                    $post_object = get_sub_field('duplo_block_post');
                    $post_id     = $post_object[0];
                    $post        = get_post($post_id);
                    $title       = $post->post_title;
                    $content     = $post->post_content;
                    $summary     = $post->post_excerpt;
                    $link        = get_permalink($post->ID);
                ?>

                <div class="duplo" m-Duplo="<?= $index+1; ?>">
                    <?php
                        get_the_image([
                            'post_id'      => $post->ID,
                            'size'         => 'medium_large',
                            'srcset_sizes' => ['medium' => '640w', 'large' => '1200w'],
                            'order'        => [ 'featured', 'attachment' ],
                            'link'         => false,
                            'image_class'  => 'duplo-image'
                        ]);
                    ?>

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

                <?php 

                endif;

            endwhile;
            ?>

        </div>
    </section>

<?php endif; ?>
