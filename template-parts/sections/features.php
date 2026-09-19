<?php
/**
 * Homepage features grid.
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$gpi_features = array();
for ( $gpi_i = 1; $gpi_i <= 6; $gpi_i++ ) {
	$gpi_title = gpi_get_option( "feature_{$gpi_i}_title", '' );
	if ( '' === $gpi_title ) {
		continue;
	}
	$gpi_features[] = array(
		'icon'  => gpi_get_option( "feature_{$gpi_i}_icon", 'bolt' ),
		'title' => $gpi_title,
		'text'  => gpi_get_option( "feature_{$gpi_i}_text", '' ),
	);
}

if ( empty( $gpi_features ) ) {
	return;
}
?>

<section id="features" class="features-section section-pad">
	<div class="nova-container">
		<?php
		gpi_section_heading(
			gpi_get_option( 'features_eyebrow', esc_html__( 'Why choose us', 'gp-industry' ) ),
			gpi_get_option( 'features_title', esc_html__( 'Built on quality, safety and reliability', 'gp-industry' ) ),
			gpi_get_option( 'features_text', esc_html__( 'From raw material to finished product, every step is controlled, tested and certified.', 'gp-industry' ) )
		);
		?>

		<div class="features-grid">
			<?php foreach ( $gpi_features as $gpi_index => $gpi_feature ) : ?>
				<div class="feature-card" data-reveal data-reveal-delay="<?php echo esc_attr( $gpi_index * 80 ); ?>">
					<div class="feature-icon"><?php gpi_the_icon( $gpi_feature['icon'], 24 ); ?></div>
					<h3 class="feature-title"><?php echo esc_html( $gpi_feature['title'] ); ?></h3>
					<?php if ( $gpi_feature['text'] ) : ?>
						<p class="feature-text"><?php echo esc_html( $gpi_feature['text'] ); ?></p>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
