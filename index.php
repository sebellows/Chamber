<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package chamber
 */
?>

<?php get_template_part('templates/page', 'header'); ?>

<?php if (!have_posts()) : ?>
	<div class="alert alert-warning">
		<?php _e('Sorry, no results were found.', 'chamber'); ?>
	</div>
	<?php get_search_form(); ?>
<?php endif; ?>

<?php if ( have_posts() ) : // Checks if any posts were found. ?>

	<?php while ( have_posts() ) : // Begins the loop through found posts. ?>

		<?php the_post(); // Loads the post data. ?>
		<?php hybrid_get_content_template(); // Loads the content/*.php template. ?>

	<?php endwhile; ?>

<?php endif; ?>

<?php the_posts_navigation(); ?>
