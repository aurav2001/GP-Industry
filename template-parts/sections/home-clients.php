<?php
/**
 * Homepage: client / certification logos strip.
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$gpi_logos = array();
for ( $gpi_i = 1; $gpi_i <= 8; $gpi_i++ ) {
	$gpi_logo = gpi_get_option( "home_client_logo_{$gpi_i}", '' );
	if ( $gpi_logo ) {
		$gpi_logos[] = $gpi_logo;
	}
}
$gpi_names = $gpi_logos ? array() : gpi_parse_lines( gpi_get_option( 'home_clients_names' ), 1 );
if ( ! $gpi_logos && ! $gpi_names ) {
	return;
}
?>

<section id="clients" class="home-clients section-pad-sm">
	<div class="nova-container">
		<?php if ( gpi_get_option( 'home_clients_title' ) ) : ?>
			<p class="nova-clients-label" data-reveal><?php echo esc_html( gpi_get_option( 'home_clients_title' ) ); ?></p>
		<?php endif; ?>
		<div class="clients-grid" data-reveal>
			<?php foreach ( $gpi_logos as $gpi_logo ) : ?>
				<div class="nova-client"><img src="<?php echo esc_url( $gpi_logo ); ?>" alt="" loading="lazy"></div>
			<?php endforeach; ?>
			<?php foreach ( $gpi_names as $gpi_name ) : ?>
				<div class="nova-client"><span class="nova-client-name"><?php echo esc_html( $gpi_name[0] ); ?></span></div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
