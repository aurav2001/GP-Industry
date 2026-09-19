<?php
/**
 * Homepage stats strip.
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$gpi_stats = array();
for ( $gpi_i = 1; $gpi_i <= 4; $gpi_i++ ) {
	$gpi_number = gpi_get_option( "stat_{$gpi_i}_number" );
	if ( '' === $gpi_number ) {
		continue;
	}
	$gpi_stats[] = array( $gpi_number, gpi_get_option( "stat_{$gpi_i}_label" ) );
}

if ( empty( $gpi_stats ) ) {
	return;
}
?>

<section class="stats-section">
	<div class="nova-container">
		<div class="stats-strip" data-reveal>
			<?php foreach ( $gpi_stats as $gpi_stat ) : ?>
				<div class="stat-item">
					<span class="stat-number" data-count="<?php echo esc_attr( $gpi_stat[0] ); ?>"><?php echo esc_html( $gpi_stat[0] ); ?></span>
					<?php if ( $gpi_stat[1] ) : ?>
						<span class="stat-label"><?php echo esc_html( $gpi_stat[1] ); ?></span>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
