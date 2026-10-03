<?php
/**
 * The footer.
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$company_name    = get_bloginfo( 'name' );
$gpi_tagline     = gpi_get_option( 'footer_tagline', '' );
if ( ! $gpi_tagline ) {
	$gpi_tagline = get_bloginfo( 'description' );
	if ( ! $gpi_tagline || 'Just another WordPress site' === $gpi_tagline ) {
		$gpi_tagline = esc_html__( 'Heavy engineering, high-precision 5-axis CNC machining, structural steel fabrication, and turnkey industrial automation certified to ISO 9001:2015 & ASME standards.', 'gp-industry' );
	}
}

$gpi_has_widgets = is_active_sidebar( 'footer-col-1' ) || is_active_sidebar( 'footer-col-2' ) || is_active_sidebar( 'footer-col-3' );

$phone   = gpi_get_option( 'contact_phone', '+91 98765 43210' );
$email   = gpi_get_option( 'contact_email', 'engineering@' . ( wp_parse_url( home_url(), PHP_URL_HOST ) ? wp_parse_url( home_url(), PHP_URL_HOST ) : 'gp-industry.com' ) );
$address = gpi_get_option( 'contact_address', 'Plot 42, Heavy Industrial Area Phase-II, Manufacturing Zone' );
$hours   = gpi_get_option( 'contact_hours', '24/7 Shift Operations & Technical Support' );
?>
	</main><!-- #primary -->

	<footer id="colophon" class="site-footer">
		<!-- Industrial Ambient Glow -->
		<div class="footer-glow" aria-hidden="true"></div>

		<!-- Pre-footer quick hotline / trust strip -->
		<div class="footer-highlight-bar">
			<div class="nova-container footer-highlight-inner">
				<div class="footer-highlight-item">
					<span class="footer-highlight-icon"><?php gpi_the_icon( 'shield', 22 ); ?></span>
					<div class="footer-highlight-text">
						<strong><?php esc_html_e( 'ISO 9001:2015 & ASME Certified', 'gp-industry' ); ?></strong>
						<span><?php esc_html_e( 'Stringent QA & 100% CMM dimensional testing', 'gp-industry' ); ?></span>
					</div>
				</div>
				<div class="footer-highlight-item">
					<span class="footer-highlight-icon"><?php gpi_the_icon( 'cpu', 22 ); ?></span>
					<div class="footer-highlight-text">
						<strong><?php esc_html_e( 'Micron Precision Engineering', 'gp-industry' ); ?></strong>
						<span><?php esc_html_e( '5-Axis CNC tolerances up to ±0.005mm', 'gp-industry' ); ?></span>
					</div>
				</div>
				<div class="footer-highlight-item">
					<span class="footer-highlight-icon"><?php gpi_the_icon( 'clock', 22 ); ?></span>
					<div class="footer-highlight-text">
						<strong><?php esc_html_e( 'Rapid RFQ Feasibility Turnaround', 'gp-industry' ); ?></strong>
						<span><?php esc_html_e( 'Technical quote & DFM analysis in 24 hours', 'gp-industry' ); ?></span>
					</div>
				</div>
			</div>
		</div>

		<div class="nova-container">
			<div class="footer-widgets-grid<?php echo $gpi_has_widgets ? '' : ' default-industrial-grid'; ?>">
				<!-- Column 1: Brand & Profile -->
				<div class="footer-brand">
					<?php if ( has_custom_logo() ) : ?>
						<div class="footer-logo"><?php the_custom_logo(); ?></div>
					<?php else : ?>
						<a class="footer-site-title" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
					<?php endif; ?>

					<?php if ( $gpi_tagline ) : ?>
						<p class="footer-tagline"><?php echo esc_html( $gpi_tagline ); ?></p>
					<?php endif; ?>

					<div class="footer-cert-badges">
						<span class="cert-pill">ISO 9001:2015</span>
						<span class="cert-pill">ASME Section VIII</span>
						<span class="cert-pill">CE Marked</span>
					</div>

					<div class="footer-social-wrapper">
						<?php gpi_social_links(); ?>
					</div>
				</div>

				<?php if ( $gpi_has_widgets ) : ?>
					<?php for ( $gpi_i = 1; $gpi_i <= 3; $gpi_i++ ) : ?>
						<?php if ( is_active_sidebar( 'footer-col-' . $gpi_i ) ) : ?>
							<div class="footer-widget-col">
								<?php dynamic_sidebar( 'footer-col-' . $gpi_i ); ?>
							</div>
						<?php endif; ?>
					<?php endfor; ?>
				<?php else : ?>
					<!-- Column 2: Quick Links / Navigation -->
					<div class="footer-widget-col">
						<h4 class="footer-widget-title">
							<span><?php esc_html_e( 'Navigation', 'gp-industry' ); ?></span>
							<span class="title-accent"></span>
						</h4>
						<ul class="footer-styled-menu">
							<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php gpi_the_icon( 'arrow-right', 14 ); ?><span><?php esc_html_e( 'Home', 'gp-industry' ); ?></span></a></li>
							<li><a href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>"><?php gpi_the_icon( 'arrow-right', 14 ); ?><span><?php esc_html_e( 'About Company', 'gp-industry' ); ?></span></a></li>
							<li><a href="<?php echo esc_url( home_url( '/products/' ) ); ?>"><?php gpi_the_icon( 'arrow-right', 14 ); ?><span><?php esc_html_e( 'Products & Machinery', 'gp-industry' ); ?></span></a></li>
							<li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>"><?php gpi_the_icon( 'arrow-right', 14 ); ?><span><?php esc_html_e( 'Manufacturing Services', 'gp-industry' ); ?></span></a></li>
							<li><a href="<?php echo esc_url( home_url( '/industries/' ) ); ?>"><?php gpi_the_icon( 'arrow-right', 14 ); ?><span><?php esc_html_e( 'Industries & Sectors', 'gp-industry' ); ?></span></a></li>
							<li><a href="<?php echo esc_url( home_url( '/case-studies/' ) ); ?>"><?php gpi_the_icon( 'arrow-right', 14 ); ?><span><?php esc_html_e( 'Projects & Case Studies', 'gp-industry' ); ?></span></a></li>
							<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php gpi_the_icon( 'arrow-right', 14 ); ?><span><?php esc_html_e( 'Request a Quote (RFQ)', 'gp-industry' ); ?></span></a></li>
						</ul>
					</div>

					<!-- Column 3: Capabilities & Products -->
					<div class="footer-widget-col">
						<h4 class="footer-widget-title">
							<span><?php esc_html_e( 'Capabilities', 'gp-industry' ); ?></span>
							<span class="title-accent"></span>
						</h4>
						<ul class="footer-styled-menu">
							<li><a href="<?php echo esc_url( home_url( '/products/heavy-industrial-machinery/' ) ); ?>"><?php gpi_the_icon( 'cog', 14 ); ?><span><?php esc_html_e( 'Heavy Machinery & Presses', 'gp-industry' ); ?></span></a></li>
							<li><a href="<?php echo esc_url( home_url( '/products/precision-cnc-components/' ) ); ?>"><?php gpi_the_icon( 'cpu', 14 ); ?><span><?php esc_html_e( '5-Axis Precision CNC Parts', 'gp-industry' ); ?></span></a></li>
							<li><a href="<?php echo esc_url( home_url( '/products/industrial-automation/' ) ); ?>"><?php gpi_the_icon( 'layers', 14 ); ?><span><?php esc_html_e( 'Robotic Automation Cells', 'gp-industry' ); ?></span></a></li>
							<li><a href="<?php echo esc_url( home_url( '/services/custom-fabrication/' ) ); ?>"><?php gpi_the_icon( 'wrench', 14 ); ?><span><?php esc_html_e( 'Structural Steel Fabrication', 'gp-industry' ); ?></span></a></li>
							<li><a href="<?php echo esc_url( home_url( '/services/plant-maintenance/' ) ); ?>"><?php gpi_the_icon( 'sliders', 14 ); ?><span><?php esc_html_e( 'Plant Overhaul & AMC', 'gp-industry' ); ?></span></a></li>
							<li><a href="<?php echo esc_url( home_url( '/services/engineering-prototyping/' ) ); ?>"><?php gpi_the_icon( 'sparkles', 14 ); ?><span><?php esc_html_e( '3D CAD & Prototyping', 'gp-industry' ); ?></span></a></li>
						</ul>
					</div>

					<!-- Column 4: Factory Plant & Contact Info -->
					<div class="footer-widget-col footer-contact-col">
						<h4 class="footer-widget-title">
							<span><?php esc_html_e( 'Factory & RFQ', 'gp-industry' ); ?></span>
							<span class="title-accent"></span>
						</h4>
						<div class="footer-contact-items">
							<div class="footer-contact-item">
								<span class="footer-contact-icon"><?php gpi_the_icon( 'map-pin', 18 ); ?></span>
								<div class="footer-contact-detail">
									<span class="footer-contact-label"><?php esc_html_e( 'Plant Location:', 'gp-industry' ); ?></span>
									<span class="footer-contact-val"><?php echo esc_html( $address ); ?></span>
								</div>
							</div>

							<div class="footer-contact-item">
								<span class="footer-contact-icon"><?php gpi_the_icon( 'phone', 18 ); ?></span>
								<div class="footer-contact-detail">
									<span class="footer-contact-label"><?php esc_html_e( 'RFQ Hotline:', 'gp-industry' ); ?></span>
									<a href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', $phone ) ); ?>" class="footer-contact-val footer-phone-link"><?php echo esc_html( $phone ); ?></a>
								</div>
							</div>

							<div class="footer-contact-item">
								<span class="footer-contact-icon"><?php gpi_the_icon( 'mail', 18 ); ?></span>
								<div class="footer-contact-detail">
									<span class="footer-contact-label"><?php esc_html_e( 'Engineering Support:', 'gp-industry' ); ?></span>
									<a href="mailto:<?php echo esc_attr( $email ); ?>" class="footer-contact-val footer-mail-link"><?php echo esc_html( $email ); ?></a>
								</div>
							</div>

							<div class="footer-plant-status">
								<span class="status-pulse-dot" aria-hidden="true"></span>
								<span class="status-pulse-text"><?php echo esc_html( $hours ); ?></span>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>

			<?php get_template_part( 'template-parts/footer/footer-bottom' ); ?>
		</div>
	</footer>
</div><!-- #page -->

<?php if ( gpi_get_option( 'show_back_to_top', true ) ) : ?>
	<button class="back-to-top" type="button" aria-label="<?php esc_attr_e( 'Back to top', 'gp-industry' ); ?>"><?php gpi_the_icon( 'arrow-up', 20 ); ?></button>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
