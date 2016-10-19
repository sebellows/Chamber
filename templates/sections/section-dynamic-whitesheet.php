<?php

if( get_row_layout() == 'dynamic_white_sheet' ) :

    $title    = get_sub_field( 'dws_title' );
    $lead     = get_sub_field( 'dws_lead' );
    $summary  = get_sub_field( 'dws_summary' );
    $columns  = get_sub_field( 'dws_columns' );
    $option   = get_sub_field( 'dws_media_options' );

    ?>

    <section class="stripe dynamic-whitesheet">

        <?php if ( $option === 'carousel' ) : ?>

            <?php $images = get_sub_field( 'dws_carousel' ); ?>

            <?php if( $images ): ?>

            <figure id="carousel" class="carousel" data-flickity='{ "wrapAround": true, "lazyLoad": true, "pageDots": false, "accessibility": true, "setGallerySize": false }'>
                <?php foreach( $images as $image ): ?>
                    <div class="carousel-cell">
                        <img class="carousel-cell-image" data-flickity-lazyload="<?= esc_url($image['url']); ?>" alt="<?= $image['alt']; ?>" width="<?= $image['width']; ?>" height="<?= $image['height']; ?>" />
                        <figcaption class="carousel-caption">
                            <div class="carousel-caption-body" data-scroll-scope><!--
                                --><?php if ($image['title']) : echo '<h4>' . $image['title'] . '</h4>'; endif; ?><?= $image['caption']; ?><?= $image['description'] ?><!--
                            --></div>
                        </figcaption>
                    </div>
                <?php endforeach; ?>
            </figure>

            <?php endif; ?>

        <?php elseif ( $option === 'image' ) : ?>

            <?php $figure = get_sub_field( 'dws_image' ); ?>

            <figure class="poster-image">
                <img src="<?= esc_url($figure['url']); ?>" alt="<?= $figure['alt']; ?>" width="<?= $figure['width']; ?>" height="<?= $figure['height']; ?>" />
                <figcaption class="carousel-caption"><?= $figure['caption']; ?></figcaption>
            </figure>

        <?php endif; ?>

        <div class="row">

            <header class="callout whitesheet-header" m-Pad="medium large">

            <?php if ($title) : ?>
                <h2><?= $title; ?></h2>
            <?php endif; ?>

            </header>

            <div class="callout whitesheet-body" m-Pad="medium large">

            <?php if ($lead) : ?>
                <p class="lead"><?= $lead; ?></p>
            <?php endif; ?>

            <?php if ($summary) : ?>
                <div class="whitesheet-content" m-Cols="<?= $columns; ?>">
                    <?= $summary; ?>
                </div>
            <?php endif; ?>
           
            </div>
        </div>
    </section>

<?php endif; ?>
