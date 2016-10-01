<?php

use Chamber\Colors;

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
    // dd($counter);
    
    function getPostExcerpt($post_content, $character_count, $continued_mark = '&hellip;') {
        $content = wordwrap($post_content, $character_count);
        $content = preg_replace("/&amp;/", "&",$content);
        $content = substr($content,0,strpos($content, "\n"));

        return $content . $continued_mark;
    }

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
                $image       = get_sub_field('duplo_image');
                $title       = get_sub_field('duplo_title');
                $summary     = get_sub_field('duplo_summary');
                $link        = get_sub_field('duplo_link');
                $color_class = get_sub_field('duplo_background_color'); 
            ?>

            <div class="duplo" m-Duplo="<?php echo $index; ?>" m-UI="<?php echo Colors\set($color_class); ?>">
                <?php if ($image) : ?>
                    <img 
                        class="duplo-image" 
                        src="<?php echo $image['url']; ?>" 
                        srcset="<?php echo $image['url']; ?>" 
                        sizes="(max-width: 50em) 50vw, <?php echo $image['sizes']['medium']; ?>" 
                        width="<?php echo $image['width']; ?>"
                        height="<?php echo $image['height']; ?>" 
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
                $excerpt     = $post->get('post_excerpt');
                $summary     = !empty($excerpt) ? getPostExcerpt($post->get('post_content'), 96) : $excerpt;
                $link        = get_permalink( $post->get('ID') );
                $image       = get_the_post_thumbnail( $post->get('ID'), 'large', ['class' => 'duplo-image'] );
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
