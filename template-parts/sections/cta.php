<?php
/**
 * Homepage call-to-action banner.
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$gpi_title = gpi_get_option( 'cta_title' );
$gpi_text  = gpi_get_option( 'cta_text' );
$gpi_btn   = gpi_get_option( 'cta_btn_text' );
$gpi_url   = gpi_get_option( 'cta_btn_url' );

if ( ! $gpi_title ) {
	return;
}
?>

<section id="contact" class="cta-section section-pad">
	<div class="nova-container">
		<div class="cta-banner" data-reveal>
			<div class="cta-orb" aria-hidden="true"></div>
			<h2 class="cta-title"><?php echo esc_html( $gpi_title ); ?></h2>
			<?php if ( $gpi_text ) : ?>
				<p class="cta-text"><?php echo esc_html( $gpi_text ); ?></p>
			<?php endif; ?>
			<?php if ( $gpi_btn ) : ?>
				<a href="<?php echo esc_url( $gpi_url ); ?>" class="btn btn-light btn-lg"><?php echo esc_html( $gpi_btn ); ?><?php gpi_the_icon( 'arrow-right', 18 ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</section>
