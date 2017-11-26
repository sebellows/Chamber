<?php

use Chamber\Theme\Helper;
use Chamber\Theme\Contact;

if ( get_row_layout() == 'contact_us' ) :

	// PHP mailer variables
	$mailto = str_replace( ' ', '', get_sub_field( 'contact_email' ) );
	$confirmation = get_sub_field( 'contact_confirmation_message' );

	// Stripe variables
	$title    = get_sub_field( 'contact_title' );
	$summary  = get_sub_field( 'contact_summary' );
	$bg_color = get_sub_field( 'contact_background_color' );


	?>

    <section class="stripe contact-us">
        <div class="row" m-UI="<?= chamber_color( $bg_color ); ?>"
        ">

		<?php if ( $title || $summary ) : ?>
        <div class="callout" m-Pad="medium large">
			<?php endif; ?>

			<?php if ( $title ) : ?>
                <h2><?= $title; ?></h2>
			<?php endif; ?>

			<?php if ( $summary ) : ?>
				<?= $summary; ?>
			<?php endif; ?>

			<?php if ( $title || $summary ) : ?>
        </div>
	<?php endif; ?>

        <div class="callout" m-Pad="medium large">

            <form role="form" id="contactForm" action="/submit-contact-form/" method="POST" data-abide="ajax">

                <div class="callout" id="msgSubmit" data-abide-error style="display: none;">
                    <p>
                        <span class="icon" m-Icon="warning small">
                            <svg role="presentation" viewbox="0 0 32 32">
                                <use xlink:href="#icon-bullhorn"></use>
                            </svg>
                        </span>
                        <span id="msgSubmitText"></span>
                    </p>
                </div>

                <label>Name:
                    <input type="text" id="name" name="username" placeholder="Enter name" required>
                    <span class="form-error">A name is required.</span>
                </label>

                <label>Email Address:
                    <input type="email" id="email" name="email" placeholder="yourname@site.com" required>
                    <span class="form-error">Email address is invalid. Please double-check and enter it again.</span>
                </label>

                <label style="display: none;">
                    <input type="url" id="url" name="url" data-abide-ignore>
                </label>

                <label>Message:
                    <textarea id="message" placeholder="Enter your message" cols="10" rows="5" required></textarea>
                    <span class="form-error">The message is empty.</span>
                </label>

                <input type="hidden" id="contact-title" value="<?php echo $title; ?>">
                <input type="hidden" id="contact-mailto" value="<?php echo $mailto; ?>">
                <input type="hidden" name="submitted" value="1" data-abide-ignore>

                <p><input type="submit" class="secondary hollow button" id="contactFormSubmit" value="Submit" name="buttonSubmit"></p>

				<?php wp_nonce_field( 'contact_nonce' ); ?>

            </form>

        </div>

        </div>

    </section><!-- .contact-us -->

<?php endif; ?>