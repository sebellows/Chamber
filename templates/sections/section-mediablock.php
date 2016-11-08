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
                    /**
                     * Get the url for the oembed field if video is the media-type.
                     *
                     * @source https://support.advancedcustomfields.com/forums/topic/getting-just-the-url-that-was-entered-into-an-oembed-field-inside-a-variable/#post-17888/ 
                     * 
                     * @var string  The URL
                     */
                    $mediaURL = get_sub_field('mb_video', false, false);

                    /**
                     * Get the entire field object.
                     * 
                     * @var mixed
                     */
                    $media = get_sub_field('mb_video');

                    function getYoutubeEmbedUrl($url)
                    {
                        $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9-_]+)\??/i';
                        $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))([a-zA-Z0-9-_]+)/i';

                        if (preg_match($longUrlRegex, $url, $matches)) {
                        $id = $matches[count($matches) - 1];
                        }

                        if (preg_match($shortUrlRegex, $url, $matches)) {
                        $id = $matches[count($matches) - 1];
                        }

                        return isset($id) ? $id : 'error';
                    }

                    /**
                     * Get the ID of the embedded video.
                     *
                     * @source http://jeromejaglale.com/doc/php/youtube_generate_embed_from_url
                     */
                    $mediaID = getYoutubeEmbedUrl($mediaURL);

                    /**
                     * Get the iframe attributes to pass to JavaScript.
                     * 
                     * @var string
                     */
                    $mediaAttrs = str_replace(['<iframe ', '></iframe>'], '', $media);
                    $hasWebP = strpos($mediaAttrs, 'webp') ? true : false;
                    $mediaAttrs = strpos($mediaAttrs, '640') !== false ? str_replace(['width="640"', 'height="'.'/\d+/'.'"'], ['width="853"', 'height="480"'], $media) : $mediaAttrs;
                ?>

                <script type="text/javascript">
                    var mediaID    = "<?= $mediaID; ?>";
                </script>
                <script type="text/javascript">
                    var mediaAttrs = "<?= base64_encode($mediaAttrs); ?>";
                </script>
                <script type="text/javascript">
                    var hasWebP = "<?= $hasWebP; ?>";
                </script>

                <div class="flex-video widescreen media"></div>

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
                        <?= $more_text; ?>&ensp;<span class="icon" m-Icon="small fat-arrow"><svg role="presentation"><use xlink:href="#icon-fat-arrow"></use></svg></span>
                    </a>
                <?php endif; ?>
         
            </div>

        </div>
    </section>

<?php #endif; ?>

<?php endif; ?>
