<?php

use Chamber\Theme\Color;
use Chamber\Theme\Helper;

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

    <section class="duplo-set">

        <div class="duplo-blocks" m-DuploCount="<?php echo $counter; ?>">

            <?php 
                while ( have_rows( 'duplo' ) ) : the_row();

                $index = get_row_index();

                // Check whether it is a `relationship` (i.e., page, post, or taxonomy) or a `custom tile`
                $type = get_sub_field( 'duplo_type' );

            ?>

            <?php if ($type == 'custom') :
                while ( have_rows( 'duplo_custom' ) ) : the_row();
                $image        = get_sub_field('duplo_image');
                $image_src    = wp_get_attachment_image_url( $image['id'], 'post-thumbnail' );
                $image_srcset = wp_get_attachment_image_srcset( $image['id'], 'post-thumbnail' );
                $title        = get_sub_field('duplo_title');
                $summary      = get_sub_field('duplo_summary');
                $link         = get_sub_field('duplo_link');
                $color_class  = get_sub_field('duplo_background_color');
            ?>

            <div class="duplo" m-Duplo="<?php echo $index; ?>" m-UI="<?php echo Color::set($color_class); ?>">
                <?php if ($image) : ?>
                    <img 
                        class="duplo-image" 
                        src="<?php echo esc_url( $image_src ); ?>"
                        srcset="<?php echo esc_attr( $image_srcset ); ?>"
                        sizes="(max-width: 100vw) 480px"
                        alt="<?php echo $image['alt']; ?>"
                    >
                <?php endif; ?>

                <div class="duplo-skrim" aria-hidden="true"></div>

                <div class="duplo-content">
                    <?php

                    if ($title) { echo '<h2>' . $title . '</h2>'; }

                    if ($summary) { echo $summary; }

                    ?>
                </div>

                <?php if ($link) : ?>
                    <a href="<?php echo $link; ?>" class="duplo-link"></a>
                <?php endif; ?>
            </div>

            <?php endwhile; ?>

            <?php endif; ?>


            <?php 
            if ($type == 'post') :

                $post        = get_sub_field('duplo_post');
                $post        = collect($post[0]);
                $id          = $post->get('ID');
                $title       = $post->get('post_title');
                $content     = $post->get('post_content');
                $summary     = Helper::get_first_paragraph($id, $content, 96);
                $link        = get_permalink( $post->get('ID') );
                $image       = Helper::get_first_image($id, $content, 'duplo-image');
            ?>

            <div class="duplo" m-Duplo="<?php echo $index; ?>">
                <?php if ($image) : ?>
                <?php echo $image; ?>
                <?php endif; ?>

                <div class="duplo-skrim" aria-hidden="true"></div>

                <div class="duplo-content">
                    <?php

                    if ($title) { echo '<h2>' . $title . '</h2>'; }

                    if ($summary) { echo '<p>' . $summary . '</p>'; }

                    ?>
                </div>

                <?php if ($link) : ?>
                    <a href="<?php echo $link; ?>" class="duplo-link"></a>
                <?php endif; ?>
            </div>

            <?php endif; ?>

        <?php endwhile; ?>

        </div>
    </section>

    <?php endif; ?>

<?php endif; ?>
