<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package chamber
 */

?>

<div class="page-content-body">

	<?php echo the_post_thumbnail(); ?>

	<div class="page-content-body-inner">

	<?php the_content(); ?>

	</div><!-- .page-content-body-inner -->

</div><!-- .page-content-body -->
<?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'chamber'), 'after' => '</p></nav>']); ?>
