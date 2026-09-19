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

	<?php if ( has_nav_menu( 'footer-menu' ) ) : ?>
		<nav class="footer-bottom-nav" aria-label="<?php esc_attr_e( 'Footer menu', 'gp-industry' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer-menu',
					'menu_class'     => 'footer-bottom-menu',
					'container'      => false,
					'depth'          => 1,
				)
			);
			?>
		</nav>
	<?php endif; ?>

	<div class="footer-credit">
		<?php
		/* translators: %s: heart icon */
		printf( esc_html__( 'Built with %s on WordPress', 'gp-industry' ), gpi_icon( 'heart', 14, 'heart-icon' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>
	</div>
</div>
