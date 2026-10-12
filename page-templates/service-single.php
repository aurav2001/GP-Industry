<?php
/**
 * Template Name: Service Detail
 * Template Post Type: page
 *
 * Dedicated Modern B2B Service Detail Layout:
 * Split Hero with Reliability Metrics & CTAs → Detailed Scope & Deliverables →
 * 4-Phase Execution Framework → Governance & Safety Standards →
 * 24/7 Field Support Callout → Sibling Services Showcase.
 *
 * @package GPIndustry
 */

get_header();

while ( have_posts() ) :
	the_post();

	$gpi_parent_id = wp_get_post_parent_id( get_the_ID() );
	$gpi_cta_url   = gpi_get_option( 'header_cta_url', '#contact' );
	?>

	<!-- ── Service Detail Hero (Split 2-Column) ── -->
	<section class="single-prod-hero-section single-serv-hero">
		<div class="hero-orbs" aria-hidden="true"><span class="orb orb-1"></span><span class="orb orb-2"></span></div>
		<div class="nova-container">
			<div class="single-prod-hero-inner">
				<div class="single-prod-hero-content" data-reveal>
					<?php gpi_breadcrumbs(); ?>

					<div class="b2b-kicker">
						<span class="b2b-kicker-dot"></span>
						<span><?php echo $gpi_parent_id ? esc_html( get_the_title( $gpi_parent_id ) ) : esc_html__( 'Services', 'gp-industry' ); ?> &bull; <?php esc_html_e( 'Engineering Solutions', 'gp-industry' ); ?></span>
					</div>

					<h1 class="single-prod-title"><?php the_title(); ?></h1>

					<p class="single-prod-lead">
						<?php
						if ( has_excerpt() ) {
							echo esc_html( get_the_excerpt() );
						} else {
							esc_html_e( 'Comprehensive turnkey engineering, predictive maintenance, and operational modernization engineered to ensure 99.8% plant uptime and strict regulatory compliance.', 'gp-industry' );
						}
						?>
					</p>

					<!-- Quick Reliability Badges -->
					<div class="single-prod-specs-bar">
						<div class="prod-spec-box">
							<span class="spec-box-label"><?php esc_html_e( 'Plant Availability', 'gp-industry' ); ?></span>
							<strong class="spec-box-val">99.8% Uptime</strong>
						</div>
						<div class="prod-spec-box">
							<span class="spec-box-label"><?php esc_html_e( 'Emergency Dispatch', 'gp-industry' ); ?></span>
							<strong class="spec-box-val">&lt; 2 Hours</strong>
						</div>
						<div class="prod-spec-box">
							<span class="spec-box-label"><?php esc_html_e( 'Safety Benchmark', 'gp-industry' ); ?></span>
							<strong class="spec-box-val">ISO 45001 Zero Harm</strong>
						</div>
						<div class="prod-spec-box">
							<span class="spec-box-label"><?php esc_html_e( 'Field Personnel', 'gp-industry' ); ?></span>
							<strong class="spec-box-val">Certified Engineers</strong>
						</div>
					</div>

					<div class="single-prod-actions">
						<a href="<?php echo esc_url( $gpi_cta_url ); ?>" class="btn btn-primary btn-lg">
							<span><?php esc_html_e( 'Request Engineering Proposal', 'gp-industry' ); ?></span>
							<?php gpi_the_icon( 'arrow-right', 16 ); ?>
						</a>
						<a href="#service-scope" class="btn btn-ghost btn-lg">
							<?php gpi_the_icon( 'file', 16 ); ?>
							<span><?php esc_html_e( 'Explore Scope &amp; SLAs', 'gp-industry' ); ?></span>
						</a>
					</div>
				</div>

				<div class="single-prod-hero-media" data-reveal data-reveal-delay="100">
					<div class="single-prod-media-frame">
						<?php
						if ( has_post_thumbnail() ) {
							the_post_thumbnail( 'nova-wide', array( 'class' => 'single-prod-img', 'loading' => 'eager' ) );
						} else {
							?>
							<div class="single-prod-fallback b2b-bg-2">
								<?php gpi_the_icon( 'factory', 64 ); ?>
								<span><?php the_title(); ?></span>
							</div>
							<?php
						}
						?>
						<div class="single-prod-badge">
							<span class="badge-dot"></span>
							<span><?php esc_html_e( 'Certified Engineering Crew &bull; OSHA Compliant', 'gp-industry' ); ?></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'template-page single-service-page' ); ?>>

		<!-- ── Service Overview & Scope ── -->
		<section id="service-scope" class="single-prod-overview section-pad">
			<div class="nova-container">
				<div class="section-heading" data-reveal>
					<span class="section-eyebrow"><?php esc_html_e( 'Scope of Work', 'gp-industry' ); ?></span>
					<h2 class="section-title"><?php esc_html_e( 'Comprehensive Execution &amp; Engineering Deliverables', 'gp-industry' ); ?></h2>
				</div>

				<div class="single-prod-prose entry-content" data-reveal>
					<?php the_content(); ?>
				</div>

				<!-- Core Capabilities (3 Bento Cards) -->
				<div class="single-prod-bento">
					<div class="bento-feature-card" data-reveal>
						<div class="bento-icon"><?php gpi_the_icon( 'target', 26 ); ?></div>
						<h3><?php esc_html_e( 'Calibrated Diagnostics', 'gp-industry' ); ?></h3>
						<p><?php esc_html_e( 'Baseline ultrasonic, vibration FFT, and thermal inspections using Class 0.2 calibrated instrumentation to detect early failure patterns.', 'gp-industry' ); ?></p>
					</div>
					<div class="bento-feature-card" data-reveal data-reveal-delay="70">
						<div class="bento-icon"><?php gpi_the_icon( 'cog', 26 ); ?></div>
						<h3><?php esc_html_e( 'Zero-Disruption Cutover', 'gp-industry' ); ?></h3>
						<p><?php esc_html_e( 'Carefully orchestrated turnkey execution designed to minimize plant downtime during maintenance, commissioning, or controller modernization.', 'gp-industry' ); ?></p>
					</div>
					<div class="bento-feature-card" data-reveal data-reveal-delay="140">
						<div class="bento-icon"><?php gpi_the_icon( 'shield-check', 26 ); ?></div>
						<h3><?php esc_html_e( '24/7 SLA &amp; AMC Coverage', 'gp-industry' ); ?></h3>
						<p><?php esc_html_e( 'Guaranteed on-site emergency dispatch within 2 hours, continuous IoT telemetry, and priority spare parts replenishment.', 'gp-industry' ); ?></p>
					</div>
				</div>
			</div>
		</section>

		<!-- ── 4-Stage Execution Methodology ── -->
		<section class="b2b-methodology-section section-pad">
			<div class="nova-container">
				<div class="section-heading align-center" data-reveal>
					<span class="section-eyebrow"><?php esc_html_e( 'Engagement Framework', 'gp-industry' ); ?></span>
					<h2 class="section-title"><?php esc_html_e( 'Our 4-Stage Execution Methodology', 'gp-industry' ); ?></h2>
					<p class="section-text"><?php esc_html_e( 'Every project follows a disciplined engineering protocol that guarantees transparency, safety compliance, and deterministic milestones.', 'gp-industry' ); ?></p>
				</div>

				<div class="b2b-method-grid">
					<div class="b2b-method-card" data-reveal>
						<span class="method-step-tag">01</span>
						<h3><?php esc_html_e( 'Diagnostics &amp; Baseline', 'gp-industry' ); ?></h3>
						<p><?php esc_html_e( 'On-site technical inspection using calibrated analyzers, laser metrology, and asset criticality ranking.', 'gp-industry' ); ?></p>
					</div>
					<div class="b2b-method-card" data-reveal data-reveal-delay="70">
						<span class="method-step-tag">02</span>
						<h3><?php esc_html_e( 'Simulation &amp; Design', 'gp-industry' ); ?></h3>
						<p><?php esc_html_e( 'CAD 3D modeling, stress FEA simulation, piping P&amp;ID verification, and comprehensive BOM finalization.', 'gp-industry' ); ?></p>
					</div>
					<div class="b2b-method-card" data-reveal data-reveal-delay="140">
						<span class="method-step-tag">03</span>
						<h3><?php esc_html_e( 'Execution &amp; Testing', 'gp-industry' ); ?></h3>
						<p><?php esc_html_e( 'Certified engineers perform mechanical erection, wiring, loop tests, and FAT/SAT verification with zero OSHA incidents.', 'gp-industry' ); ?></p>
					</div>
					<div class="b2b-method-card" data-reveal data-reveal-delay="210">
						<span class="method-step-tag">04</span>
						<h3><?php esc_html_e( 'Telemetry &amp; AMC', 'gp-industry' ); ?></h3>
						<p><?php esc_html_e( 'Continuous condition monitoring, scheduled preventive visits, priority spares, and 24/7 hotline coverage.', 'gp-industry' ); ?></p>
					</div>
				</div>
			</div>
		</section>

		<!-- ── Emergency Support Callout (Direct Proposal RFQ) ── -->
		<section id="contact" class="single-prod-cad-section section-pad">
			<div class="nova-container">
				<div class="single-cad-banner" data-reveal>
					<div class="single-cad-left">
						<span class="b2b-kicker">
							<span class="b2b-kicker-dot"></span>
							<span><?php esc_html_e( '24/7 Field Support Hotline', 'gp-industry' ); ?></span>
						</span>
						<h2><?php esc_html_e( 'Facing Critical Equipment Breakdown or Planning Plant Turnaround?', 'gp-industry' ); ?></h2>
						<p><?php esc_html_e( 'Speak directly with our senior application engineers. We evaluate your facility requirements, schedule rapid diagnostic dispatch, and provide itemized engineering proposals.', 'gp-industry' ); ?></p>
						<div class="single-cad-features">
							<span><?php gpi_the_icon( 'shield-check', 16 ); ?> <?php esc_html_e( 'Strict Confidentiality &amp; NDA', 'gp-industry' ); ?></span>
							<span><?php gpi_the_icon( 'clock', 16 ); ?> <?php esc_html_e( 'Under 2-Hour Emergency Response', 'gp-industry' ); ?></span>
							<span><?php gpi_the_icon( 'award', 16 ); ?> <?php esc_html_e( 'OSHA &bull; ASME Certified Teams', 'gp-industry' ); ?></span>
						</div>
					</div>
					<div class="single-cad-right">
						<a href="<?php echo esc_url( $gpi_cta_url ); ?>" class="btn btn-primary btn-lg">
							<span><?php esc_html_e( 'Request Engineering Proposal', 'gp-industry' ); ?></span>
							<?php gpi_the_icon( 'arrow-right', 16 ); ?>
						</a>
						<?php if ( gpi_get_option( 'phone' ) ) : ?>
							<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', gpi_get_option( 'phone' ) ) ); ?>" class="btn btn-ghost btn-lg">
								<?php gpi_the_icon( 'clock', 16 ); ?>
								<span><?php esc_html_e( 'Call Emergency Desk', 'gp-industry' ); ?></span>
							</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</section>

		<!-- ── Sibling Services Showcase ── -->
		<?php
		$gpi_siblings = get_pages(
			array(
				'parent'      => $gpi_parent_id ? $gpi_parent_id : get_the_ID(),
				'exclude'     => array( get_the_ID() ),
				'sort_column' => 'menu_order,post_title',
				'number'      => 3,
			)
		);

		if ( $gpi_siblings ) :
			?>
			<section class="single-prod-siblings-section section-pad">
				<div class="nova-container">
					<div class="section-heading align-center" data-reveal>
						<span class="section-eyebrow"><?php esc_html_e( 'Complementary Capabilities', 'gp-industry' ); ?></span>
						<h2 class="section-title"><?php esc_html_e( 'Explore Other Engineering Services', 'gp-industry' ); ?></h2>
					</div>

					<div class="b2b-card-grid">
						<?php foreach ( $gpi_siblings as $sib ) : ?>
							<div class="b2b-solution-card" data-reveal>
								<div class="b2b-card-media">
									<?php
									if ( has_post_thumbnail( $sib->ID ) ) {
										echo get_the_post_thumbnail( $sib->ID, 'nova-card', array( 'class' => 'b2b-card-img', 'loading' => 'lazy' ) );
									} else {
										?>
										<div class="b2b-card-fallback-media b2b-bg-3">
											<?php gpi_the_icon( 'factory', 44 ); ?>
										</div>
										<?php
									}
									?>
								</div>
								<div class="b2b-card-body">
									<h3 class="b2b-card-title">
										<a href="<?php echo esc_url( get_permalink( $sib ) ); ?>"><?php echo esc_html( $sib->post_title ); ?></a>
									</h3>
									<p class="b2b-card-desc">
										<?php echo esc_html( wp_trim_words( wp_strip_all_tags( strip_shortcodes( $sib->post_content ) ), 16 ) ); ?>
									</p>
									<div class="b2b-card-footer">
										<a href="<?php echo esc_url( get_permalink( $sib ) ); ?>" class="b2b-link-arrow">
											<span><?php esc_html_e( 'Explore Service Scope', 'gp-industry' ); ?></span>
											<?php gpi_the_icon( 'arrow-right', 16 ); ?>
										</a>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</section>
		<?php endif; ?>

	</article>

	<?php
endwhile;

get_footer();
