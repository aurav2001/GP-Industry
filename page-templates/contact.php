<?php
/**
 * Template Name: Contact Page
 * Template Post Type: page
 *
 * Hero + two columns: your content (drop a form shortcode / form block here) and
 * the contact info card from Customizer → Contact Info + optional Google Map.
 *
 * @package GPIndustry
 */

get_header();

while ( have_posts() ) :
	the_post();

	get_template_part(
		'template-parts/page/page-hero',
		null,
		array(
			'eyebrow' => esc_html__( 'Get in touch', 'gp-industry' ),
		)
	);

	$gpi_map = gpi_get_option( 'contact_map', '' );
	?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'template-page template-contact' ); ?>>
		<div class="nova-container">
			<div class="contact-layout">
				<div class="contact-form-card" data-reveal>
					<?php
					$gpi_form_title = gpi_get_option( 'contact_form_title' );
					if ( $gpi_form_title ) :
						?>
						<h2 class="contact-form-title"><?php echo esc_html( $gpi_form_title ); ?></h2>
					<?php endif; ?>

					<div class="entry-content is-wide">
						<?php
						$gpi_content = get_the_content();
						$has_form    = false;

						if ( ! empty( $gpi_content ) ) {
							the_content();
							if ( preg_match( '/(<form|wpforms|wpcf7|fluentform|ninja_forms|formidable)/i', $gpi_content ) ) {
								$has_form = true;
							}
						}

						// If no third-party form plugin was embedded in content, load built-in form
						if ( ! $has_form ) {
							get_template_part( 'template-parts/page/contact-form' );
						}
						?>
					</div>
				</div>

				<?php get_template_part( 'template-parts/page/contact-card' ); ?>
			</div>
		</div>

		<?php if ( $gpi_map && false !== strpos( $gpi_map, 'google.com/maps' ) ) : ?>
			<div class="nova-container">
				<div class="contact-map" data-reveal>
					<iframe src="<?php echo esc_url( $gpi_map ); ?>" width="100%" height="420" style="border:0" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade" title="<?php esc_attr_e( 'Map', 'gp-industry' ); ?>"></iframe>
				</div>
			</div>
		<?php endif; ?>
	</article>

	<?php
endwhile;

get_footer();
