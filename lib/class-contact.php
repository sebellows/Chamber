<?php

namespace Chamber\Theme;

/**
 * Class used for Contact Form Stripe.
 *
 * @package    Chamber Theme
 * @author     Sean Bellows <sean@seanbellows.com>
 * @copyright  Copyright (c) 2016, Sean Bellows
 * @link       https://github.com/sebellows/chamber
 * @license    http://www.gnu.org/licenses/gpl-3.0.html
 */
class Contact {

	/**
	 * Boot contact form module.
	 *
	 * @return void
	 */
	public function boot() {
		# Enqueue AJAX script for Contact Form located in Landing Page template.
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_contact_form_script' ] );
		# AJAX functionality for Contact Form located in Landing Page template.
		add_action( 'wp_ajax_chamber_contact_form', [ $this, 'contact_form_callback' ] );
		add_action( 'wp_ajax_nopriv_chamber_contact_form', [ $this, 'contact_form_callback' ] );
	}

	/**
	 * Enqueue scripts for using AJAX in the Contact Form.
	 *
	 * @return void
	 */
	public function enqueue_contact_form_script() {
		if ( is_page_template( 'landing-page.php' ) ) {
			$params = [
				'ajaxurl'       => admin_url( 'admin-ajax.php' ),
				'contact_nonce' => wp_create_nonce( 'chamber-contact-nonce' )
			];
			wp_enqueue_script( 'chamber/theme/js/contactform', get_template_directory_uri() . '/public/js/contact-form.js', [ 'jquery' ], null, true );
			wp_localize_script( 'chamber/theme/js/contactform', 'ajax_contactform', $params );
		}
	}

	/**
	 * Callback for Contact Form used to add AJAX support in `wp_ajax_` actions
	 *
	 * @return void  Echos out whether `wp_mail` was successfully sent
	 */
	public function contact_form_callback() {
		$errorMSG = '';

		$nonce = $_POST['contact_nonce'];

		if ( ! wp_verify_nonce( $nonce, 'chamber-contact-nonce' ) ) {
			wp_die( 'Wrong!' );
		}

		// NAME
		if ( empty( $_POST['name'] ) ) {
			$errorMSG = 'Name is required!';
		} else {
			$name = $_POST['name'];
		}

		// EMAIL
		if ( ! filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ) ) {
			$errorMSG .= 'Invalid Email address!';
		} else {
			$email = $_POST['email'];
		}

		// MESSAGE
		if ( empty( $_POST['message'] ) ) {
			$errorMSG .= 'Message is empty!';
		} else {
			$message = $_POST['message'];
		}

		// MAILTO (address to mail to)
		if ( empty( $_POST['mailto'] ) ) {
			$errorMSG = 'Mail to is required!';
		} else {
			$mailto = $_POST['mailto'];
		}

		$subject = 'Contact Form submission: ' . $_POST['title'];
		$headers = 'From: ' . $name . '<' . $email . '>';
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

		// prepare email body text
		$body = '';
		$body .= 'Name: ' . $name . '\r\n';
		$body .= 'E-Mail: ' . $email . '\r\n\r\n';
		$body .= 'Message: ' . $message . '\n';

		// send email
		$success = wp_mail( $mailto, $subject, nl2br( $body ), $headers );

		// redirect to success page
		if ( $success && $errorMSG == '' ) {
			echo 'success';
		} else {
			if ( $errorMSG == '' ) {
				echo 'Something went wrong :(';
			} else {
				echo $errorMSG;
			}
		}

		exit;
	}
}

// (new Contact)->boot();
