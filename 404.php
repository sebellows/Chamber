<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package chamber
 */
?>

<?php get_template_part('templates/page', 'header'); ?>

<div class="main-content callout" m-UI="dotted-border pad-thick">
	<p class="text-center"><?php _e('We’re sorry, the page you were looking for can’t be located.', 'chamber'); ?></p>
	<p class="text-center"><?php _e('You may have typed the address incorrectly. If you think this is the case, please try retyping the address and resubmitting the page. If you have arrived at this page from a bookmark, the page may no longer be available on the web.', 'chamber'); ?></p>
	<?php get_search_form(); ?>
</div>
