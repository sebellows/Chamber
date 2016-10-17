<?php

use Chamber\Theme\Color;
use Chamber\Theme\Helper;

// check if the flexible content field has rows of data
if ( have_rows('duplo_block') ) :


    // To get a counter for adding a class to the duplo row that
    // gives us the number of blocks, we need to duplicate the 
    // `while` loop on the `duplo` rows. This is different
    // for repeater fields that are not nested in flexible content
    // fields where the counter can run outside of the `while` loop.
    // $counter = count( get_field('duplo_block') );

    while ( have_rows( 'duplo_block' ) ) : the_row();
        $instances = get_row('duplo_block');
    endwhile;

    $counter = count($instances);

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
                    $post        = get_sub_field('duplo_block_post');
                    $post        = collect($post[0]);
                    $id          = $post->get('ID');
                    $title       = $post->get('post_title');
                    $content     = $post->get('post_content');
                    $summary     = Helper::get_first_paragraph($id, $content, 96);
                    $link        = get_permalink( $post->get('ID') );
                    $image       = Helper::get_first_image($id, $content, 'duplo-image');
                ?>

                <div class="duplo" m-Duplo="<?= $index; ?>">
                    <?php if ($image) : ?>
                    <?= $image; ?>
                    <?php endif; ?>

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
