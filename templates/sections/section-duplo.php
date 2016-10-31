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

                    function get_srcset()
                    {

                    }

                    function set_thumbnail_srcset_to_background( $attachment_id, $selector, $sizes = [] )
                    {
                        $defaults = [
                            'small'  => 'medium-width',
                            'medium' => 'post-thumbnail-width',
                            'large'  => 'large-width',
                            'xlarge' => 'fullwidth-width'                            
                        ];

                        if ( empty($sizes) ) {
                            $sizes = $defaults;
                        }

                        $breakpoint_sizes = [ 'small', 'medium', 'large', 'xlarge' ];

                        $breakpoints = [
                            'small'  => [ 0, 639 ],
                            'medium' => [ 640, 1023 ],
                            'large'  => [ 1024, 1199 ],
                            'xlarge' => [ 1200, 9999 ]
                        ];

                        $srcset = [
                            'small'  => wp_get_attachment_image_src( $attachment_id, $sizes['small'] ),
                            'medium' => wp_get_attachment_image_src( $attachment_id, $sizes['medium'] ),
                            'large'  => wp_get_attachment_image_src( $attachment_id, $sizes['large'] ),
                            'xlarge' => wp_get_attachment_image_src( $attachment_id, $sizes['xlarge'] )
                        ];

                        if ( $attachment_id ) {
                            echo '<style>';

                            $smallest_image_url = '';
                            $smallest_width = 9999;
                            $min_width = 0;

                            foreach ( $srcset as $set ) {
                                foreach ( $breakpoint_sizes as $size ) {
                                    ?>
                                    @media (min-width: <?= $breakpoints[$size][0]; ?>px) and (max-width: <?= $breakpoints[$size][1]; ?>px) {
                                        <?= $selector; ?> {
                                            background-image: url("<?= $srcset[$size][0]; ?>");background-size:cover;background-position:50% 50%;background-repeat:no-repeat;
                                        }
                                    }
                                    <?php
                                }
                            }

                            echo '</style>';
                        }
                    }

                    function set_thumbnail_alt( $attachment_id )
                    {
                        return sprintf('<p class="screen-reader-text">' . get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) . '</p>');
                    }

                    function get_duplo_media( $attachment_id )
                    {
                        ?>
                        <div class="duplo-media">
                            <?php set_thumbnail_srcset_to_background( $attachment_id, '.duplo-image' ); ?>
                            <div class="duplo-image">
                                <?php set_thumbnail_alt( $attachment_id ); ?>
                            </div>
                            <div class="duplo-skrim" aria-hidden="true"></div>
                        </div>

                        <?php
                    }
                    ?>

                    <div class="duplo<?php !$image && $counter === 1 ? print_r(' duplo-hallmark"') : '' ?>"  m-Duplo="<?= $index++; ?>" m-UI="<?= Color::set($color_class); ?>">
                        <?php if ($image) : ?>
                            <?php get_duplo_media( $image['id'] ); ?>    
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

                    <?php if ($image) : ?>
                        <?php get_duplo_media( $post->ID ); ?>    
                    <?php endif; ?>

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
