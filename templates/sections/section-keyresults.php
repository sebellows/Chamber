<?php

use Chamber\Theme\Color;

if( get_row_layout('key_results') ) :

    if (have_rows('result')) :

        // To get a counter for adding a class to the duplo row that
        // gives us the number of blocks, we need to duplicate the 
        // `while` loop on the `duplo_blocks` rows. This is different
        // for repeater fields that are not nested in flexible content
        // fields where the counter can run outside of the `while` loop.
        // 
        $counter = count( get_field("result") );

        // loop through the `duplo_blocks` rows
        while ( have_rows('result') ) : the_row();
            $counter++;
        endwhile;

    ?>

    <section class="stripe key-results">

        <div class="row" m-UI="<?php echo Color::set(the_sub_field('background_color')); ?>">

            <header class="callout section-header" m-Pad="medium large">
                <h2><?php echo the_sub_field('results_title'); ?></h2>
            </header>

            <div class="row" m-Grid="<?php echo $counter; ?>">

                <?php while ( have_rows( 'result' ) ) : the_row(); ?>

                <?php
                    $number  = get_sub_field('result_number');
                    $summary = get_sub_field('result_summary');
                ?>

                <div class="callout result" m-Pad="medium large">
                
                <?php if ($number) : ?>
                    <div class="result-number"><?php echo $number; ?></div>
                <?php endif; ?>
                
                <?php if ($summary) : ?>
                    <div><?php echo $summary; ?></div>
                <?php endif; ?>
                
                </div>

                <?php endwhile; ?>

            </div><!-- END .row .row -->

        </div><!-- END .row -->
    </section>

    <?php endif; ?>

<?php endif; ?>
