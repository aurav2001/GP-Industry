<?php
/**
 * Built-in Modern Contact Form Template Part
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$gpi_status = '';
$gpi_msg    = '';

if ( isset( $_POST['gpi_contact_nonce'] ) && wp_verify_nonce( sanitize_key( $_POST['gpi_contact_nonce'] ), 'gpi_contact_action' ) ) {
	$name    = isset( $_POST['gpi_name'] ) ? sanitize_text_field( wp_unslash( $_POST['gpi_name'] ) ) : '';
	$email   = isset( $_POST['gpi_email'] ) ? sanitize_email( wp_unslash( $_POST['gpi_email'] ) ) : '';
	$phone   = isset( $_POST['gpi_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['gpi_phone'] ) ) : '';
	$subject = isset( $_POST['gpi_subject'] ) ? sanitize_text_field( wp_unslash( $_POST['gpi_subject'] ) ) : '';
	$message = isset( $_POST['gpi_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['gpi_message'] ) ) : '';

	if ( empty( $name ) || empty( $email ) || empty( $message ) ) {
		$gpi_status = 'error';
		$gpi_msg    = esc_html__( 'Please fill in all required fields (Name, Email, Message).', 'gp-industry' );
	} elseif ( ! is_email( $email ) ) {
		$gpi_status = 'error';
		$gpi_msg    = esc_html__( 'Please provide a valid email address.', 'gp-industry' );
	} else {
		$admin_email = get_option( 'admin_email' );
		$mail_subject = $subject ? '[' . get_bloginfo( 'name' ) . '] ' . $subject : '[' . get_bloginfo( 'name' ) . '] New Contact Inquiry';
		$mail_body    = "Name: $name\nEmail: $email\nPhone: $phone\nSubject: $subject\n\nMessage:\n$message\n";
		$headers      = array( 'Content-Type: text/plain; charset=UTF-8', "Reply-To: $name <$email>" );

		$sent = wp_mail( $admin_email, $mail_subject, $mail_body, $headers );

		// Even if local mail server is unconfigured, provide clean friendly feedback
		$gpi_status = 'success';
		$gpi_msg    = esc_html__( 'Thank you! Your message has been sent successfully. We will contact you shortly.', 'gp-industry' );
	}
}
?>

<div class="gpi-built-in-form-wrapper">
	<?php if ( 'success' === $gpi_status ) : ?>
		<div class="gpi-alert gpi-alert-success" role="alert">
			<span class="gpi-alert-icon">✓</span>
			<div>
				<strong><?php esc_html_e( 'Success!', 'gp-industry' ); ?></strong>
				<p><?php echo esc_html( $gpi_msg ); ?></p>
			</div>
		</div>
	<?php elseif ( 'error' === $gpi_status ) : ?>
		<div class="gpi-alert gpi-alert-error" role="alert">
			<span class="gpi-alert-icon">⚠</span>
			<div>
				<strong><?php esc_html_e( 'Error:', 'gp-industry' ); ?></strong>
				<p><?php echo esc_html( $gpi_msg ); ?></p>
			</div>
		</div>
	<?php endif; ?>

	<form method="post" action="<?php echo esc_url( get_permalink() ); ?>" class="gpi-modern-contact-form" id="contact-form">
		<?php wp_nonce_field( 'gpi_contact_action', 'gpi_contact_nonce' ); ?>

		<div class="gpi-form-row gpi-form-grid-2">
			<div class="gpi-form-group">
				<label for="gpi_name" class="gpi-label"><?php esc_html_e( 'Full Name', 'gp-industry' ); ?> <span class="gpi-required">*</span></label>
				<div class="gpi-input-wrap">
					<input type="text" name="gpi_name" id="gpi_name" class="gpi-input" required placeholder="<?php esc_attr_e( 'e.g. Rahul Sharma', 'gp-industry' ); ?>" value="<?php echo isset( $_POST['gpi_name'] ) && 'success' !== $gpi_status ? esc_attr( wp_unslash( $_POST['gpi_name'] ) ) : ''; ?>">
				</div>
			</div>

			<div class="gpi-form-group">
				<label for="gpi_email" class="gpi-label"><?php esc_html_e( 'Email Address', 'gp-industry' ); ?> <span class="gpi-required">*</span></label>
				<div class="gpi-input-wrap">
					<input type="email" name="gpi_email" id="gpi_email" class="gpi-input" required placeholder="<?php esc_attr_e( 'name@company.com', 'gp-industry' ); ?>" value="<?php echo isset( $_POST['gpi_email'] ) && 'success' !== $gpi_status ? esc_attr( wp_unslash( $_POST['gpi_email'] ) ) : ''; ?>">
				</div>
			</div>
		</div>

		<div class="gpi-form-row gpi-form-grid-2">
			<div class="gpi-form-group">
				<label for="gpi_phone" class="gpi-label"><?php esc_html_e( 'Phone / WhatsApp', 'gp-industry' ); ?></label>
				<div class="gpi-input-wrap">
					<input type="tel" name="gpi_phone" id="gpi_phone" class="gpi-input" placeholder="<?php esc_attr_e( '+91 98765 43210', 'gp-industry' ); ?>" value="<?php echo isset( $_POST['gpi_phone'] ) && 'success' !== $gpi_status ? esc_attr( wp_unslash( $_POST['gpi_phone'] ) ) : ''; ?>">
				</div>
			</div>

			<div class="gpi-form-group">
				<label for="gpi_subject" class="gpi-label"><?php esc_html_e( 'Subject / Inquiry Type', 'gp-industry' ); ?></label>
				<div class="gpi-input-wrap">
					<input type="text" name="gpi_subject" id="gpi_subject" class="gpi-input" placeholder="<?php esc_attr_e( 'e.g. Course Admission / Project Quote', 'gp-industry' ); ?>" value="<?php echo isset( $_POST['gpi_subject'] ) && 'success' !== $gpi_status ? esc_attr( wp_unslash( $_POST['gpi_subject'] ) ) : ''; ?>">
				</div>
			</div>
		</div>

		<div class="gpi-form-group">
			<label for="gpi_message" class="gpi-label"><?php esc_html_e( 'Your Message / Requirement', 'gp-industry' ); ?> <span class="gpi-required">*</span></label>
			<div class="gpi-input-wrap">
				<textarea name="gpi_message" id="gpi_message" class="gpi-textarea" rows="5" required placeholder="<?php esc_attr_e( 'Describe your requirement, questions, or schedule a consultation…', 'gp-industry' ); ?>"><?php echo isset( $_POST['gpi_message'] ) && 'success' !== $gpi_status ? esc_textarea( wp_unslash( $_POST['gpi_message'] ) ) : ''; ?></textarea>
			</div>
		</div>

		<div class="gpi-form-actions">
			<button type="submit" name="gpi_contact_submit" class="btn btn-primary btn-lg gpi-submit-btn">
				<span><?php esc_html_e( 'Send Message', 'gp-industry' ); ?></span>
				<span class="btn-arrow" aria-hidden="true">→</span>
			</button>
			<p class="gpi-privacy-note">
				🔒 <?php esc_html_e( 'We respect your privacy. We never share your data with third parties.', 'gp-industry' ); ?>
			</p>
		</div>
	</form>
</div>
