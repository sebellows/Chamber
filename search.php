<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package chamber
 */

use Chamber\Theme\TemplateTags;
?>

<?php if ( have_posts() ) : ?>

	<header class="page-header search-header">

		<h1 class="page-title search-title">Search results for <span class="search-query"><?= get_search_query(); ?></span></h1>

		<h2>Would you like to try a new search?</h2>

		<p>If you didn't find what you were looking for, try again!</p>

		<form role="search" method="get" class="searchform search-form" action="<?= esc_url( home_url( '/' ) ); ?>">
			<div class="search-field-group">
				<label class="search-field-label">
					<span class="screen-reader-text">Search for:</span>
					<input type="search" placeholder="Search…" value="<?= get_search_query(); ?>" name="s" id="s" class="search-field">
				</label>
				<div class="search-button" m-UI="brand" type="submit">
					<input type="submit" class="search-submit" value="">
				</div>
			</div>
		</form>

	</header><!-- .search-header -->

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'templates/content' ); ?>

	<?php endwhile; ?>

	<div class="page-footer">
		<?php TemplateTags\post_pagination(); ?>
	</div>

<?php endif; ?>
