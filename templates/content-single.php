<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package chamber
 */

?>

<?php while (have_posts()) : the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="post-header">
			<h1 class="post-title"><?php the_title(); ?></h1>

			<?php if (! is_singular( 'attraction' ) ) : ?>

				<?php get_template_part('templates/entry-meta'); ?>

			<?php else : ?>

				<?php get_template_part('templates/sections/section', 'attraction-meta'); ?>
				<?php get_template_part('templates/sections/section', 'attraction-details'); ?>

			<?php endif; ?>

		</header><!-- .post-header -->

		<div class="post-content">

			<?php echo the_post_thumbnail(); ?>

			<div class="post-content-body">
				<?php the_content(); ?>
			</div>

			<footer>
				<?php dynamic_sidebar( 'post-footer' ); ?>
			</footer>

		</div><!-- .post-content -->

		<div class="row">
			<?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'chamber'), 'after' => '</p></nav>']); ?>
		</div>

	</article><!-- #post-## -->

<?php endwhile; ?>