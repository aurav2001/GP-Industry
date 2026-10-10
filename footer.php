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
		$gpi_tagline = esc_html__( 'Recruit Quality Resources, Nurture & Retain — Strategic Facilities Management, HR Staffing, 100% Statutory Payroll Compliance, and Logistics Operations across Pan-India.', 'gp-industry' );
	}
}

$gpi_has_widgets = is_active_sidebar( 'footer-col-1' ) || is_active_sidebar( 'footer-col-2' ) || is_active_sidebar( 'footer-col-3' );

$phone   = gpi_get_option( 'contact_phone', '+91 98765 43210' );
$email   = gpi_get_option( 'contact_email', 'consulting@' . ( wp_parse_url( home_url(), PHP_URL_HOST ) ? wp_parse_url( home_url(), PHP_URL_HOST ) : 'varunya.com' ) );
$address = gpi_get_option( 'contact_address', 'Corporate Operations Hub, Delhi NCR & Pan-India Service Cells' );
$hours   = gpi_get_option( 'contact_hours', '24/7/365 Operations & Rapid Workforce Desk' );

// Global FAQ section on every page right before footer
if ( function_exists( 'gpi_render_global_faq' ) ) {
	gpi_render_global_faq();
}
?>
	</main><!-- #primary -->

	<footer id="colophon" class="site-footer">
		<!-- Ambient Glow -->
		<div class="footer-glow" aria-hidden="true"></div>

		<!-- Pre-footer quick hotline / trust strip -->
		<div class="footer-highlight-bar">
			<div class="nova-container footer-highlight-inner">
				<div class="footer-highlight-item">
					<span class="footer-highlight-icon"><?php gpi_the_icon( 'shield', 22 ); ?></span>
					<div class="footer-highlight-text">
						<strong><?php esc_html_e( '100% Statutory SLA & EPFO Compliant', 'gp-industry' ); ?></strong>
						<span><?php esc_html_e( 'Zero-deviation ECR, PF, ESIC & dispute-free audit records', 'gp-industry' ); ?></span>
					</div>
				</div>
				<div class="footer-highlight-item">
					<span class="footer-highlight-icon"><?php gpi_the_icon( 'users', 22 ); ?></span>
					<div class="footer-highlight-text">
						<strong><?php esc_html_e( 'Vetted National Resource Pool', 'gp-industry' ); ?></strong>
						<span><?php esc_html_e( '2-week pre-deployment SOP induction & soft-skills training', 'gp-industry' ); ?></span>
					</div>
				</div>
				<div class="footer-highlight-item">
					<span class="footer-highlight-icon"><?php gpi_the_icon( 'clock', 22 ); ?></span>
					<div class="footer-highlight-text">
						<strong><?php esc_html_e( '24/7/365 Rapid Operations Desk', 'gp-industry' ); ?></strong>
						<span><?php esc_html_e( 'Immediate client coordination & 24hr replacement guarantee', 'gp-industry' ); ?></span>
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
						<span class="cert-pill">100% EPFO & ESIC Compliant</span>
						<span class="cert-pill">10+ Years Excellence</span>
						<span class="cert-pill">Pan-India Delivery</span>
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
							<li><a href="<?php echo esc_url( gpi_get_page_link_by_path( 'about-us', home_url( '/#about' ) ) ); ?>"><?php gpi_the_icon( 'arrow-right', 14 ); ?><span><?php esc_html_e( 'About Company', 'gp-industry' ); ?></span></a></li>
							<li><a href="<?php echo esc_url( gpi_get_page_link_by_path( 'products', home_url( '/#products' ) ) ); ?>"><?php gpi_the_icon( 'arrow-right', 14 ); ?><span><?php esc_html_e( 'Core Solutions', 'gp-industry' ); ?></span></a></li>
							<li><a href="<?php echo esc_url( gpi_get_page_link_by_path( 'services', home_url( '/#products' ) ) ); ?>"><?php gpi_the_icon( 'arrow-right', 14 ); ?><span><?php esc_html_e( 'Staffing & Facilities', 'gp-industry' ); ?></span></a></li>
							<li><a href="<?php echo esc_url( gpi_get_page_link_by_path( 'industries', home_url( '/#industries' ) ) ); ?>"><?php gpi_the_icon( 'arrow-right', 14 ); ?><span><?php esc_html_e( 'Industries & Sectors', 'gp-industry' ); ?></span></a></li>
							<li><a href="<?php echo esc_url( gpi_get_page_link_by_path( 'case-studies', home_url( '/#features' ) ) ); ?>"><?php gpi_the_icon( 'arrow-right', 14 ); ?><span><?php esc_html_e( 'Case Studies & Proof', 'gp-industry' ); ?></span></a></li>
							<li><a href="<?php echo esc_url( gpi_get_page_link_by_path( 'contact', home_url( '/#contact' ) ) ); ?>"><?php gpi_the_icon( 'arrow-right', 14 ); ?><span><?php esc_html_e( 'Request Consultation', 'gp-industry' ); ?></span></a></li>
						</ul>
					</div>

					<!-- Column 3: Capabilities & Solutions -->
					<div class="footer-widget-col">
						<h4 class="footer-widget-title">
							<span><?php esc_html_e( 'Solutions', 'gp-industry' ); ?></span>
							<span class="title-accent"></span>
						</h4>
						<ul class="footer-styled-menu">
							<li><a href="<?php echo esc_url( gpi_get_page_link_by_path( 'workforce-outsourcing', home_url( '/#products' ) ) ); ?>"><?php gpi_the_icon( 'users', 14 ); ?><span><?php esc_html_e( 'Strategic HR Staffing', 'gp-industry' ); ?></span></a></li>
							<li><a href="<?php echo esc_url( gpi_get_page_link_by_path( 'payroll-compliance', home_url( '/#products' ) ) ); ?>"><?php gpi_the_icon( 'shield', 14 ); ?><span><?php esc_html_e( '100% Payroll & PF/ESI Compliance', 'gp-industry' ); ?></span></a></li>
							<li><a href="<?php echo esc_url( gpi_get_page_link_by_path( 'integrated-facility-management', home_url( '/#products' ) ) ); ?>"><?php gpi_the_icon( 'layers', 14 ); ?><span><?php esc_html_e( 'Integrated Facilities (IFM)', 'gp-industry' ); ?></span></a></li>
							<li><a href="<?php echo esc_url( gpi_get_page_link_by_path( 'logistics-warehouse-staffing', home_url( '/#features' ) ) ); ?>"><?php gpi_the_icon( 'truck', 14 ); ?><span><?php esc_html_e( 'Warehouse & Logistics Staffing', 'gp-industry' ); ?></span></a></li>
							<li><a href="<?php echo esc_url( gpi_get_page_link_by_path( 'executive-search', home_url( '/#features' ) ) ); ?>"><?php gpi_the_icon( 'briefcase', 14 ); ?><span><?php esc_html_e( 'Executive Search & Leadership', 'gp-industry' ); ?></span></a></li>
							<li><a href="<?php echo esc_url( gpi_get_page_link_by_path( 'it-staff-augmentation', home_url( '/#features' ) ) ); ?>"><?php gpi_the_icon( 'cpu', 14 ); ?><span><?php esc_html_e( 'IT Staff Augmentation', 'gp-industry' ); ?></span></a></li>
						</ul>
					</div>

					<!-- Column 4: Corporate Hub & Contact Info -->
					<div class="footer-widget-col footer-contact-col">
						<h4 class="footer-widget-title">
							<span><?php esc_html_e( 'Corporate Desk', 'gp-industry' ); ?></span>
							<span class="title-accent"></span>
						</h4>
						<div class="footer-contact-items">
							<div class="footer-contact-item">
								<span class="footer-contact-icon"><?php gpi_the_icon( 'map-pin', 18 ); ?></span>
								<div class="footer-contact-detail">
									<span class="footer-contact-label"><?php esc_html_e( 'Operations Hub:', 'gp-industry' ); ?></span>
									<span class="footer-contact-val"><?php echo esc_html( $address ); ?></span>
								</div>
							</div>

							<div class="footer-contact-item">
								<span class="footer-contact-icon"><?php gpi_the_icon( 'phone', 18 ); ?></span>
								<div class="footer-contact-detail">
									<span class="footer-contact-label"><?php esc_html_e( 'Consulting Helpline:', 'gp-industry' ); ?></span>
									<a href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', $phone ) ); ?>" class="footer-contact-val footer-phone-link"><?php echo esc_html( $phone ); ?></a>
								</div>
							</div>

							<div class="footer-contact-item">
								<span class="footer-contact-icon"><?php gpi_the_icon( 'mail', 18 ); ?></span>
								<div class="footer-contact-detail">
									<span class="footer-contact-label"><?php esc_html_e( 'Enterprise Support:', 'gp-industry' ); ?></span>
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
