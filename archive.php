<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package chamber
 */

// Get the post types that will get the Isotope.js treatment from the config file.
$isotope = (new \Chamber\Config)->get('isotope');
// Get the names, not the labels
$posttypes = array_keys($isotope);

?>

<?php
if ( in_array( is_post_type_archive(), $posttypes ) ) :
	// get the post type name from the config file and make it plural if it's not.
	// Note: `get_post_type_object( get_post_type() )->rewrite['slug']` caused errors on category archive pages.
	$slug = substr($posttypes[0], -1) != 's' ? $posttypes[0] . 's' : $posttypes[0];
?>

<div id="archive-<?php echo $slug; ?>" class="isotope-archive">
	<?php 
	get_template_part('templates/menu', 'archive');
	?>
	<div class="card-grid">
	<?php
	while (have_posts()) : the_post();
		get_template_part('templates/content', 'archive-card');
	endwhile;
	?>
	</div>
</div><!-- .isotope-archive -->

<?php else : ?>

<div class="page-content">
	<?php
	get_template_part('templates/page', 'header');

	while (have_posts()) : the_post();
		get_template_part('templates/content', get_post_format());
	endwhile;
	?>

</div><!-- .page-content -->

<?php endif; ?>
