<?php
/**
 * Partial for displaying a Person's profile.
 *
 * @package Chamber
 */

$first_name = get_field( 'people_first_name' );
$last_name  = get_field( 'people_last_name' );
$initial    = get_field( 'people_middle_initial' );
$job_title  = get_field( 'people_job_title' );
$phone      = get_field( 'people_phone_number' );
$email      = get_field( 'people_email_address' );
$terms      = get_the_terms( $post->ID, 'department' );
$department = array_shift( $terms );

?>

<article <?php post_class( 'vcard' ); ?>>
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
		); ?>

        <div class="vcard-content">
            <dl class="vcard-list">
                <dt class="screen-reader-text">Name:</dt>
                <dd rel="name"><?= $first_name; ?><?php $initial ? print_r( $initial . '. ' ) : ''; ?><?= $last_name; ?></dd>
                <dt class="screen-reader-text">Department:</dt>
                <dd rel="department"><a href="<?= esc_url( get_permalink( print_r( $department->slug ) ) ); ?>"><?= $department->name; ?></a></dd>
                <dt class="screen-reader-text">Job title:</dt>
                <dd rel="job-title"><?= $job_title; ?></dd>
                <dt class="contact-full">Phone:</dt>
                <dd rel="phone" class="contact-full"><a href="tel:<?= $phone; ?>"><?= $phone; ?></a></dd>
                <dt class="contact-full">Email:</dt>
                <dd rel="email" class="contact-full"><a href="mailto:<?= $email ?>"><?= $email; ?></a></dd>
                <dd class="contact-mobile">
                    <a href="tel:<?= $phone; ?>"><span class="icon" m-Icon="phone medium"><svg aria-role="presentation" viewBox="0 1 24 24" style="fill:#005f96;"><use xlink:href="#icon-phone"></use></svg></span>
                    </a>
                    <a href="mailto:<?= $email; ?>"><span class="icon" m-Icon="email medium"><svg aria-role="presentation" viewBox="0 0 24 24" style="fill:#005f96;"><use xlink:href="#icon-email"></use></svg></span>
                    </a>
                </dd>
            </dl>
        </div>
    </div>
</article>
