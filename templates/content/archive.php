<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package chamber
 */

use Chamber\Theme\Helper;

?>

<article <?php hybrid_attr( 'post' ); ?>>

	<div class="callout">

		<?php get_template_part( 'templates/partials/entry-header' ); ?>

		<div <?php hybrid_attr( 'entry-summary' ); ?>>
			<?php the_excerpt(); ?>
			<?php get_template_part( 'templates/partials/more-link' ); ?>
		</div><!-- .entry-summary -->

	</div><!-- .callout -->

</article>
