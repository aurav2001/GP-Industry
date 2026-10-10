<?php
/**
 * Template Name: Services Page
 * Template Post Type: page
 *
 * Clean Modern B2B Engineering Consulting & Industrial Services Layout:
 * Executive Hero → Reliability Stats Ribbon →
 * 4 Core Service Pillars (Modern Bento Cards) →
 * 4-Phase Engagement Methodology → Standards & Compliance →
 * Executive Consultation & RFQ CTA.
 *
 * @package GPIndustry
 */

get_header();

while ( have_posts() ) :
	the_post();

	$gpi_cta_url = gpi_get_option( 'header_cta_url', '#contact' );
	?>

	<!-- ── Executive Services Hero ── -->
	<section class="page-hero page-hero-template b2b-hero">
		<div class="hero-orbs" aria-hidden="true"><span class="orb orb-1"></span><span class="orb orb-2"></span></div>
		<div class="nova-container page-hero-inner">
			<div class="page-hero-content" data-reveal>
				<?php gpi_breadcrumbs(); ?>
				<div class="b2b-kicker">
					<span class="b2b-kicker-dot"></span>
					<span><?php esc_html_e( 'Lifecycle Engineering &amp; Plant Operations', 'gp-industry' ); ?></span>
				</div>
				<h1 class="page-hero-title"><?php the_title(); ?></h1>
				<p class="page-hero-text">
					<?php
					if ( has_excerpt() ) {
						echo esc_html( get_the_excerpt() );
					} else {
						esc_html_e( 'Turnkey engineering solutions, predictive maintenance, and automation modernization designed to minimize downtime, maximize throughput, and ensure safety compliance.', 'gp-industry' );
					}
					?>
				</p>
				<div class="b2b-hero-actions">
					<a href="#service-pillars" class="btn btn-primary btn-lg">
						<span><?php esc_html_e( 'Explore Engineering Services', 'gp-industry' ); ?></span>
						<?php gpi_the_icon( 'arrow-down', 16 ); ?>
					</a>
					<a href="<?php echo esc_url( $gpi_cta_url ); ?>" class="btn btn-ghost btn-lg">
						<?php gpi_the_icon( 'file', 16 ); ?>
						<span><?php esc_html_e( 'Request Engineering Proposal', 'gp-industry' ); ?></span>
					</a>
				</div>
			</div>
		</div>
	</section>

	<!-- ── Operational Reliability Metrics ── -->
	<section class="b2b-stats-bar">
		<div class="nova-container">
			<div class="b2b-stats-grid">
				<div class="b2b-stat-item" data-reveal>
					<span class="b2b-stat-number">99.8%</span>
					<span class="b2b-stat-label"><?php esc_html_e( 'Plant Availability Uptime', 'gp-industry' ); ?></span>
				</div>
				<div class="b2b-stat-item" data-reveal data-reveal-delay="70">
					<span class="b2b-stat-number">&lt; 2 Hrs</span>
					<span class="b2b-stat-label"><?php esc_html_e( 'Emergency Dispatch Response', 'gp-industry' ); ?></span>
				</div>
				<div class="b2b-stat-item" data-reveal data-reveal-delay="140">
					<span class="b2b-stat-number">500+</span>
					<span class="b2b-stat-label"><?php esc_html_e( 'Facilities Commissioned', 'gp-industry' ); ?></span>
				</div>
				<div class="b2b-stat-item" data-reveal data-reveal-delay="210">
					<span class="b2b-stat-number"><?php esc_html_e( 'Zero Harm', 'gp-industry' ); ?></span>
					<span class="b2b-stat-label"><?php esc_html_e( 'ISO 45001 Safety Record', 'gp-industry' ); ?></span>
				</div>
			</div>
		</div>
	</section>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'template-page b2b-services-page' ); ?>>

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

		<!-- ── Core Service Pillars (Modern Clean Cards) ── -->
		<section id="service-pillars" class="b2b-pillars-section section-pad">
			<div class="nova-container">
				<div class="section-heading align-center" data-reveal>
					<span class="section-eyebrow"><?php esc_html_e( 'Our Capabilities', 'gp-industry' ); ?></span>
					<h2 class="section-title"><?php esc_html_e( 'Core Industrial Engineering Disciplines', 'gp-industry' ); ?></h2>
					<p class="section-text"><?php esc_html_e( 'From greenfield commissioning to continuous health telemetry, our certified specialists ensure seamless execution and regulatory compliance.', 'gp-industry' ); ?></p>
				</div>

				<?php
				$gpi_children = get_pages(
					array(
						'parent'      => get_the_ID(),
						'sort_column' => 'menu_order,post_title',
					)
				);

				if ( $gpi_children ) :
					?>
					<div class="b2b-pillars-grid">
						<?php
						$i = 0;
						$pillar_icons = array( 'factory', 'chart', 'bolt', 'sparkles', 'target', 'shield-check' );

						foreach ( $gpi_children as $gpi_child ) :
							$icon_key = $pillar_icons[ $i % count( $pillar_icons ) ];
							$excerpt  = $gpi_child->post_excerpt ? $gpi_child->post_excerpt : wp_trim_words( wp_strip_all_tags( strip_shortcodes( $gpi_child->post_content ) ), 24 );
							?>
							<div class="b2b-pillar-card" data-reveal data-reveal-delay="<?php echo esc_attr( ( $i % 2 ) * 100 ); ?>">
								<div class="pillar-top-row">
									<div class="pillar-icon-box"><?php gpi_the_icon( $icon_key, 28 ); ?></div>
									<span class="pillar-index"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
								</div>
								<h3 class="pillar-title">
									<a href="<?php echo esc_url( get_permalink( $gpi_child ) ); ?>"><?php echo esc_html( $gpi_child->post_title ); ?></a>
								</h3>
								<p class="pillar-desc"><?php echo esc_html( $excerpt ); ?></p>
								<div class="pillar-footer">
									<a href="<?php echo esc_url( get_permalink( $gpi_child ) ); ?>" class="b2b-link-arrow">
										<span><?php esc_html_e( 'Explore Service Scope', 'gp-industry' ); ?></span>
										<?php gpi_the_icon( 'arrow-right', 16 ); ?>
									</a>
								</div>
							</div>
							<?php
							$i++;
						endforeach;
						?>
					</div>

				<?php else : ?>

					<!-- Curated 4 Pillars Showcase -->
					<div class="b2b-pillars-grid">
						
						<!-- Pillar 1 -->
						<div class="b2b-pillar-card" data-reveal>
							<div class="pillar-top-row">
								<div class="pillar-icon-box"><?php gpi_the_icon( 'factory', 28 ); ?></div>
								<span class="pillar-index">01</span>
							</div>
							<h3 class="pillar-title"><?php esc_html_e( 'Turnkey Plant Commissioning &amp; EPC', 'gp-industry' ); ?></h3>
							<p class="pillar-desc"><?php esc_html_e( 'Complete mechanical, electrical, and piping (MEP) execution for processing plants, factory complexes, and automated manufacturing lines from foundation to commercial production.', 'gp-industry' ); ?></p>
							<ul class="pillar-checklist">
								<li><?php gpi_the_icon( 'check', 14 ); ?> <?php esc_html_e( 'P&amp;ID verification &amp; 3D routing', 'gp-industry' ); ?></li>
								<li><?php gpi_the_icon( 'check', 14 ); ?> <?php esc_html_e( 'Equipment foundation &amp; laser alignment', 'gp-industry' ); ?></li>
								<li><?php gpi_the_icon( 'check', 14 ); ?> <?php esc_html_e( 'Full FAT/SAT testing &amp; hand-over dossier', 'gp-industry' ); ?></li>
							</ul>
							<div class="pillar-footer">
								<a href="<?php echo esc_url( $gpi_cta_url ); ?>" class="b2b-link-arrow">
									<span><?php esc_html_e( 'Consult an EPC Specialist', 'gp-industry' ); ?></span>
									<?php gpi_the_icon( 'arrow-right', 16 ); ?>
								</a>
							</div>
						</div>

						<!-- Pillar 2 -->
						<div class="b2b-pillar-card" data-reveal data-reveal-delay="100">
							<div class="pillar-top-row">
								<div class="pillar-icon-box"><?php gpi_the_icon( 'chart', 28 ); ?></div>
								<span class="pillar-index">02</span>
							</div>
							<h3 class="pillar-title"><?php esc_html_e( 'Predictive Maintenance &amp; Health Diagnostics', 'gp-industry' ); ?></h3>
							<p class="pillar-desc"><?php esc_html_e( 'Prevent catastrophic machinery breakdown. We deploy spectral vibration analytics, infrared thermography, and ultrasound testing to detect anomalies weeks before failure occurs.', 'gp-industry' ); ?></p>
							<ul class="pillar-checklist">
								<li><?php gpi_the_icon( 'check', 14 ); ?> <?php esc_html_e( 'ISO 10816 vibration severity mapping', 'gp-industry' ); ?></li>
								<li><?php gpi_the_icon( 'check', 14 ); ?> <?php esc_html_e( 'Infrared thermography for panels &amp; motors', 'gp-industry' ); ?></li>
								<li><?php gpi_the_icon( 'check', 14 ); ?> <?php esc_html_e( 'Dynamic in-situ rotor balancing', 'gp-industry' ); ?></li>
							</ul>
							<div class="pillar-footer">
								<a href="<?php echo esc_url( $gpi_cta_url ); ?>" class="b2b-link-arrow">
									<span><?php esc_html_e( 'Schedule Diagnostics Audit', 'gp-industry' ); ?></span>
									<?php gpi_the_icon( 'arrow-right', 16 ); ?>
								</a>
							</div>
						</div>

						<!-- Pillar 3 -->
						<div class="b2b-pillar-card" data-reveal>
							<div class="pillar-top-row">
								<div class="pillar-icon-box"><?php gpi_the_icon( 'bolt', 28 ); ?></div>
								<span class="pillar-index">03</span>
							</div>
							<h3 class="pillar-title"><?php esc_html_e( 'SCADA, PLC &amp; Automation Retrofitting', 'gp-industry' ); ?></h3>
							<p class="pillar-desc"><?php esc_html_e( 'Modernize obsolete legacy control systems with modern Siemens, Allen-Bradley, or Schneider platforms. Achieve real-time telemetry, OEE visualization, and zero production cutover downtime.', 'gp-industry' ); ?></p>
							<ul class="pillar-checklist">
								<li><?php gpi_the_icon( 'check', 14 ); ?> <?php esc_html_e( 'Legacy code decompilation &amp; migration', 'gp-industry' ); ?></li>
								<li><?php gpi_the_icon( 'check', 14 ); ?> <?php esc_html_e( 'ISA-101 high-performance HMI graphics', 'gp-industry' ); ?></li>
								<li><?php gpi_the_icon( 'check', 14 ); ?> <?php esc_html_e( 'OPC UA, MQTT &amp; IEC 62443 cyber-hardening', 'gp-industry' ); ?></li>
							</ul>
							<div class="pillar-footer">
								<a href="<?php echo esc_url( $gpi_cta_url ); ?>" class="b2b-link-arrow">
									<span><?php esc_html_e( 'Discuss Automation Retrofit', 'gp-industry' ); ?></span>
									<?php gpi_the_icon( 'arrow-right', 16 ); ?>
								</a>
							</div>
						</div>

						<!-- Pillar 4 -->
						<div class="b2b-pillar-card" data-reveal data-reveal-delay="100">
							<div class="pillar-top-row">
								<div class="pillar-icon-box"><?php gpi_the_icon( 'sparkles', 28 ); ?></div>
								<span class="pillar-index">04</span>
							</div>
							<h3 class="pillar-title"><?php esc_html_e( 'Energy Auditing &amp; Decarbonization', 'gp-industry' ); ?></h3>
							<p class="pillar-desc"><?php esc_html_e( 'Slash manufacturing energy costs by 15% to 35%. We conduct comprehensive electrical load profiling, waste heat recovery design, and compressed air leak mapping with guaranteed payback periods.', 'gp-industry' ); ?></p>
							<ul class="pillar-checklist">
								<li><?php gpi_the_icon( 'check', 14 ); ?> <?php esc_html_e( 'Flue gas waste heat recovery design', 'gp-industry' ); ?></li>
								<li><?php gpi_the_icon( 'check', 14 ); ?> <?php esc_html_e( 'Ultrasonic acoustic air leak quantification', 'gp-industry' ); ?></li>
								<li><?php gpi_the_icon( 'check', 14 ); ?> <?php esc_html_e( 'Investment-grade ROI &amp; ESG reporting', 'gp-industry' ); ?></li>
							</ul>
							<div class="pillar-footer">
								<a href="<?php echo esc_url( $gpi_cta_url ); ?>" class="b2b-link-arrow">
									<span><?php esc_html_e( 'Book Investment-Grade Audit', 'gp-industry' ); ?></span>
									<?php gpi_the_icon( 'arrow-right', 16 ); ?>
								</a>
							</div>
						</div>

					</div>
				<?php endif; ?>
			</div>
		</section>

		<!-- ── 4-Phase Methodology (Clean Step Timeline) ── -->
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

		<!-- ── Compliance Standards ── -->
		<section class="b2b-standards-section section-pad">
			<div class="nova-container">
				<div class="section-heading align-center" data-reveal>
					<span class="section-eyebrow"><?php esc_html_e( 'Governance', 'gp-industry' ); ?></span>
					<h2 class="section-title"><?php esc_html_e( 'Certified to Global Engineering Standards', 'gp-industry' ); ?></h2>
				</div>

				<div class="b2b-standards-grid">
					<div class="b2b-standard-card" data-reveal>
						<strong>ISO 9001:2015</strong>
						<span><?php esc_html_e( 'Quality Management &amp; Traceability', 'gp-industry' ); ?></span>
					</div>
					<div class="b2b-standard-card" data-reveal data-reveal-delay="70">
						<strong>ISO 45001:2018</strong>
						<span><?php esc_html_e( 'Occupational Health &amp; Safety', 'gp-industry' ); ?></span>
					</div>
					<div class="b2b-standard-card" data-reveal data-reveal-delay="140">
						<strong>ASME Sec VIII / IX</strong>
						<span><?php esc_html_e( 'Pressure Vessels &amp; Coded Welding', 'gp-industry' ); ?></span>
					</div>
					<div class="b2b-standard-card" data-reveal data-reveal-delay="210">
						<strong>ATEX &bull; IECEx</strong>
						<span><?php esc_html_e( 'Hazardous Zone Explosion Safety', 'gp-industry' ); ?></span>
					</div>
				</div>
			</div>
		</section>

		<!-- ── Executive Consultation CTA ── -->
		<section class="b2b-cta-section">
			<div class="nova-container">
				<div class="b2b-cta-card" data-reveal>
					<div class="b2b-cta-body">
						<span class="b2b-cta-kicker"><?php esc_html_e( '24/7 Emergency &amp; Scheduled Services', 'gp-industry' ); ?></span>
						<h2 class="b2b-cta-title"><?php esc_html_e( 'Facing Critical Equipment Breakdown or Planning Plant Turnaround?', 'gp-industry' ); ?></h2>
						<p class="b2b-cta-desc"><?php esc_html_e( 'Our application engineers and field specialists are ready to discuss your requirements, provide rapid feasibility assessments, and dispatch on-site diagnostics.', 'gp-industry' ); ?></p>
					</div>
					<div class="b2b-cta-actions">
						<a href="<?php echo esc_url( $gpi_cta_url ); ?>" class="btn btn-primary btn-lg">
							<span><?php esc_html_e( 'Request Engineering Proposal', 'gp-industry' ); ?></span>
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
