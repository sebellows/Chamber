<?php
/**
 * The template for displaying indexed posts.
 * Used for the News Room.
 *
 * @link https://developer.wordpress.org/themes/basics/#home-page-display
 *
 * @package chamber
 */

use Chamber\Theme\Sidebar;
use Chamber\Theme\TemplateTags;

?>

<?php get_template_part( 'templates/sections/section', 'duplo-feed' ); ?>

<div class="page-content">
	<div id="main-feed" class="main-feed">

		<h2 class="feed-title">Recent Stories</h2>
	
		<div class="feed-box">
		<?php
			while (have_posts()) : the_post();
				get_template_part('templates/content', get_post_type() != 'post' ? get_post_type() : get_post_format());
			endwhile;
		
			// Previous/next page navigation.
			TemplateTags\post_pagination();
		?>
		</div>

	</div><!-- .news-feed -->
	
	<aside class="sidebar sidebar-column">
		<?php
		if ( is_active_sidebar('sidebar-column') ) :
			Sidebar::add('column');
		endif;
		?>
	</aside><!-- .sidebar-column -->

</div>
