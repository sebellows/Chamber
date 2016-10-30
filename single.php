<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package chamber
 */
?>

<div class="row">
	<?php while (have_posts()) : the_post(); ?>
		<?php get_template_part('templates/content/page'); ?>
	<?php endwhile; ?>
</div>
