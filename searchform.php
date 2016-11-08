<?php
	/**
	 * Custom search form for theme.
	 *
	 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
	 *
	 * @package chamber
	 */
?>

<form role="search" method="get" id="searchForm" class="search-form" data-toggler data-animate="hinge-in hinge-out" action="<?= esc_url( home_url( '/' ) ); ?>">
	<label class="search-field-label">
		<span class="screen-reader-text">Search for:</span>
		<input type="search" placeholder="Search" value="<?= get_search_query(); ?>" name="s" id="s" class="search-field">
	</label>
	<button id="search-submit" class="button icon-button" type="submit">
		<span class="icon" m-Icon="arrow-wide-right small"><svg role="presentation"><use xlink:href="#icon-arrow-wide-right" viewbox="0 0 32 32"></use></svg></span>
	</button>
</form>