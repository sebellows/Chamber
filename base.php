<?php

use Chamber\Setup;
use Chamber\Wrapper;

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
			
			get_template_part('templates/menu');
		?>

		<div class="wrap container" role="document">
			<div id="#content" class="content">
				<main class="main">
					<?php include Wrapper\template_path(); ?>
				</main><!-- /.main -->
				<?php #if (Setup\display_sidebar()) : ?>
				<!-- <aside class="sidebar"> -->
					<?php #include Wrapper\sidebar_path(); ?>
				<!-- </aside> -->
				<!-- /.sidebar -->
				<?php #endif; ?>
			</div><!-- /.content -->
		</div><!-- /.wrap -->
		<?php
			do_action('get_footer');
			get_template_part('templates/footer');
			wp_footer();
		?>
	</body>

</html>
