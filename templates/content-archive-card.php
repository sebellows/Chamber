<?php
/**
 * Template part for displaying Attractions posts in an Isotope application.
 * 
 * @package chamber
 */

use Chamber\Extras;

?>

<article <?php post_class('Card'); ?>>
	<div class="card">
		<?php if ( has_post_thumbnail() ) : ?>
		<a class="card-media" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'card-small' ); ?></a>
		<?php endif; ?>

		<div class="card-content">
			<h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

			<?php if ( get_field('attr_city') ) : ?>
			<h4 class="card-meta"><?php echo the_field('attr_city'); ?></h4>
			<?php endif; ?>

			<?php
			$content = has_excerpt() ? get_the_excerpt() : get_the_content();
			$content = \Chamber\Extras\limit_content($content, 96, '<a class="continuedmark" href="' . esc_url( get_permalink() ) . '">&nbsp;&hellip;MORE</a>');
			?>
			
			<span class="card-excerpt"><?php echo $content; ?></span>
		</div>

		<footer class="card-footer">
			<?php 
			$categories = collect(get_the_category())->take(3)->keyBy('name', 'term_id')->each(function($key) {
				?>
				<a class="tag" href="<?php echo get_category_link( $key->term_id ); ?>"><?php echo $key->name ?></a>
				<?php
			});
			?>
		</footer>
	</div>
</article>
