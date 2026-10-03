<?php
/**
 * Footer bottom bar.
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$gpi_copyright = gpi_get_option( 'footer_copyright', '' );
if ( $gpi_copyright ) {
	$gpi_copyright = str_replace( '{year}', gmdate( 'Y' ), $gpi_copyright );
} else {
	/* translators: 1: year, 2: site name */
	$gpi_copyright = sprintf( esc_html__( '© %1$s %2$s. All rights reserved.', 'gp-industry' ), gmdate( 'Y' ), get_bloginfo( 'name' ) );
}
?>

<div class="footer-bottom">
	<div class="footer-copyright"><?php echo wp_kses_post( $gpi_copyright ); ?></div>

	<div class="footer-bottom-links">
		<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Quality Assurance', 'gp-industry' ); ?></a>
		<span class="footer-bottom-sep" aria-hidden="true">•</span>
		<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Terms & Specifications', 'gp-industry' ); ?></a>
		<span class="footer-bottom-sep" aria-hidden="true">•</span>
		<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'ISO Compliance', 'gp-industry' ); ?></a>
	</div>

	<div class="footer-credit">
		<span class="footer-badge-tag">
			<span class="badge-dot" aria-hidden="true"></span>
			<?php esc_html_e( 'Industry 4.0 Standard', 'gp-industry' ); ?>
		</span>
	</div>
</div>
