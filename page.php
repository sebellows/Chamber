<?php while (have_posts()) : the_post(); ?>
	<div class="page-content">
		<?php get_template_part('templates/page', 'header'); ?>
		<?php get_template_part('templates/content', 'page'); ?>
	</div><!-- .main-content -->
<?php endwhile; ?>
