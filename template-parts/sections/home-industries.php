<?php
/**
 * Homepage: industries we serve (icon cards).
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$gpi_items = gpi_parse_lines( gpi_get_option( 'home_industries_items' ), 3 );
if ( ! $gpi_items ) {
	return;
}
?>

<section id="industries" class="home-industries section-pad">
	<div class="nova-container">
		<?php gpi_section_heading( gpi_get_option( 'home_industries_eyebrow' ), gpi_get_option( 'home_industries_title' ), gpi_get_option( 'home_industries_text' ) ); ?>

		<div class="industries-grid">
			<?php foreach ( $gpi_items as $gpi_i => $gpi_item ) : ?>
				<div class="industry-card" data-reveal data-reveal-delay="<?php echo esc_attr( $gpi_i * 60 ); ?>">
					<div class="feature-icon"><?php gpi_the_icon( $gpi_item[0] ? $gpi_item[0] : 'cog', 22 ); ?></div>
					<div>
						<h3 class="industry-title"><?php echo esc_html( $gpi_item[1] ); ?></h3>
						<?php if ( $gpi_item[2] ) : ?>
							<p class="industry-text"><?php echo esc_html( $gpi_item[2] ); ?></p>
						<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
