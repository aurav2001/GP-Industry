<?php
/**
 * Homepage: FAQ accordion.
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$gpi_items = gpi_parse_lines( gpi_get_option( 'home_faq_items' ), 2 );
if ( ! $gpi_items ) {
	return;
}
?>

<section id="faq" class="home-faq section-pad">
	<div class="nova-container">
		<?php gpi_section_heading( gpi_get_option( 'home_faq_eyebrow' ), gpi_get_option( 'home_faq_title' ) ); ?>

		<div class="nova-faq faq-list" data-reveal>
			<?php foreach ( $gpi_items as $gpi_i => $gpi_item ) : ?>
				<details class="nova-faq-item"<?php echo 0 === $gpi_i ? ' open' : ''; ?>>
					<summary><?php echo esc_html( $gpi_item[0] ); ?></summary>
					<p><?php echo esc_html( $gpi_item[1] ); ?></p>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>
