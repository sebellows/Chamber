<?php
/**
 * Template part for displaying a entry meta.
 *
 * @package chamber
 */

?>

<header class="entry-header">

	<?php the_title( '<h2 ' . hybrid_get_attr( 'entry-title' ) . '><a href="' . get_permalink() . '" rel="bookmark" itemprop="url">', '</a></h2>' ); ?>

	<?php if ( get_post_type() === 'post' ) : ?>
		<?php get_template_part( 'templates/partials/entry-meta' ); ?>
	<?php endif; ?>

</header><!-- .entry-header -->
