<?php

use Chamber\Theme\Color;

if( get_row_layout() == 'gallery_stripe' ) :

    $title    = get_sub_field( 'ch_gallery_title' );
    $summary  = get_sub_field( 'ch_gallery_summary' );
    $bg_color = get_sub_field( 'ch_background_color' );
    $images = get_sub_field( 'ch_gallery' );

    ?>

    <section class="stripe gallery">

        <div class="row" m-UI="<?= Color::set($bg_color); ?>"">

            <div class="callout gallery-body" m-Pad="medium large">

                <?php if ($title) : ?>
                    <h2><?= $title; ?></h2>
                <?php endif; ?>

                <?php if ($summary) : ?>
                    <?= $summary; ?>
                <?php endif; ?>
           
            </div>

            <?php if( $images ): ?>

            <figure class="multi-thumb">

                <?php foreach( $images as $image ): ?>

                    <div class="thumbnail">

                        <?php if (!empty($image['description'])) : ?>
                            <a href="<?= esc_url($image['description']); ?>">
                        <?php endif; ?>

                            <img src="<?= esc_url($image['url']); ?>" alt="<?= $image['alt']; ?>" width="<?= $image['width']; ?>" height="<?= $image['height']; ?>" />

                        <?php if (!empty($image['description'])) : ?>
                            </a>
                        <?php endif; ?>

                        <?php if ( $image['title'] || $image['caption'] ): ?>
                            <figcaption class="gallery-caption"><?php $image['title'] ? print_r($image['title']) : print_r($image['caption']); ?></figcaption>
                        <?php endif; ?>

                    </div>
                <?php endforeach; ?>

            </figure>

            <?php endif; ?>

        </div>

    </section>

<?php endif; ?>
