<?php
/**
 * The template for displaying the entry meta.
 *
 * Contains the post time and author name.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package chamber
 */

$content_type = is_single() ? 'post' : 'entry';

?>

<div class="<?php echo $content_type; ?>-meta">
	<time class="updated" datetime="<?= get_post_time('c', true); ?>"><?= get_the_date('m.d.y'); ?></time>
</div><!-- .entry-meta -->
