<?php
/**
 * Trust strip under page heroes: stats from the Customizer as compact pills.
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$gpi_pills = array();
for ( $gpi_i = 1; $gpi_i <= 4; $gpi_i++ ) {
	$gpi_number = gpi_get_option( "stat_{$gpi_i}_number" );
	if ( '' !== $gpi_number ) {
		$gpi_pills[] = array( $gpi_number, gpi_get_option( "stat_{$gpi_i}_label" ) );
	}
}
if ( ! $gpi_pills ) {
	return;
}
?>

<div class="trust-strip">
	<div class="nova-container">
		<ul class="trust-pills" data-reveal>
			<?php foreach ( $gpi_pills as $gpi_pill ) : ?>
				<li><strong><?php echo esc_html( $gpi_pill[0] ); ?></strong><span><?php echo esc_html( $gpi_pill[1] ); ?></span></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
