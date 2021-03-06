<?php

if( get_row_layout('highlights') ) :

    if (have_rows('highlight')) :

        // To get a counter for adding a class to the highlight row that
        // gives us the number of blocks, we need to duplicate the 
        // `while` loop on the `highlight` rows. This is different
        // for repeater fields that are not nested in flexible content
        // fields where the counter can run outside of the `while` loop.
        // 
        $counter = count( get_field("highlight") );

        // loop through the `highlight` rows
        while ( have_rows('highlight') ) : the_row();
            $counter++;
        endwhile;

    ?>

    <section class="stripe highlights">
        <?php
            $color_class = get_sub_field('hl_background_color');
            $title = get_sub_field('hl_section_title');
        ?>
        <div class="row" m-Grid="<?= $counter; ?>" m-UI="<?= chamber_color($color_class); ?>">

            <h2 class="section-header"><?= $title; ?></h2>

            <?php while ( have_rows( 'highlight' ) ) : the_row(); ?>

            <?php
                $icon    = get_sub_field('hl_icon');
                $heading = get_sub_field('hl_title');
                $link    = get_sub_field('hl_link');
                $summary = get_sub_field('hl_summary');
            ?>

            <div class="callout highlight" m-Pad="medium large">

            <?php if ($link) : ?>

                <?php if ($icon) : ?>
                    <a href="<?= $link; ?>" class="icon" m-Icon="<?= substr(strstr($icon,'-'), 1); ?>"><?php #
                        ?><svg role="presentation"><use xlink:href="#<?= $icon; ?>" viewbox="0 0 24 24"></use></svg>
                    </a>
                <?php endif; ?>

                <?php if ($heading) : ?>
                    <h3>
                        <a href="<?= $link; ?>"><?php #
                            ?><?= $heading; ?><?php #
                        ?></a>
                    </h3>
                <?php endif; ?>

            <?php else : ?>

                <?php if ($icon) : ?>
                    <span class="icon" m-Icon="<?= substr(strstr($icon,'-'), 1); ?>">
                        <svg role="presentation"><use xlink:href="#<?= $icon; ?>" viewbox="0 0 24 24"></use></svg>
                    </span>
                <?php endif; ?>

                <?php if ($heading) : ?>
                    <h3><?= $heading; ?></h3>
                <?php endif; ?>

            <?php endif; ?>

            <?php if ($summary) : ?>
                <div><?= $summary; ?></div>
            <?php endif; ?>

            </div><!-- END .highlight -->

            <?php endwhile; ?>

        </div><!-- END .row -->
    </section><!-- END .stripe.highlights -->

    <?php endif; ?>

<?php endif; ?>
