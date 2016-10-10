<?php

use Chamber\Theme\Color;

if( get_row_layout('call_to_action_links') ) :

    if (have_rows('cta')) :

        // To get a counter for adding a class to the duplo row that
        // gives us the number of blocks, we need to duplicate the 
        // `while` loop on the `duplo_blocks` rows. This is different
        // for repeater fields that are not nested in flexible content
        // fields where the counter can run outside of the `while` loop.
        // 
        $counter = count( get_field("cta") );

        // loop through the `duplo_blocks` rows
        while ( have_rows('cta') ) : the_row();
            $counter++;
        endwhile;

    ?>

    <section class="stripe calls-to-action">

        <div class="row" m-Grid="<?php echo $counter; ?>">

            <?php while ( have_rows( 'cta' ) ) : the_row(); ?>

            <?php
                $title       = get_sub_field('cta_title');
                $summary     = get_sub_field('cta_summary');
                $link        = get_sub_field('cta_link');
                $color_class = Color::set(get_sub_field('cta_background_color'));
            ?>

            <?php if ($link) : ?>
            <a href="<?php echo $link ?>" class="callout cta-link" m-UI="<?php echo $color_class; ?>">

                <div class="cta-content">

                <?php if ($summary) : ?>
                    <small class="cta-summary"><?php echo $summary; ?></small>
                <?php endif; ?>
                
                <?php if ($title) : ?>
                    <h3 class="cta-title"><?php echo $title; ?></h3>
                <?php endif; ?>

                </div>            
            </a>
            <?php endif; ?>

            <?php endwhile; ?>

        </div><!-- END .row -->
    </section>

    <?php endif; ?>

<?php endif; ?>
