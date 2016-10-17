<?php
/**
 * Template part for displaying a Person's profile.
 * 
 * @package chamber
 */

use Chamber\Theme\Helper;

$first_name = get_field('people_first_name');
$last_name  = get_field('people_last_name');
$initial    = get_field('people_middle_initial');
$job_title  = get_field('people_job_title');
$phone      = get_field('people_phone_number');
$email      = get_field('people_email_address');
$terms  = get_the_terms( $post->ID, 'department' );
$department = array_shift( $terms );
?>

<article <?php post_class('vcard'); ?>>
	<div class="vcard-profile">

		<?php get_the_image(
			[
				'size'         => 'small',
				'srcset_sizes' => [ 'thumbnail' => '150w', 'medium' => '640w' ],
				'order'        => [ 'featured' ],
				'before'       => '<div class="vcard-media">',
				'after'        => '</div>',
				'link'         => false
			]
		);?>

		<div class="vcard-content">
			<h3 class="vcard-title"><?= $first_name; ?> <?php $initial ? print_r($initial . '. ') : ''; ?><?= $last_name; ?></h3>

			<dl class="vcard-list">
				<dt class="screen-reader-text">Department: </dt>
				<dd rel="department"><?= $department->name; ?></dd>
				<dt class="screen-reader-text">Job title: </dt>
				<dd rel="job-title"><?= $job_title; ?></dd>
				<dt>Phone: </dt>
				<dd rel="phone"><?= $phone; ?></dd>
				<dt>Email: </dt>
				<dd rel="email"><a href="mailto:<?= $email ?>"><?= $email; ?></a></dd>
			</dl>
		</div>
	</div>
</article>
