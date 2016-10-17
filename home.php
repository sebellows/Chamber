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

<div id="main-feed" class="main-feed">

	<h2 class="feed-title">Recent Stories</h2>

	<div class="feed-box">
		<?php while (have_posts()) : the_post(); ?>
			<?php get_template_part('templates/content', get_post_type() != 'post' ? get_post_type() : get_post_format()); ?>
		<?php endwhile; ?>		
		
		<?php TemplateTags\post_pagination(); // Previous/next page navigation. ?>
	</div>

</div><!-- .news-feed -->

<aside class="sidebar sidebar-column">
	<?php if ( is_active_sidebar('sidebar-column') ) : ?>
		<?php Sidebar::add('column'); ?>
	<?php endif; ?>
</aside><!-- .sidebar-column -->
