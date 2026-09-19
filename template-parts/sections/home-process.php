<?php
/**
 * Homepage: numbered process steps.
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$gpi_steps = gpi_parse_lines( gpi_get_option( 'home_process_items' ), 2 );
if ( ! $gpi_steps ) {
	return;
}
?>

<section id="process" class="home-process section-pad">
	<div class="nova-container">
		<?php gpi_section_heading( gpi_get_option( 'home_process_eyebrow' ), gpi_get_option( 'home_process_title' ) ); ?>

		<div class="process-grid">
			<?php foreach ( $gpi_steps as $gpi_i => $gpi_step ) : ?>
				<div class="nova-step" data-reveal data-reveal-delay="<?php echo esc_attr( $gpi_i * 80 ); ?>">
					<p class="nova-step-number"><?php echo esc_html( sprintf( '%02d', $gpi_i + 1 ) ); ?></p>
					<h3 class="nova-step-title"><?php echo esc_html( $gpi_step[0] ); ?></h3>
					<?php if ( $gpi_step[1] ) : ?>
						<p class="nova-step-text"><?php echo esc_html( $gpi_step[1] ); ?></p>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
