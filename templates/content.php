<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package chamber
 */

$no_post_thumbnail = has_post_thumbnail() === false ? 'no-post-thumbnail' : null;
?>

<article <?php post_class($no_post_thumbnail); ?>>
	<header class="entry-header">
		<?php get_template_part('templates/entry-meta'); ?>
		<h3 class="entry-title"><a href="<?php esc_url(the_permalink()); ?>"><?php the_title(); ?></a></h3>
	</header>

	<?php if ( has_post_thumbnail() ) : ?>
	<div class="entry-media"><?php the_post_thumbnail( 'small' ); ?></div>
	<?php endif; ?>

	<div class="entry-content">
		<?php
		$content = has_excerpt() ? get_the_excerpt() : get_the_content();
		echo wpautop($content, false);
		?>
	</div>
</article>
