<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package chamber
 */

use Chamber\Theme\Helper;

$no_post_thumbnail = has_post_thumbnail() === false ? 'no-post-thumbnail' : null;
$abbreviated_content = Helper::limit_content_length( get_the_content(), 300 );
?>


<article <?php hybrid_attr( 'post' ); ?>>

	<?php get_template_part( 'templates/partials/entry-header' ); ?>

	<?php get_the_image(
		[
			'size'         => 'small',
			'order'        => [ 'featured' ],
			'before'       => '<div class="entry-media">',
			'after'        => '</div>',
			'link'         => true
		]
	); ?>

	<div <?php hybrid_attr( 'entry-summary' ); ?>>
		<?php if ( has_excerpt() ) : ?>
			<?php the_excerpt(); ?>
		<?php else : ?>
			<?= wp_trim_words( get_the_content(), 60, '&hellip;' ); ?>
		<?php endif; ?>
		<?php get_template_part( 'templates/partials/more-link' ); ?>
	</div><!-- .entry-summary -->

</article>
