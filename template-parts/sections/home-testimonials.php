<?php
/**
 * Homepage: testimonials.
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$gpi_items = gpi_parse_lines( gpi_get_option( 'home_testimonials_items' ), 3 );
if ( ! $gpi_items ) {
	return;
}
?>

<section id="testimonials" class="home-testimonials section-pad">
	<div class="nova-container">
		<?php gpi_section_heading( gpi_get_option( 'home_testimonials_eyebrow' ), gpi_get_option( 'home_testimonials_title' ) ); ?>

		<div class="testimonials-grid">
			<?php foreach ( $gpi_items as $gpi_i => $gpi_item ) : ?>
				<div class="nova-testimonial" data-reveal data-reveal-delay="<?php echo esc_attr( $gpi_i * 80 ); ?>">
					<p class="nova-testimonial-stars">★★★★★</p>
					<p class="nova-testimonial-text">“<?php echo esc_html( $gpi_item[0] ); ?>”</p>
					<p class="nova-testimonial-author">
						<strong><?php echo esc_html( $gpi_item[1] ); ?></strong>
						<?php if ( $gpi_item[2] ) : ?><br><?php echo esc_html( $gpi_item[2] ); ?><?php endif; ?>
					</p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
