<?php

?>

<?php if( get_row_layout() == 'connections' ) : ?>

    <section class="stripe connections">

        <div class="row" m-UI="<?= chamber_color(get_sub_field('connection_background_color')); ?>">

            <?php $types = get_sub_field( 'connection_options' );  // Check whether it is a `relationship` (i.e., page, post, or taxonomy) or a `custom tile` ?>

                <?php foreach ($types as $type) { ?>

                    <?php if ($type == 'social') : ?>

                        <div class="callout social-callout">

                            <?php if (get_sub_field('social_lead')) : ?>
                                <span class="connection-lead"><?= get_sub_field('social_lead'); ?></span>
                            <?php endif; ?>

                            <?php if ( have_rows( 'social_link' ) ) : ?>
                                <?php while ( have_rows( 'social_link' ) ) : the_row(); ?>

                                <?php $icon = get_sub_field('connection_icon'); ?>
                                <?php $link = get_sub_field('connection_link'); ?>

                                <a href="<?= $link ?>" class="icon social-link" m-Icon="<?= $icon; ?> medium">
                                    <svg role="presentation" viewbox="0 0 32 32">
                                        <use xlink:href="#<?= $icon; ?>"></use>
                                    </svg>
                                </a>

                                <?php endwhile; ?>

                            <?php endif; ?>

                        </div>

                    <?php elseif ($type == 'newsletter') : ?>

                        <div class="callout newsletter-callout">

                            <?php if (get_sub_field('connection_invitation')) : ?>
                                <?= get_sub_field('connection_invitation'); ?>
                            <?php endif; ?>

                        </div>

                    <?php endif; ?>

                <?php } ?>
        </div><!-- END .row -->
    </section>

<?php endif; ?>
