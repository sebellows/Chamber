<?php
/**
 * Template part for displaying Attractions posts in an Isotope application.
 * 
 * @package chamber
 */

use Chamber\Theme\Helper;

?>

<article <?php post_class('Card'); ?>>
    <div class="card">
        <?php if ( has_post_thumbnail() ) : ?>
        <div class="card-media">
            <a href="<?php esc_url(the_permalink()); ?>"><?php the_post_thumbnail( 'card-small' ); ?></a>
        </div>
        <?php endif; ?>

        <div class="card-content">
            <h3 class="card-title"><a href="<?php esc_url(the_permalink()); ?>"><?php the_title(); ?></a></h3>

            <?php if ( get_field('attr_city') ) : ?>
            <h4 class="card-meta"><?= the_field('attr_city'); ?></h4>
            <?php endif; ?>

            <?php
            $content = has_excerpt() ? get_the_excerpt() : get_the_content();
            $content = Helper::limit_content($content, 96, '<a class="continuedmark" href="' . esc_url( get_permalink() ) . '">&nbsp;&hellip;MORE</a>');
            ?>
            
            <span class="card-excerpt"><?= $content; ?></span>
        </div>

        <footer class="card-footer">
            <?php 
            $categories = collect(get_the_category())->take(3)->keyBy('name', 'term_id')->each(function($key) {
                ?>
                <a class="tag" href="<?= esc_url(get_category_link( $key->term_id )); ?>"><?= $key->name ?></a>
                <?php
            });
            ?>
        </footer>
    </div>
</article>
