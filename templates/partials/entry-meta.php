<?php
/**
 * Template part for displaying a entry meta.
 *
 * @package chamber
 */

?>

<div class="entry-meta">
	<time <?php hybrid_attr( 'entry-published' ); ?>><?= get_the_date(); ?></time>

	<?php if ( is_single() ) : ?>
		<hr class="dotted">
	<?php else : if ( has_category() ) : ?>
		<s> | </s>
	<?php endif; endif; ?>

	<?php hybrid_post_terms( [ 'taxonomy' => 'category', 'text' => __( 'Categories: %s', 'chamber' ) ] ); ?>

	<?php if ( has_tag() ) : ?>
		<s> | </s>
	<?php endif; ?>

	<?php hybrid_post_terms( [ 'taxonomy' => 'post_tag', 'text' => __( 'Tags: %s', 'chamber' ) ] ); ?>
</div>
