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
// dd($media);
    ?>

    <section class="stripe media-block">

        <div class="row">

            <figure class="mediabox">
            <?php if ( $media_type['value'] == 'video' ) : ?>
                <?php
                    // @source https://support.advancedcustomfields.com/forums/topic/getting-just-the-url-that-was-entered-into-an-oembed-field-inside-a-variable/#post-17888/ 
                    $media = get_sub_field('mb_video', false, false);
                    $mediaURL = get_sub_field('mb_video');

                    // Get the ID of the embedded video.
                    // @source http://jeromejaglale.com/doc/php/youtube_generate_embed_from_url
                    $mediaID = preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $media, $matches);

                    // Get the iframe attributes to pass to JavaScript
                    $mediaAttrs = str_replace(['<iframe ', '></iframe>'], '', $mediaURL);
                    $id = $matches[1];
                    // create the video poster thumbnail from the ID.
                    // $poster_webp = 'https://i.ytimg.com/vi_webp/' . $id . '/sddefault.webp';
                    $poster = 'https://i.ytimg.com/vi/' . $id . '/';
                    // $mediaSize = getimagesize($poster);
                    $rootDir = get_stylesheet_directory();
                    // dd(theme_url());
                ?>
                <div class="flex-video widescreen media">
                    <img class="video-poster" src="<?= esc_url($poster . 'sddefault.jpg'); ?>" srcset="<?= esc_attr($poster . 'sddefault.jpg 853w, ' . $poster . 'hqdefault.jpg 640w, ' . $poster . 'maxresdefault.jpg 1280w'); ?>" sizes="(max-width: 100vw) 853px" alt="video poster image">
                    <button class="playButton" aria-label="Play video in modal window" data-open="videoPlayerReveal" data-url="<?= esc_attr(get_template_directory_uri() . '/media-player-modal.html'); ?>" data-media="<?= esc_attr($mediaAttrs); ?>">
                      <svg height="100%" version="1.1" viewBox="0 0 68 48" width="100%" style="pointer-events:none;"><path class="ytp-large-play-button-bg" d="m .66,37.62 c 0,0 .66,4.70 2.70,6.77 2.58,2.71 5.98,2.63 7.49,2.91 5.43,.52 23.10,.68 23.12,.68 .00,-1.3e-5 14.29,-0.02 23.81,-0.71 1.32,-0.15 4.22,-0.17 6.81,-2.89 2.03,-2.07 2.70,-6.77 2.70,-6.77 0,0 .67,-5.52 .67,-11.04 l 0,-5.17 c 0,-5.52 -0.67,-11.04 -0.67,-11.04 0,0 -0.66,-4.70 -2.70,-6.77 C 62.03,.86 59.13,.84 57.80,.69 48.28,0 34.00,0 34.00,0 33.97,0 19.69,0 10.18,.69 8.85,.84 5.95,.86 3.36,3.58 1.32,5.65 .66,10.35 .66,10.35 c 0,0 -0.55,4.50 -0.66,9.45 l 0,8.36 c .10,4.94 .66,9.45 .66,9.45 z" fill="#1f1f1e" fill-opacity="0.81"></path><path d="m 26.96,13.67 18.37,9.62 -18.37,9.55 -0.00,-19.17 z" fill="#fff"></path><path d="M 45.02,23.46 45.32,23.28 26.96,13.67 43.32,24.34 45.02,23.46 z" fill="#ccc"></path></svg>
                    </button>
                </div>
            <?php else : ?>
                <?php $media = get_sub_field('mb_image'); ?>
                <img src="<?= esc_url($media['url']); ?>" srcset="<?= $media['sizes']['small'] . ' ' . $media['sizes']['small-width'] . 'w,' . ' ' . $media['sizes']['large'] . ' ' . $media['sizes']['large-width'] . 'w,'; ?>" sizes="(max-width: 365px) 480px, (max-width: 701px) 768w, (max-width: 1025px) 480px, 1024px" alt="<?= $media['alt']; ?>">
            <?php endif; ?>
            </figure>

            <div class="callout" m-UI="<?= Color::set($color_class); ?>" m-Pad="medium large">

                <?php if ($rubric) : ?>
                    <h2 class="rubric"><?= $rubric; ?></h2>
                <?php endif; ?>

                <?php if ($title) : ?>
                    <h3><?= $title; ?></h3>
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
