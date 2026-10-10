<?php
/**
 * Template Name: Products Page
 * Template Post Type: page
 *
 * Premium Corporate B2B Products & Solutions Showcase:
 * Hero with Clear Value Proposition → Key Metrics Strip →
 * Clean Enterprise Solutions Grid → Featured Solution Spotlight (Split Layout) →
 * Industry Sectors → Executive Consultation & RFQ CTA.
 *
 * @package GPIndustry
 */

get_header();

while ( have_posts() ) :
	the_post();

	$gpi_cta_url = gpi_get_option( 'header_cta_url', '#contact' );
	?>

	<!-- ── Executive Products Hero ── -->
	<section class="page-hero page-hero-template b2b-hero">
		<div class="hero-orbs" aria-hidden="true"><span class="orb orb-1"></span><span class="orb orb-2"></span></div>
		<div class="nova-container page-hero-inner">
			<div class="page-hero-content" data-reveal>
				<?php gpi_breadcrumbs(); ?>
				<div class="b2b-kicker">
					<span class="b2b-kicker-dot"></span>
					<span><?php esc_html_e( 'Enterprise Hardware &amp; Turnkey Systems', 'gp-industry' ); ?></span>
				</div>
				<h1 class="page-hero-title"><?php the_title(); ?></h1>
				<p class="page-hero-text">
					<?php
					if ( has_excerpt() ) {
						echo esc_html( get_the_excerpt() );
					} else {
						esc_html_e( 'High-performance industrial machinery, modular automation systems, and precision components engineered to drive productivity, efficiency, and reliability.', 'gp-industry' );
					}
					?>
				</p>
				<div class="b2b-hero-actions">
					<a href="#solutions-catalog" class="btn btn-primary btn-lg">
						<span><?php esc_html_e( 'Explore All Solutions', 'gp-industry' ); ?></span>
						<?php gpi_the_icon( 'arrow-down', 16 ); ?>
					</a>
					<a href="<?php echo esc_url( $gpi_cta_url ); ?>" class="btn btn-ghost btn-lg">
						<?php gpi_the_icon( 'file', 16 ); ?>
						<span><?php esc_html_e( 'Request Consultation', 'gp-industry' ); ?></span>
					</a>
				</div>
			</div>
		</div>
	</section>

	<!-- ── Operational Impact Metric Strip ── -->
	<section class="b2b-stats-bar">
		<div class="nova-container">
			<div class="b2b-stats-grid">
				<div class="b2b-stat-item" data-reveal>
					<span class="b2b-stat-number">99.9%</span>
					<span class="b2b-stat-label"><?php esc_html_e( 'Operational Reliability', 'gp-industry' ); ?></span>
				</div>
				<div class="b2b-stat-item" data-reveal data-reveal-delay="70">
					<span class="b2b-stat-number">500+</span>
					<span class="b2b-stat-label"><?php esc_html_e( 'Industrial Deployments', 'gp-industry' ); ?></span>
				</div>
				<div class="b2b-stat-item" data-reveal data-reveal-delay="140">
					<span class="b2b-stat-number">15+</span>
					<span class="b2b-stat-label"><?php esc_html_e( 'Global Markets Served', 'gp-industry' ); ?></span>
				</div>
				<div class="b2b-stat-item" data-reveal data-reveal-delay="210">
					<span class="b2b-stat-number">24/7</span>
					<span class="b2b-stat-label"><?php esc_html_e( 'Engineering Support &amp; Spares', 'gp-industry' ); ?></span>
				</div>
			</div>
		</div>
	</section>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'template-page b2b-products-page' ); ?>>

		<!-- ── In-Page Editor Content (if any) ── -->
		<?php
		$gpi_main_content = trim( get_the_content() );
		if ( ! empty( $gpi_main_content ) ) :
			?>
			<section class="b2b-page-intro-section">
				<div class="nova-container">
					<div class="b2b-page-intro entry-content">
						<?php the_content(); ?>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<!-- ── Solutions Catalog (Clean Modern Grid) ── -->
		<section id="solutions-catalog" class="b2b-catalog-section section-pad">
			<div class="nova-container">
				<div class="section-heading align-center" data-reveal>
					<span class="section-eyebrow"><?php esc_html_e( 'Our Portfolio', 'gp-industry' ); ?></span>
					<h2 class="section-title"><?php esc_html_e( 'Industrial Systems &amp; Engineered Hardware', 'gp-industry' ); ?></h2>
					<p class="section-text"><?php esc_html_e( 'Explore our flagship product lines designed for severe industrial environments and mission-critical workflows.', 'gp-industry' ); ?></p>
				</div>

				<?php
				$gpi_children = new WP_Query(
					array(
						'post_type'      => 'page',
						'post_parent'    => get_the_ID(),
						'posts_per_page' => -1,
						'orderby'        => 'menu_order title',
						'order'          => 'ASC',
						'no_found_rows'  => true,
					)
				);

				if ( $gpi_children->have_posts() ) :
					?>
					<div class="b2b-card-grid">
						<?php
						$i = 0;
						while ( $gpi_children->have_posts() ) :
							$gpi_children->the_post();
							?>
							<div class="b2b-solution-card" data-reveal data-reveal-delay="<?php echo esc_attr( ( $i % 3 ) * 80 ); ?>">
								<div class="b2b-card-media">
									<?php
									if ( has_post_thumbnail() ) {
										the_post_thumbnail( 'nova-card', array( 'class' => 'b2b-card-img', 'loading' => 'lazy' ) );
									} else {
										?>
										<div class="b2b-card-fallback-media">
											<?php gpi_the_icon( 'cog', 44 ); ?>
										</div>
										<?php
									}
									?>
								</div>
								<div class="b2b-card-body">
									<h3 class="b2b-card-title">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h3>
									<p class="b2b-card-desc">
										<?php
										if ( has_excerpt() ) {
											echo esc_html( get_the_excerpt() );
										} else {
											echo esc_html( wp_trim_words( get_the_content(), 18 ) );
										}
										?>
									</p>
									<div class="b2b-card-footer">
										<a href="<?php the_permalink(); ?>" class="b2b-link-arrow">
											<span><?php esc_html_e( 'View Specifications', 'gp-industry' ); ?></span>
											<?php gpi_the_icon( 'arrow-right', 16 ); ?>
										</a>
									</div>
								</div>
							</div>
							<?php
							$i++;
						endwhile;
						wp_reset_postdata();
						?>
					</div>

				<?php else : ?>

					<!-- Curated Enterprise Showcase Grid -->
					<div class="b2b-card-grid">
						
						<!-- Solution 1 -->
						<div class="b2b-solution-card" data-reveal>
							<div class="b2b-card-media">
								<div class="b2b-card-fallback-media b2b-bg-1">
									<?php gpi_the_icon( 'cog', 44 ); ?>
								</div>
							</div>
							<div class="b2b-card-body">
								<span class="b2b-card-category"><?php esc_html_e( 'Machining &amp; Fabrication', 'gp-industry' ); ?></span>
								<h3 class="b2b-card-title"><?php esc_html_e( 'High-Precision CNC Machining Centers', 'gp-industry' ); ?></h3>
								<p class="b2b-card-desc"><?php esc_html_e( '5-axis simultaneous high-speed machining centers built for aerospace, defense, and high-tolerance industrial tooling.', 'gp-industry' ); ?></p>
								<div class="b2b-card-footer">
									<a href="<?php echo esc_url( $gpi_cta_url ); ?>" class="b2b-link-arrow">
										<span><?php esc_html_e( 'Request Technical Data Sheet', 'gp-industry' ); ?></span>
										<?php gpi_the_icon( 'arrow-right', 16 ); ?>
									</a>
								</div>
							</div>
						</div>

						<!-- Solution 2 -->
						<div class="b2b-solution-card" data-reveal data-reveal-delay="80">
							<div class="b2b-card-media">
								<div class="b2b-card-fallback-media b2b-bg-2">
									<?php gpi_the_icon( 'bolt', 44 ); ?>
								</div>
							</div>
							<div class="b2b-card-body">
								<span class="b2b-card-category"><?php esc_html_e( 'Automation &amp; Controls', 'gp-industry' ); ?></span>
								<h3 class="b2b-card-title"><?php esc_html_e( 'Industrial SCADA &amp; Modular PLC Racks', 'gp-industry' ); ?></h3>
								<p class="b2b-card-desc"><?php esc_html_e( 'Scalable automation controllers with hot-standby redundancy, sub-millisecond loop cycle, and multi-protocol industrial telemetry.', 'gp-industry' ); ?></p>
								<div class="b2b-card-footer">
									<a href="<?php echo esc_url( $gpi_cta_url ); ?>" class="b2b-link-arrow">
										<span><?php esc_html_e( 'Request Technical Data Sheet', 'gp-industry' ); ?></span>
										<?php gpi_the_icon( 'arrow-right', 16 ); ?>
									</a>
								</div>
							</div>
						</div>

						<!-- Solution 3 -->
						<div class="b2b-solution-card" data-reveal data-reveal-delay="160">
							<div class="b2b-card-media">
								<div class="b2b-card-fallback-media b2b-bg-3">
									<?php gpi_the_icon( 'factory', 44 ); ?>
								</div>
							</div>
							<div class="b2b-card-body">
								<span class="b2b-card-category"><?php esc_html_e( 'Power &amp; Utilities', 'gp-industry' ); ?></span>
								<h3 class="b2b-card-title"><?php esc_html_e( 'Medium-Voltage Gas-Insulated Switchgear', 'gp-industry' ); ?></h3>
								<p class="b2b-card-desc"><?php esc_html_e( 'Type-tested 11kV-33kV power distribution switchgear equipped with internal arc containment and remote condition monitoring.', 'gp-industry' ); ?></p>
								<div class="b2b-card-footer">
									<a href="<?php echo esc_url( $gpi_cta_url ); ?>" class="b2b-link-arrow">
										<span><?php esc_html_e( 'Request Technical Data Sheet', 'gp-industry' ); ?></span>
										<?php gpi_the_icon( 'arrow-right', 16 ); ?>
									</a>
								</div>
							</div>
						</div>

						<!-- Solution 4 -->
						<div class="b2b-solution-card" data-reveal>
							<div class="b2b-card-media">
								<div class="b2b-card-fallback-media b2b-bg-4">
									<?php gpi_the_icon( 'rocket', 44 ); ?>
								</div>
							</div>
							<div class="b2b-card-body">
								<span class="b2b-card-category"><?php esc_html_e( 'Robotics &amp; Logistics', 'gp-industry' ); ?></span>
								<h3 class="b2b-card-title"><?php esc_html_e( 'Autonomous Mobile Robots (AMR/AGV)', 'gp-industry' ); ?></h3>
								<p class="b2b-card-desc"><?php esc_html_e( 'Heavy-payload natural navigation mobile robots for factory floor transport with automated docking and fleet management API.', 'gp-industry' ); ?></p>
								<div class="b2b-card-footer">
									<a href="<?php echo esc_url( $gpi_cta_url ); ?>" class="b2b-link-arrow">
										<span><?php esc_html_e( 'Request Technical Data Sheet', 'gp-industry' ); ?></span>
										<?php gpi_the_icon( 'arrow-right', 16 ); ?>
									</a>
								</div>
							</div>
						</div>

						<!-- Solution 5 -->
						<div class="b2b-solution-card" data-reveal data-reveal-delay="80">
							<div class="b2b-card-media">
								<div class="b2b-card-fallback-media b2b-bg-5">
									<?php gpi_the_icon( 'chart', 44 ); ?>
								</div>
							</div>
							<div class="b2b-card-body">
								<span class="b2b-card-category"><?php esc_html_e( 'IoT &amp; Telemetry', 'gp-industry' ); ?></span>
								<h3 class="b2b-card-title"><?php esc_html_e( 'Tri-Axis Wireless Vibration Sensors', 'gp-industry' ); ?></h3>
								<p class="b2b-card-desc"><?php esc_html_e( 'ATEX Zone 1 intrinsically safe vibration and temperature sensors with high-frequency FFT processing and long-range connectivity.', 'gp-industry' ); ?></p>
								<div class="b2b-card-footer">
									<a href="<?php echo esc_url( $gpi_cta_url ); ?>" class="b2b-link-arrow">
										<span><?php esc_html_e( 'Request Technical Data Sheet', 'gp-industry' ); ?></span>
										<?php gpi_the_icon( 'arrow-right', 16 ); ?>
									</a>
								</div>
							</div>
						</div>

						<!-- Solution 6 -->
						<div class="b2b-solution-card" data-reveal data-reveal-delay="160">
							<div class="b2b-card-media">
								<div class="b2b-card-fallback-media b2b-bg-6">
									<?php gpi_the_icon( 'target', 44 ); ?>
								</div>
							</div>
							<div class="b2b-card-body">
								<span class="b2b-card-category"><?php esc_html_e( 'Fluids &amp; Hydraulics', 'gp-industry' ); ?></span>
								<h3 class="b2b-card-title"><?php esc_html_e( 'Heavy Hydraulic Power &amp; Valve Units', 'gp-industry' ); ?></h3>
								<p class="b2b-card-desc"><?php esc_html_e( 'Proportional servo hydraulic power packs operating up to 350 bar with integrated multi-stage filtration and digital control.', 'gp-industry' ); ?></p>
								<div class="b2b-card-footer">
									<a href="<?php echo esc_url( $gpi_cta_url ); ?>" class="b2b-link-arrow">
										<span><?php esc_html_e( 'Request Technical Data Sheet', 'gp-industry' ); ?></span>
										<?php gpi_the_icon( 'arrow-right', 16 ); ?>
									</a>
								</div>
							</div>
						</div>

					</div>
				<?php endif; ?>
			</div>
		</section>

		<!-- ── Featured Innovation Spotlight (Clean Split Section) ── -->
		<section class="b2b-spotlight-section section-pad">
			<div class="nova-container">
				<div class="b2b-spotlight-inner">
					<div class="b2b-spotlight-content" data-reveal>
						<span class="b2b-spotlight-eyebrow"><?php esc_html_e( 'Custom Engineering &amp; OEM', 'gp-industry' ); ?></span>
						<h2 class="b2b-spotlight-title"><?php esc_html_e( 'Built to Exact Technical Specifications', 'gp-industry' ); ?></h2>
						<p class="b2b-spotlight-text">
							<?php esc_html_e( 'When off-the-shelf equipment cannot meet your demanding tolerances, our application engineers design, simulate, and manufacture custom industrial solutions tailored precisely to your plant environment.', 'gp-industry' ); ?>
						</p>

						<div class="b2b-spotlight-bullets">
							<div class="spotlight-bullet">
								<span class="bullet-check"><?php gpi_the_icon( 'check-circle', 18 ); ?></span>
								<div>
									<strong><?php esc_html_e( '3D CAD &amp; FEA Stress Simulation', 'gp-industry' ); ?></strong>
									<p><?php esc_html_e( 'Rigorous digital twin testing before metal cutting to verify structural integrity.', 'gp-industry' ); ?></p>
								</div>
							</div>
							<div class="spotlight-bullet">
								<span class="bullet-check"><?php gpi_the_icon( 'check-circle', 18 ); ?></span>
								<div>
									<strong><?php esc_html_e( 'Complete Material Traceability', 'gp-industry' ); ?></strong>
									<p><?php esc_html_e( 'Supplied with EN 10204 3.1 mill test certificates and full chemical inspection logs.', 'gp-industry' ); ?></p>
								</div>
							</div>
							<div class="spotlight-bullet">
								<span class="bullet-check"><?php gpi_the_icon( 'check-circle', 18 ); ?></span>
								<div>
									<strong><?php esc_html_e( 'Turnkey On-Site Commissioning', 'gp-industry' ); ?></strong>
									<p><?php esc_html_e( 'Our field engineers oversee mechanical installation, electrical cutover, and crew training.', 'gp-industry' ); ?></p>
								</div>
							</div>
						</div>

						<div class="b2b-spotlight-action">
							<a href="<?php echo esc_url( $gpi_cta_url ); ?>" class="btn btn-primary btn-lg">
								<span><?php esc_html_e( 'Submit Engineering Drawings for Review', 'gp-industry' ); ?></span>
								<?php gpi_the_icon( 'arrow-right', 16 ); ?>
							</a>
						</div>
					</div>

					<div class="b2b-spotlight-visual" data-reveal data-reveal-delay="120">
						<div class="b2b-visual-card">
							<div class="b2b-visual-badge">
								<?php gpi_the_icon( 'award', 16 ); ?>
								<span><?php esc_html_e( 'ISO 9001:2015 &bull; CE Certified', 'gp-industry' ); ?></span>
							</div>
							<div class="b2b-visual-inner-graphic">
								<?php gpi_the_icon( 'shield-check', 64 ); ?>
								<h3><?php esc_html_e( '100% Quality Inspected', 'gp-industry' ); ?></h3>
								<p><?php esc_html_e( 'Factory Acceptance Tested (FAT) with CMM dimensional reports before dispatch.', 'gp-industry' ); ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- ── Industry Verticals (Who We Serve) ── -->
		<section class="b2b-industries-section section-pad">
			<div class="nova-container">
				<div class="section-heading align-center" data-reveal>
					<span class="section-eyebrow"><?php esc_html_e( 'Applications', 'gp-industry' ); ?></span>
					<h2 class="section-title"><?php esc_html_e( 'Industries We Power', 'gp-industry' ); ?></h2>
					<p class="section-text"><?php esc_html_e( 'Our solutions are deployed across heavy industrial sectors demanding uncompromising precision and reliability.', 'gp-industry' ); ?></p>
				</div>

				<div class="b2b-industries-grid">
					<div class="b2b-industry-card" data-reveal>
						<div class="industry-icon"><?php gpi_the_icon( 'cog', 28 ); ?></div>
						<h3><?php esc_html_e( 'Automotive &amp; EV', 'gp-industry' ); ?></h3>
						<p><?php esc_html_e( 'Press lines, battery casing machining, robotic assembly cells, and stamping tooling.', 'gp-industry' ); ?></p>
					</div>
					<div class="b2b-industry-card" data-reveal data-reveal-delay="70">
						<div class="industry-icon"><?php gpi_the_icon( 'rocket', 28 ); ?></div>
						<h3><?php esc_html_e( 'Aerospace &amp; Defense', 'gp-industry' ); ?></h3>
						<p><?php esc_html_e( 'Turbine components, landing gear tooling, and structural titanium airframe parts.', 'gp-industry' ); ?></p>
					</div>
					<div class="b2b-industry-card" data-reveal data-reveal-delay="140">
						<div class="industry-icon"><?php gpi_the_icon( 'factory', 28 ); ?></div>
						<h3><?php esc_html_e( 'Energy &amp; Utilities', 'gp-industry' ); ?></h3>
						<p><?php esc_html_e( 'Substation switchgear, high-pressure valves, heat exchangers, and SCADA monitoring.', 'gp-industry' ); ?></p>
					</div>
					<div class="b2b-industry-card" data-reveal data-reveal-delay="210">
						<div class="industry-icon"><?php gpi_the_icon( 'target', 28 ); ?></div>
						<h3><?php esc_html_e( 'Chemical &amp; Process', 'gp-industry' ); ?></h3>
						<p><?php esc_html_e( 'Corrosion-resistant alloy piping, pressure vessels, and hazardous zone telemetry.', 'gp-industry' ); ?></p>
					</div>
				</div>
			</div>
		</section>

		<!-- ── Executive Consultation & RFQ CTA Strip ── -->
		<section class="b2b-cta-section">
			<div class="nova-container">
				<div class="b2b-cta-card" data-reveal>
					<div class="b2b-cta-body">
						<span class="b2b-cta-kicker"><?php esc_html_e( 'Partner With Our Engineers', 'gp-industry' ); ?></span>
						<h2 class="b2b-cta-title"><?php esc_html_e( 'Need Technical Data Sheets or a Custom Solution RFQ?', 'gp-industry' ); ?></h2>
						<p class="b2b-cta-desc"><?php esc_html_e( 'Our application specialists review your requirements, analyze operating conditions, and provide firm technical proposals under mutual NDA.', 'gp-industry' ); ?></p>
					</div>
					<div class="b2b-cta-actions">
						<a href="<?php echo esc_url( $gpi_cta_url ); ?>" class="btn btn-primary btn-lg">
							<span><?php esc_html_e( 'Request Technical Proposal', 'gp-industry' ); ?></span>
							<?php gpi_the_icon( 'arrow-right', 16 ); ?>
						</a>
					</div>
				</div>
			</div>
		</section>

	</article>

	<?php
endwhile;

get_footer();
