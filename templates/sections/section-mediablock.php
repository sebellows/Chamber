<?php

use Chamber\Theme\Color;

if( get_row_layout() == 'media_block' ) :

    $media_type  = get_sub_field( 'mb_media' );
    $rubric      = get_sub_field( 'mb_rubric' );
    $title       = get_sub_field( 'mb_title' );
    $summary     = get_sub_field( 'mb_summary' );
    $more_text   = !empty(get_sub_field( 'mb_more_link_text' )) ? get_sub_field( 'mb_more_link_text' ) : 'Learn more';
    $more_link   = get_sub_field( 'mb_more_link' );
    $color_class = get_sub_field('mb_background_color');

    $media = $media_type['value'] == 'video' ? get_sub_field('mb_video') : get_sub_field('mb_image');

    ?>

    <section class="stripe media-block">

        <div class="row">

            <figure class="mediabox">
                <div class="flex-video widescreen media"><?= $media; ?></div>
            </figure>

            <div class="callout" m-UI="<?= Color::set($color_class); ?>" m-Pad="medium large">

                <?php if ($rubric) : ?>
                    <h2 class="rubric"><?= $rubric; ?></h2>
                <?php endif; ?>

                <?php if ($title) : ?>
                    <h2><?= $title; ?></h2>
                <?php endif; ?>

                <?php if ($summary) : ?>
                    <?= $summary; ?>
                <?php endif; ?>
               
                <?php if ($more_link) : ?>
                    <a class="readmore" href="<?= $more_link; ?>">
                        <?= $more_text; ?>&ensp;<span class="icon" m-Icon="small square-plus"><svg role="presentation"><use xlink:href="#icon-square-plus"></use></svg></span>
                    </a>
                <?php endif; ?>
         
            </div>

        </div>
    </section>

<?php #endif; ?>

<?php endif; ?>
