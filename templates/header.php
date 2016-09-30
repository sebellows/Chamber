<?php
/**
 * The header for our theme.
 *
 * This is the template that displays the global header section.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package chamber
 */

use Chamber\Assets;

?>

<?php get_template_part('public/images/chamber', 'sprite.svg') ?>

<header id="masthead" class="site-header" role="banner">
	<div class="site-branding">

		<h1 class="site-title">
			<?php if ( get_header_image() ) : ?>
			<a class="site-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<span class="screen-reader-text"><?php bloginfo( 'name' ); ?></span>
				<img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php bloginfo( 'name' ); ?>">
			</a>
			<?php else : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
			<?php endif; // End header image check. ?>
		</h1>
	</div><!-- .site-branding -->

	<div class="top-bar top-bar--top">
		<div class="top-bar-left">

			<?php $description = get_bloginfo( 'description', 'display' ); ?>
			<?php if ( $description || is_customize_preview() ) : ?>
				<div class="site-description">
					<span class="screen-reader-text"><?php echo $description; ?></span>
					<?php if (strcmp(strtolower($description), 'see what\s possible')) : ?>
					<?php echo '<svg aria-role="presentation" viewBox="0 0 236 24" style="width:100%;max-width:236px;"><use xlink:href="' . Assets\asset_path('images/fgcc-tagline.svg#tagline') . '" /></svg>'; ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>

		</div><!-- .top-bar-left -->
		<div class="top-bar-right">

			<nav id="site-navigation" class="site-navigation" role="navigation">
				<!-- <button class="menu-toggle" aria-controls="site-menu" aria-expanded="false"><?php // esc_html_e( 'Site Menu', 'chamber' ); ?></button> -->
				<?php
				if (has_nav_menu('site_navigation')) :
				  wp_nav_menu(['theme_location' => 'site_navigation', 'menu_class' => 'menu']);
				endif;
				?>
			</nav><!-- #site-navigation -->
		</div><!-- .top-bar-right -->
	</div><!-- .top-bar-top -->

	<div class="top-bar top-bar--bottom">

		<!-- Phone number and general email address for Flint &amp; Genesee -->
		<dl class="site-contact" m-InlineList>
			<dt class="screen-reader-text">Contact Flint &amp; Genesee by phone or email</dt>
			<dd class="site-contact-info" rel="phone"><span class="contact-toggle" data-toggle="phoneNumber"></span><span class="icon" m-Icon="phone medium"><svg aria-role="presentation" viewBox="0 0 24 24" style="fill:#fefefe;"><use xlink:href="#icon-phone"></use></svg></span><span id="phoneNumber" class="show-for-large" data-toggler=".is-toggled">(810)-600-1404</span></dd>
			<dd class="site-contact-info"><a href="mailto:info@flintandgenesee.org"><span class="icon" m-Icon="email medium"><svg aria-role="presentation" viewBox="0 0 24 24" style="fill:#fefefe;"><use xlink:href="#icon-email"></use></svg></span><span id="emailAddress" class="show-for-large">info@flintandgenesee.org</span></a></dd>
		</dl>

		<!-- Search form toggle button for mobile and smaller viewports -->
		<button class="search-toggle" aria-controls="search-form" aria-expanded="false" data-toggle="searchForm">
			<span class="screen-reader-text">Access the search field</span>
			<span class="icon" m-Icon="search small"><svg role="presentation"><use xlink:href="#icon-search" viewbox="0 0 24 24"></use></svg></span>
		</button>

		<!-- Search form -->
		<?php get_search_form(true); ?>

		<!-- Department menu toggle button -->
		<div class="menu-backdrop" aria-presentation></div>
		<button class="menu-toggle" aria-controls="dept-menu" aria-expanded="false">
			<span class="screen-reader-text">Department Menu</span>
			<!-- <span class="icon" m-Icon="menu medium"><svg aria-role="presentation" viewBox="0 0 24 24" style="fill:#fefefe;"><use xlink:href="#icon-menu"></use></svg></span> -->
		    <span class="bar first"></span>
	        <span class="bar second"></span>
	        <span class="bar third"></span>
		</button>

	</div><!-- .top-bar-bottom -->

</header><!-- #masthead -->
