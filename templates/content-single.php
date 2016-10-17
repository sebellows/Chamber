<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package chamber
 */

use Chamber\Theme\Sidebar;

?>

<?php while (have_posts()) : the_post(); ?>
	<article <?php hybrid_attr( 'post' ) ?>>
		<header class="post-header">
			<?php the_title( '<h1 ' . hybrid_get_attr( 'post-title' ) . '>', '</h1>' ); ?>

			<?php if (!is_singular( 'attraction' ) ) : ?>

				<div class="entry-meta">
					<time <?php hybrid_attr( 'post-published' ); ?>><?= get_the_date(); ?></time>
					<hr class="dotted">
					<?php hybrid_post_terms( [ 'taxonomy' => 'category', 'text' => __( 'Categories: %s', __NAMESPACE__ ) ] ); ?>
					<?php if ( has_category() && has_tag() ) { printf('<br>'); } ?>
					<?php hybrid_post_terms( [ 'taxonomy' => 'post_tag', 'text' => __( 'Tags: %s', __NAMESPACE__ ) ] ); ?>
				</div>

			<?php else : ?>

				<?php get_template_part('templates/sections/section', 'attraction-meta'); ?>
				<?php get_template_part('templates/sections/section', 'attraction-details'); ?>

			<?php endif; ?>

		</header><!-- .post-header -->

		<div <?php hybrid_attr( 'post-content' ); ?>>

			<?php get_the_image(
				[
					'size'         => 'medium_large',
					'srcset_sizes' => [ 'medium' => '640w', 'large' => '1200w' ],
					'order'        => [ 'featured' ],
					'before'       => '<div class="featured-media">',
					'after'        => '</div>',
					'link'         => false
				]
			);?>

			<div class="post-content-body">
				<?php the_content(); ?>
			</div>

			<footer>
				<?php Sidebar::add('post-footer'); ?>
			</footer>

		</div><!-- .post-content -->

	</article><!-- #post-## -->

<?php endwhile; ?>