<?php
	/**
	 * The template for displaying search results pages.
	 *
	 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
	 *
	 * @package chamber
	 */
?>

<?php
if ( have_posts() ) : ?>

	<header class="page-header">
		<h1 class="page-title">Search Results for: <span class="search-query"><?php get_search_query(); ?></span></h1>
	</header><!-- .page-header -->

	<?php
	/* Start the Loop */
	while ( have_posts() ) : the_post();

		/**
		 * Run the loop for the search to output the results.
		 * If you want to overload this in a child theme then include a file
		 * called content-search.php and that will be used instead.
		 */
		get_template_part( 'templates/content', 'search' );

	endwhile;

	the_posts_navigation();

else :

	get_template_part( 'templates/content', 'none' );

endif; ?>

<!-- <form role="search" method="get" id="searchform" class="search-form" action="<?php # echo esc_url( home_url( '/' ) ); ?>">
	<a href="javascript:void(0)" role="button" class="search-toggle" data-toggle="searchForm">
		<span class="screen-reader-text">Access the search field</span>
		<span m-Icon="search small"><svg role="presentation"><use xlink:href="#search" viewbox="0 0 32 32"></use></svg></span>
	</a>
	<fieldset id="searchForm" data-toggler data-animate="hinge-in-from-top hinge-out-from-top">
		<label class="search-field-label">
			<span class="screen-reader-text">Search for:</span>
			<input type="search" placeholder="Search" value="<?php # echo get_search_query(); ?>" name="s" id="s" class="search-field">
		</label>
		<button class="search-submit" type="submit">
			<span m-Icon="arrow-right2 small"><svg role="presentation"><use xlink:href="#arrow-right2" viewbox="0 0 32 32"></use></svg></span>
		</button>
	</fieldset>
</form> -->