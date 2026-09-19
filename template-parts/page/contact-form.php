<?php
/**
 * Built-in contact / quote form (used on the Contact Page template when no
 * form plugin is embedded in the content).
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$gpi_result = gpi_process_contact_form();
?>

<div class="gpi-form-wrapper">
	<?php gpi_contact_form_alert( $gpi_result ); ?>

	<form method="post" action="<?php echo esc_url( get_permalink() . '#contact-form' ); ?>" class="gpi-form" id="contact-form" novalidate>
		<?php wp_nonce_field( 'gpi_contact_action', 'gpi_contact_nonce' ); ?>
		<div class="gpi-hp" aria-hidden="true"><label>Website<input type="text" name="gpi_website" tabindex="-1" autocomplete="off"></label></div>

		<div class="gpi-form-grid">
			<div class="gpi-field">
				<label for="gpi_name"><?php esc_html_e( 'Full name', 'gp-industry' ); ?> <span class="required">*</span></label>
				<input type="text" name="gpi_name" id="gpi_name" required placeholder="<?php esc_attr_e( 'e.g. Rahul Sharma', 'gp-industry' ); ?>" value="<?php echo esc_attr( gpi_contact_form_value( 'gpi_name', $gpi_result ) ); ?>">
			</div>
			<div class="gpi-field">
				<label for="gpi_email"><?php esc_html_e( 'Email address', 'gp-industry' ); ?> <span class="required">*</span></label>
				<input type="email" name="gpi_email" id="gpi_email" required placeholder="name@company.com" value="<?php echo esc_attr( gpi_contact_form_value( 'gpi_email', $gpi_result ) ); ?>">
			</div>
			<div class="gpi-field">
				<label for="gpi_phone"><?php esc_html_e( 'Phone / WhatsApp', 'gp-industry' ); ?></label>
				<input type="tel" name="gpi_phone" id="gpi_phone" placeholder="+91 98765 43210" value="<?php echo esc_attr( gpi_contact_form_value( 'gpi_phone', $gpi_result ) ); ?>">
			</div>
			<div class="gpi-field">
				<label for="gpi_subject"><?php esc_html_e( 'Subject / enquiry type', 'gp-industry' ); ?></label>
				<input type="text" name="gpi_subject" id="gpi_subject" placeholder="<?php esc_attr_e( 'e.g. Quote for machined parts', 'gp-industry' ); ?>" value="<?php echo esc_attr( gpi_contact_form_value( 'gpi_subject', $gpi_result ) ); ?>">
			</div>
			<div class="gpi-field gpi-field-full">
				<label for="gpi_message"><?php esc_html_e( 'Your message / requirement', 'gp-industry' ); ?> <span class="required">*</span></label>
				<textarea name="gpi_message" id="gpi_message" rows="5" required placeholder="<?php esc_attr_e( 'Describe your requirement, quantities, materials, drawings…', 'gp-industry' ); ?>"><?php echo esc_textarea( gpi_contact_form_value( 'gpi_message', $gpi_result ) ); ?></textarea>
			</div>
		</div>

		<div class="gpi-form-actions">
			<button type="submit" class="btn btn-primary btn-lg"><?php esc_html_e( 'Send message', 'gp-industry' ); ?><?php gpi_the_icon( 'arrow-right', 18 ); ?></button>
			<p class="gpi-privacy-note"><?php gpi_the_icon( 'shield', 14 ); ?><?php esc_html_e( 'We respect your privacy and never share your data.', 'gp-industry' ); ?></p>
		</div>
	</form>
</div>
