<?php
/**
 * Contact info card (from Customizer → Contact Info).
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$gpi_address = gpi_get_option( 'contact_address', '' );
$gpi_phone   = gpi_get_option( 'contact_phone', '' );
$gpi_email   = gpi_get_option( 'contact_email', '' );
$gpi_hours   = gpi_get_option( 'contact_hours', '' );
$gpi_compact = isset( $args['compact'] ) && $args['compact'];
?>

<div class="contact-card<?php echo $gpi_compact ? ' is-compact' : ''; ?>" data-reveal data-reveal-delay="120">
	<h3 class="contact-card-title"><?php echo $gpi_compact ? esc_html__( 'Talk to us', 'gp-industry' ) : esc_html__( 'Contact information', 'gp-industry' ); ?></h3>

	<?php if ( ! $gpi_address && ! $gpi_phone && ! $gpi_email && ! $gpi_hours ) : ?>
		<p class="contact-card-empty">
			<?php
			if ( current_user_can( 'edit_theme_options' ) ) {
				printf(
					wp_kses(
						/* translators: %s: customizer link */
						__( 'Add your address, phone and email under <a href="%s">Customize → GP-Industry Options → Contact Info</a>.', 'gp-industry' ),
						array( 'a' => array( 'href' => array() ) )
					),
					esc_url( admin_url( 'customize.php?autofocus[section]=gpi_contact' ) )
				);
			} else {
				esc_html_e( 'We would love to hear from you.', 'gp-industry' );
			}
			?>
		</p>
	<?php endif; ?>

	<ul class="contact-list">
		<?php if ( $gpi_address ) : ?>
			<li><span class="contact-icon"><?php gpi_the_icon( 'home', 18 ); ?></span><div><span class="contact-label"><?php esc_html_e( 'Address', 'gp-industry' ); ?></span><span class="contact-value"><?php echo nl2br( esc_html( $gpi_address ) ); ?></span></div></li>
		<?php endif; ?>
		<?php if ( $gpi_phone ) : ?>
			<li><span class="contact-icon"><?php gpi_the_icon( 'phone', 18 ); ?></span><div><span class="contact-label"><?php esc_html_e( 'Phone', 'gp-industry' ); ?></span><a class="contact-value" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $gpi_phone ) ); ?>"><?php echo esc_html( $gpi_phone ); ?></a></div></li>
		<?php endif; ?>
		<?php if ( $gpi_email ) : ?>
			<li><span class="contact-icon"><?php gpi_the_icon( 'message', 18 ); ?></span><div><span class="contact-label"><?php esc_html_e( 'Email', 'gp-industry' ); ?></span><a class="contact-value" href="mailto:<?php echo esc_attr( antispambot( $gpi_email ) ); ?>"><?php echo esc_html( antispambot( $gpi_email ) ); ?></a></div></li>
		<?php endif; ?>
		<?php if ( $gpi_hours && ! $gpi_compact ) : ?>
			<li><span class="contact-icon"><?php gpi_the_icon( 'clock', 18 ); ?></span><div><span class="contact-label"><?php esc_html_e( 'Hours', 'gp-industry' ); ?></span><span class="contact-value"><?php echo nl2br( esc_html( $gpi_hours ) ); ?></span></div></li>
		<?php endif; ?>
	</ul>

	<?php gpi_social_links( 'social-links contact-social' ); ?>
</div>
