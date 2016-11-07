<?php
/**
 * Template Name: Landing Page
 */

?>

<?php if ( have_rows('duplo_block') ) : ?>
	<div class="row">
		<?php while (have_posts()) : the_post(); ?>
			<?php get_template_part('templates/content/page'); ?>
		<?php endwhile; ?>
	</div>
<?php endif; ?>

<?php get_template_part('templates/sections/section', 'landing-page'); ?>
