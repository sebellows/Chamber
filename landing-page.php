<?php
/**
 * Template Name: Landing Page
 */

?>

<div class="row">
	<?php while (have_posts()) : the_post(); ?>
		<?php get_template_part('templates/content/page'); ?>
	<?php endwhile; ?>
</div>

<?php get_template_part('templates/sections/section', 'landing-page'); ?>
