<?php
/**
 * Template Name: About Page
 * Template Post Type: page
 *
 * Split hero (text + featured image) + wide content area for Nova patterns
 * (Stats, Team, Testimonials…) + CTA banner.
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
			'eyebrow' => esc_html__( 'Our company', 'gp-industry' ),
			'align'   => 'left',
			'image'   => true,
		)
	);
	?>

	<!-- Talent Consulting Footprints Metrics Bar -->
	<section class="about-metrics-bar">
		<div class="nova-container">
			<div class="about-metrics-grid">
				<div class="metric-box" data-reveal>
					<div class="metric-icon"><?php gpi_the_icon( 'award', 26 ); ?></div>
					<div class="metric-data">
						<span class="metric-num">100+</span>
						<span class="metric-label"><?php esc_html_e( 'Man-Years Experience', 'gp-industry' ); ?></span>
					</div>
				</div>
				<div class="metric-box" data-reveal data-reveal-delay="100">
					<div class="metric-icon"><?php gpi_the_icon( 'users', 26 ); ?></div>
					<div class="metric-data">
						<span class="metric-num">4,000,000+</span>
						<span class="metric-label"><?php esc_html_e( 'Candidate Database', 'gp-industry' ); ?></span>
					</div>
				</div>
				<div class="metric-box" data-reveal data-reveal-delay="200">
					<div class="metric-icon"><?php gpi_the_icon( 'cpu', 26 ); ?></div>
					<div class="metric-data">
						<span class="metric-num">300+</span>
						<span class="metric-label"><?php esc_html_e( 'Bench Professionals', 'gp-industry' ); ?></span>
					</div>
				</div>
				<div class="metric-box" data-reveal data-reveal-delay="300">
					<div class="metric-icon"><?php gpi_the_icon( 'globe', 26 ); ?></div>
					<div class="metric-data">
						<span class="metric-num">15+</span>
						<span class="metric-label"><?php esc_html_e( 'Industry Verticals (Global Reach)', 'gp-industry' ); ?></span>
					</div>
				</div>
			</div>
		</div>
	</section>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'template-page template-about' ); ?>>
		<?php gpi_the_auto_layout( null, true ); ?>
		<div class="nova-container">
			<div class="entry-content is-wide">
				<?php
				if ( ! trim( get_the_content() ) && current_user_can( 'edit_pages' ) ) {
					echo '<div class="template-hint">' . gpi_icon( 'info', 18 ) . esc_html__( 'Tip: open the editor, click "+" → Patterns → Nova and insert Our Process, Certifications, Stats, Team or FAQ sections here. This note is only visible to editors.', 'gp-industry' ) . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				?>
			</div>
		</div>
	</article>

	<?php
	get_template_part( 'template-parts/sections/cta' );

endwhile;

get_footer();
