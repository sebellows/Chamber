<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package chamber
 */

use Chamber\Theme\Sidebar;

?>

<article <?php hybrid_attr( 'post' ); ?>>

	<header class="entry-header">
		<h1 <?php hybrid_attr( 'entry-title' ); ?>><?php single_post_title(); ?></h1>

		<?php if ( ! is_single() && is_active_sidebar('sidebar-page-header') ) : ?>
			<aside class="list-box">
				<?php dynamic_sidebar( 'sidebar-page-header' ); ?>
			</aside>
		<?php endif; ?>

		<?php if ( is_single() && ! is_singular( 'attraction' ) ) : ?>
		    <?php get_template_part( 'templates/partials/entry-meta' ); ?>
		<?php endif; ?>

		<?php if ( is_singular( 'attraction' ) ) : ?>
		    <?php get_template_part('templates/sections/section', 'attraction-meta'); ?>
		    <?php get_template_part('templates/sections/section', 'attraction-details'); ?>
		<?php endif; ?>

	</header><!-- .entry-header -->

  	<div <?php hybrid_attr( 'entry-content' ); ?>>

	    <?php get_the_image(
	      [
	        'size'         => 'medium_large',
	        'srcset_sizes' => [ 'medium' => '640w', 'large' => '1200w' ],
	        'order'        => [ 'featured' ],
	        'before'       => '<div class="featured-media">',
	        'after'        => '</div>',
	        'link'         => false
	      ]
	    ); ?>

	    <div class="entry-content-body">
	    	<?php the_content(); ?>
	    </div>

	    <footer>
	        <?php Sidebar::add('post-footer'); ?>
	    </footer>

	</div><!-- .entry-content -->

    <?php if ( is_singular( 'post' ) ) : ?>
	    <nav class="pager">
	      <?php previous_post_link( '%link', '<span class="dir"><svg class="icon" m-Icon="chevron-left large" viewbox="0 0 32 32"><use xlink:href="#icon-chevron-left"></use></svg></span> <span class="pager-text">Previous Article</span><h4>%title</h4>', '%title' ); ?>
	      <?php next_post_link(     '%link', '<span class="dir"><svg class="icon" m-Icon="chevron-right large" viewbox="0 0 32 32"><use xlink:href="#icon-chevron-right"></use></svg></span> <span class="pager-text">Next Article</span><h4>%title</h4></div>', '%title' ); ?>
	    </nav><!-- .pager -->
	<?php endif; ?>

</article><!-- .entry -->
