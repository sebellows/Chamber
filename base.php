<?php

use Chamber\Theme\Setup;
use Chamber\Theme\Sidebar;
use Chamber\Theme\Wrapper;

?>

<!doctype html>
<html <?php language_attributes( 'html' ); ?>>

	<?php get_template_part( 'templates/head' ); ?>

	<body <?php hybrid_attr( 'body' ); ?>>

		<a class="skip-link show-on-focus" href="#content"><?php esc_html_e( 'Skip to content', 'chamber' ); ?></a>

		<!--[if IE]>
			<div class="callout" m-UI="warning">
				<?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'chamber'); ?>
			</div>
		<![endif]-->

		<?php get_template_part('public/images/chamber', 'sprite.svg'); // load the SVG spritesheet ?>

		<?php
			do_action('get_header');

			// Global site header
			get_template_part('templates/header');
		?>

		<?php if ( have_rows('duplo_block') || is_home() || is_active_sidebar('sidebar-navigation') ) : ?>
			<section class="page-fold">

				<?php if ( !is_home() ) : ?>
					<?php get_template_part('templates/sections/section', 'duplo'); ?>
				<?php endif; ?>

				<?php if ( is_home() ) : ?>
					<?php get_template_part( 'templates/sections/section', 'duplo-feed' ); ?>
				<?php endif; ?>

				<?php if ( is_active_sidebar('sidebar-navigation') ) : ?>
					<?php Sidebar::add('navigation'); ?>
				<?php endif; ?>

			</section>
		<?php endif; ?>

		<div class="container" role="document">

			<main <?php hybrid_attr( 'content' ); ?>>

				<?php hybrid_get_menu( 'breadcrumbs' ); // Loads the menu/breadcrumbs.php template. ?>

				<?php if ( !is_page_template('landing-page.php') && !is_post_type_archive() && !is_singular('person') ) : ?>
				<div class="row">
				<?php endif; ?>

				<?php include Wrapper\template_path(); ?>

				<?php locate_template( [ 'menu/loop-nav.php' ], true ); // Loads the misc/loop-nav.php template. ?>

				<?php if ( !is_page_template('landing-page.php') && !is_post_type_archive() && !is_singular('person') ) : ?>
				</div><!-- .row -->
				<?php endif; ?>

			</main><!-- /#content -->

			<?php if ( !is_archive() && !is_search() && !is_404() && !is_singular('person') ) : ?>
				<?php include Wrapper\sidebar_path(); ?>
			<?php endif; ?>

		</div>

		<?php do_action('get_footer'); ?>
		<?php get_template_part('templates/footer'); ?>
		<?php wp_footer(); ?>

	</body>

</html>
