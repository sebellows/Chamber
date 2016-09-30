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

?>

<span class="byline author vcard"><?= esc_html( get_the_author() ); ?></span><!--
--><s>&nbsp;|&nbsp;</s><wbr><!--
--><time class="updated" datetime="<?= get_post_time('c', true); ?>"><?= get_the_date('m.d.y'); ?></time>

<!-- <p class="byline author vcard"><?php /* __('By', 'chamber'); */ ?> <a href="<?php /* get_author_posts_url(get_the_author_meta('ID')); */ ?>" rel="author" class="fn"><?php /* get_the_author(); */ ?></a></p> -->