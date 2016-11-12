<?php
/**
 * Template part for displaying a "Read More" link.
 *
 * @package chamber
 */

$permalink = has_excerpt() ? get_permalink($post->ID) : get_permalink();
?>

<a class="readmore" href="<?= $permalink; ?>">Read More&nbsp;<span class="icon" m-Icon="xsmall"><svg role="presentation" viewBox="0 0 32 32"><use xlink:href="#icon-fat-arrow"></use></svg></span></a>