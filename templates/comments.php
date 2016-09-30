<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package chamber
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<section id="comments" class="comments">
	<?php if (have_comments()) : ?>
		<h2><?php printf(_nx('One response to &ldquo;%2$s&rdquo;', '%1$s responses to &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'chamber'), number_format_i18n(get_comments_number()), '<span>' . get_the_title() . '</span>'); ?></h2>

		<ol class="comment-list">
			<?php wp_list_comments(['style' => 'ol', 'short_ping' => true]); ?>
		</ol>

		<?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
			<nav>
				<ul class="pager">
					<?php if (get_previous_comments_link()) : ?>
						<li class="previous"><?php previous_comments_link(__('&larr; Older comments', 'chamber')); ?></li>
					<?php endif; ?>
					<?php if (get_next_comments_link()) : ?>
						<li class="next"><?php next_comments_link(__('Newer comments &rarr;', 'chamber')); ?></li>
					<?php endif; ?>
				</ul>
			</nav>
		<?php endif; ?>
	<?php endif; // have_comments() ?>

	<?php if (!comments_open() && get_comments_number() != '0' && post_type_supports(get_post_type(), 'comments')) : ?>
		<div class="alert alert-warning">
			<?php _e('Comments are closed.', 'chamber'); ?>
		</div>
	<?php endif; ?>

	<?php comment_form(); ?>
</section>
