<?php
/**
 * Built-in contact / enquiry form processing (used by the Contact Page
 * template part and the course quick-enquiry form).
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Process a submitted built-in form once per request.
 *
 * @return array{status:string,message:string} status = '' | 'success' | 'error'.
 */
function gpi_process_contact_form() {
	static $result = null;
	if ( null !== $result ) {
		return $result;
	}
	$result = array( 'status' => '', 'message' => '' );

	if ( ! isset( $_POST['gpi_contact_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['gpi_contact_nonce'] ) ), 'gpi_contact_action' ) ) {
		return $result;
	}

	// Honeypot: bots fill every field.
	if ( ! empty( $_POST['gpi_website'] ) ) {
		$result = array( 'status' => 'success', 'message' => esc_html__( 'Thank you! Your message has been sent.', 'gp-industry' ) );
		return $result;
	}

	$name    = isset( $_POST['gpi_name'] ) ? sanitize_text_field( wp_unslash( $_POST['gpi_name'] ) ) : '';
	$email   = isset( $_POST['gpi_email'] ) ? sanitize_email( wp_unslash( $_POST['gpi_email'] ) ) : '';
	$phone   = isset( $_POST['gpi_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['gpi_phone'] ) ) : '';
	$subject = isset( $_POST['gpi_subject'] ) ? sanitize_text_field( wp_unslash( $_POST['gpi_subject'] ) ) : '';
	$message = isset( $_POST['gpi_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['gpi_message'] ) ) : '';

	if ( '' === $name || '' === $email || '' === $message ) {
		$result = array( 'status' => 'error', 'message' => esc_html__( 'Please fill in all required fields (Name, Email, Message).', 'gp-industry' ) );
		return $result;
	}
	if ( ! is_email( $email ) ) {
		$result = array( 'status' => 'error', 'message' => esc_html__( 'Please provide a valid email address.', 'gp-industry' ) );
		return $result;
	}

	$to = gpi_get_option( 'contact_email', '' );
	$to = is_email( $to ) ? $to : get_option( 'admin_email' );

	$site         = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );
	$mail_subject = '[' . $site . '] ' . ( $subject ? $subject : esc_html__( 'New enquiry', 'gp-industry' ) );
	$mail_body    = sprintf(
		"%s: %s\n%s: %s\n%s: %s\n%s: %s\n\n%s:\n%s\n\n--\n%s",
		esc_html__( 'Name', 'gp-industry' ),
		$name,
		esc_html__( 'Email', 'gp-industry' ),
		$email,
		esc_html__( 'Phone', 'gp-industry' ),
		$phone,
		esc_html__( 'Subject', 'gp-industry' ),
		$subject,
		esc_html__( 'Message', 'gp-industry' ),
		$message,
		esc_url( wp_get_referer() ? wp_get_referer() : home_url( '/' ) )
	);
	$headers = array( 'Content-Type: text/plain; charset=UTF-8', 'Reply-To: ' . $name . ' <' . $email . '>' );

	wp_mail( $to, $mail_subject, $mail_body, $headers );

	$result = array( 'status' => 'success', 'message' => esc_html__( 'Thank you! Your message has been sent successfully. We will contact you shortly.', 'gp-industry' ) );
	return $result;
}

/**
 * Print a success / error alert for the built-in form.
 *
 * @param array $result Result from gpi_process_contact_form().
 */
function gpi_contact_form_alert( $result ) {
	if ( empty( $result['status'] ) ) {
		return;
	}
	$ok = 'success' === $result['status'];
	printf(
		'<div class="gpi-alert gpi-alert-%1$s" role="alert"><span class="gpi-alert-icon">%2$s</span><div><strong>%3$s</strong><p>%4$s</p></div></div>',
		esc_attr( $result['status'] ),
		gpi_icon( $ok ? 'check' : 'close', 18 ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		$ok ? esc_html__( 'Sent!', 'gp-industry' ) : esc_html__( 'Please check the form', 'gp-industry' ),
		esc_html( $result['message'] )
	);
}

/**
 * Previously submitted value (kept after a validation error).
 *
 * @param string $field Field name.
 * @param array  $result Result from gpi_process_contact_form().
 * @return string
 */
function gpi_contact_form_value( $field, $result ) {
	if ( 'error' !== $result['status'] || ! isset( $_POST[ $field ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing -- verified in gpi_process_contact_form().
		return '';
	}
	return sanitize_text_field( wp_unslash( $_POST[ $field ] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
}
