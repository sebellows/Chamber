<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package chamber
 */

// Get the post types that will get the Isotope.js treatment from the config file.
$isotope = (new \Chamber\Theme\Config)->get('isotope');
// Get the names, not the labels
$posttypes = array_keys($isotope);

?>

<?php
if ( in_array( is_post_type_archive(), $posttypes ) ) :
	// get the post type name from the config file and make it plural if it's not.
	// Note: `get_post_type_object( get_post_type() )->rewrite['slug']` caused errors on category archive pages.
	$slug = substr($posttypes[0], -1) != 's' ? $posttypes[0] . 's' : $posttypes[0];

	$params = [
	    'posts_per_page' => 100,
	    'post_type' => $posttypes[0],
	    'offset' => 100,
	    'orderby' => 'rand'
	];
	$archived = new WP_Query( $params );

?>

	<div id="archive-<?php echo $slug; ?>" class="isotope-archive">

		<?php get_template_part('templates/isotope', 'archive-menu'); ?>

		<div class="card-grid">

			<?php while ($archived->have_posts()) : $archived->the_post(); ?>
				<?php get_template_part('templates/isotope', 'archive-card'); ?>
			<?php endwhile; ?>

		</div>

	</div><!-- .isotope-archive -->

<?php else : ?>

	<div class="row">
		<?php get_template_part('templates/page', 'header'); ?>

		<?php while (have_posts()) : the_post(); ?>
			<?php get_template_part( 'templates/content' ); ?>
		<?php endwhile; ?>
	</div><!-- .row -->

</div><!-- .page-content -->

<?php endif; ?>
