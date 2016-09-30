<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package chamber
 */

use Chamber\SocialButton;

?>

<?php while (have_posts()) : the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>

			<?php if (! is_singular( 'attraction' ) ) : ?>

				<div class="entry-meta">

					<?php get_template_part('templates/entry-meta'); ?>

				</div><!-- .entry-meta -->

			<?php else : ?>

				<?php get_template_part('templates/sections/section', 'attraction-meta'); ?>
				<?php get_template_part('templates/sections/section', 'attraction-details'); ?>

			<?php endif; ?>

		</header><!-- .entry-header -->

		<div class="entry-content">

			<?php echo the_post_thumbnail(); ?>

			<div class="entry-content-body">
				<?php the_content(); ?>
			</div>

			<div class="share-menu">
				<h5>Share this:</h5>

				<?php 
					$social = SocialButton::render([
						[
							'name' => 'facebook',
							'url'  => 'https://facebook.com/sharer/sharer.php?u=https%3A%2F%2Fflintandgenesee.org'
						],
						[
							'name' => 'twitter',
							'url'  => 'https://twitter.com/intent/tweet/?text=&amp;url=https%3A%2F%2Fflintandgenesee.org'
						],
						[
							'name' => 'linkedin',
							'url'  => 'https://www.linkedin.com/shareArticle?mini=true&amp;url=https%3A%2F%2Fflintandgenesee.org&amp;title=&amp;summary=&amp;source=https%3A%2F%2Fflintandgenesee.org'
						],
						[
							'name' => 'google+',
							'url'  => 'https://plus.google.com/share?url=https%3A%2F%2Fflintandgenesee.org'
						],
						[
							'name' => 'email',
							'url'  => 'mailto:info@flintandgenesee.org?Subject=Hello,%20Flint%20%26%20Genesee!'
						]
					]);
				?>
			</div>
		</div><!-- .entry-content -->

		<footer>
			<div class="row">
				<?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'chamber'), 'after' => '</p></nav>']); ?>
			</div>
		</footer>
	</article><!-- #post-## -->

<?php endwhile; ?>