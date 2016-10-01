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

    /**
     * Get first paragraph of 'post_content'.
     *
     * If the post does not have an excerpt, fake one 
     * using the first paragraph of the post.
     * 
     * @param  int    $post_id         the post ID
     * @param  mixed  $post_content    the post content
     * @param  int    $character_count character limit for fake excerpt
     * @param  string $continued_mark  abbreviated text indication mark at end of fake excerpt
     * @return string                  the excerpt (or fake excerpt)
     */
    function get_first_paragraph($post_id, $post_content, $character_count, $continued_mark = '&hellip;') {
        $content = '';

        if (get_the_excerpt() === '') {
            $content = wpautop( $post_content );
            $content = preg_match_all('%(<p[^>]*>.*?</p>)%i', $content, $matches);
            $content = $matches [1] [0];
            $content = wordwrap($content, $character_count);
            $content = preg_replace("/&amp;/", "&",$content);
            $content = substr($content,0,strpos($content, "\n"));
            $content = $content . $continued_mark;
        }
        else {
            $post    = $post_id;
            $content = get_the_excerpt();
        }

        return $content;
    }

    /**
     * Get the first image from a post if it has one.
     *
     * If there is no feature-image for the post, try to 
     * use the first image from it if possible.
     * 
     * @param  int    $post_id      the post ID
     * @param  mixed  $post_content the post content
     * @param  string $classname    class name to append to the wrapper tag
     * @return mixed               the first image in the post content
     */
    function get_first_image($post_id, $post_content, $classname) {
      $first_img = '';

      if (get_the_post_thumbnail( $post_id ) === '') {
        ob_start();
        ob_end_clean();
        $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post_content, $matches);
        $first_img = $matches [1] [0];
        $first_img = '<img class="duplo-image" src="' . $first_img . '">';
      }
      else {
        $first_img = get_the_post_thumbnail( $post_id, 'large', ['class' => $classname]);
      }

      return $first_img;
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
                $content     = $post->get('post_content');
                $summary     = get_first_paragraph($id, $content, 96);
                $link        = get_permalink( $post->get('ID') );
                $image       = get_first_image($id, $content, 'duplo-image');
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
