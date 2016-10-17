<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package chamber
 */

$no_post_thumbnail = has_post_thumbnail() === false ? 'no-post-thumbnail' : null;
?>


<article <?php hybrid_attr( 'post' ); ?>>

	<?php if ( is_search() || is_archive() ) : ?>
	<div class="callout">
	<?php endif; ?>

		<header class="entry-header">
			<?php the_title( '<h2 ' . hybrid_get_attr( 'entry-title' ) . '><a href="' . get_permalink() . '" rel="bookmark" itemprop="url">', '</a></h2>' ); ?>
			<?php if (get_post_type() === 'post') : ?>
			<div class="entry-meta">
				<time <?php hybrid_attr( 'entry-published' ); ?>><?= get_the_date(); ?></time>
				<?php if ( has_category() ) { printf('<s> | </s>'); } ?>
				<?php hybrid_post_terms( [ 'taxonomy' => 'category', 'text' => __( 'Categories: %s', __NAMESPACE__ ) ] ); ?>
				<?php if ( has_tag() ) { printf('<s> | </s>'); } ?>
				<?php hybrid_post_terms( [ 'taxonomy' => 'post_tag', 'text' => __( 'Tags: %s', __NAMESPACE__ ) ] ); ?>
			</div>
			<?php endif; ?>
		</header><!-- .entry-header -->

		<?php if ( has_post_thumbnail() ) : ?>
		<div class="entry-media">
			<?php get_the_image( [ 'size' => 'small', 'order' => [ 'featured', 'attachment' ] ] ); ?>
		</div>
		<?php endif; ?>

		<div <?php hybrid_attr( 'entry-summary' ); ?>>
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->

	<?php if ( is_search() || is_archive() ) : ?>
	</div><!-- .callout -->
	<?php endif; ?>

</article>
