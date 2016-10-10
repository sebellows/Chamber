<?php
/**
 * The template for displaying indexed posts.
 * Used for the News Room.
 *
 * @link https://developer.wordpress.org/themes/basics/#home-page-display
 *
 * @package chamber
 */
?>

<?php get_template_part( 'templates/sections/section', 'featured-posts' ); ?>

<div class="sleeve">
	<div id="news-feed" class="compartment news-feed">

		<h2 class="feed-title">Recent Stories</h2>
	
		<?php
			while (have_posts()) : the_post();
				get_template_part('templates/content', get_post_type() != 'post' ? get_post_type() : get_post_format());
			endwhile;


			// Previous/next page navigation.
			\Chamber\Theme\TemplateTags\post_pagination();
		?>

	</div><!-- .news-feed -->
	
	<aside id="news-sidebar" class="sidebar sidebar-news">
		<?php dynamic_sidebar( 'sidebar-news' ); ?>
	</aside><!-- #news-sidebar -->

</div>
