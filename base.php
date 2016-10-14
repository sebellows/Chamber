<?php

use Chamber\Theme\Setup;
use Chamber\Theme\Sidebar;
use Chamber\Theme\Wrapper;

?>

<!doctype html>
<html <?php language_attributes(); ?>>
	<?php get_template_part('templates/head'); ?>
	<body <?php body_class(); ?>>
		<a class="skip-link show-on-focus" href="#content"><?php esc_html_e( 'Skip to content', 'chamber' ); ?></a>
		<!--[if IE]>
			<div class="callout" m-UI="warning">
				<?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'chamber'); ?>
			</div>
		<![endif]-->

		<?php get_template_part('public/images/chamber', 'sprite.svg') ?>

		<?php
			do_action('get_header');

			// Global site header
			get_template_part('templates/header');
		?>

		<?php if ( have_rows('duplo') || have_rows('duplo_block') || is_active_sidebar('sidebar-navigation') ) : ?>
		<section class="page-fold"><?php 
				get_template_part('templates/sections/section', 'duplo');
				if ( is_active_sidebar('sidebar-navigation') ) :
					Sidebar::add('navigation');
				endif;
		?></section>
		<?php endif; ?>

		<div id="#content" class="content" role="document">
			<main class="main">
				<?php include Wrapper\template_path(); ?>
			</main><!-- /.main -->
			<?php if (Sidebar::display()) : ?>
				<?php include Wrapper\sidebar_path(); ?>
			<?php endif; ?>
		</div><!-- /#content -->
		<?php
			do_action('get_footer');
			get_template_part('templates/footer');
			wp_footer();
		?>
	</body>

</html>
