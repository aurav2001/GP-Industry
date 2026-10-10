<?php
/**
 * Template Name: Consulting Page
 * Template Post Type: page
 *
 * Premium consulting page layout with structured sections:
 * Hero → Key Metrics → Approach → Domains → Engagement Process → Why Us → CTA.
 *
 * @package GPIndustry
 */

get_header();

while ( have_posts() ) :
	the_post();

	// ── Hero ──
	get_template_part(
		'template-parts/page/page-hero',
		null,
		array(
			'eyebrow' => esc_html__( 'Consulting Services', 'gp-industry' ),
			'align'   => 'left',
			'image'   => true,
		)
	);
	?>

	<!-- ── Key Metrics Strip ── -->
	<section class="consult-metrics" aria-label="<?php esc_attr_e( 'Key consulting numbers', 'gp-industry' ); ?>">
		<div class="nova-container">
			<div class="consult-metrics-grid">
				<div class="consult-metric" data-reveal>
					<div class="consult-metric-icon"><?php gpi_the_icon( 'chart', 24 ); ?></div>
					<span class="consult-metric-num">500+</span>
					<span class="consult-metric-label"><?php esc_html_e( 'Projects Delivered', 'gp-industry' ); ?></span>
				</div>
				<div class="consult-metric" data-reveal data-reveal-delay="80">
					<div class="consult-metric-icon"><?php gpi_the_icon( 'globe', 24 ); ?></div>
					<span class="consult-metric-num">12+</span>
					<span class="consult-metric-label"><?php esc_html_e( 'Industries Served', 'gp-industry' ); ?></span>
				</div>
				<div class="consult-metric" data-reveal data-reveal-delay="160">
					<div class="consult-metric-icon"><?php gpi_the_icon( 'award', 24 ); ?></div>
					<span class="consult-metric-num">98%</span>
					<span class="consult-metric-label"><?php esc_html_e( 'Client Satisfaction', 'gp-industry' ); ?></span>
				</div>
				<div class="consult-metric" data-reveal data-reveal-delay="240">
					<div class="consult-metric-icon"><?php gpi_the_icon( 'users', 24 ); ?></div>
					<span class="consult-metric-num">50+</span>
					<span class="consult-metric-label"><?php esc_html_e( 'Expert Consultants', 'gp-industry' ); ?></span>
				</div>
			</div>
		</div>
	</section>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'template-page template-consulting' ); ?>>

		<!-- ── Our Approach (zigzag) ── -->
		<section class="consult-approach auto-section">
			<div class="nova-container auto-section-inner">
				<div class="section-heading auto-heading align-center" data-reveal>
					<span class="section-eyebrow"><?php esc_html_e( 'Our Approach', 'gp-industry' ); ?></span>
					<h2 class="section-title"><?php esc_html_e( 'Strategic Methodology for Measurable Results', 'gp-industry' ); ?></h2>
					<div class="section-text"><p><?php esc_html_e( 'We combine deep industry knowledge with data-driven insights to craft strategies that create lasting competitive advantages for your business.', 'gp-industry' ); ?></p></div>
				</div>

				<div class="consult-zigzag">
					<?php
					$approach_items = array(
						array(
							'icon'  => 'target',
							'title' => __( 'Discovery & Assessment', 'gp-industry' ),
							'text'  => __( 'We begin with a comprehensive analysis of your current operations, market position, and organizational goals. Our assessment identifies strengths, gaps, and untapped opportunities through stakeholder interviews, data analytics, and industry benchmarking.', 'gp-industry' ),
							'tags'  => array( __( 'Stakeholder Interviews', 'gp-industry' ), __( 'Gap Analysis', 'gp-industry' ), __( 'Market Research', 'gp-industry' ) ),
						),
						array(
							'icon'  => 'layers',
							'title' => __( 'Strategy Development', 'gp-industry' ),
							'text'  => __( 'Based on our findings, we develop a tailored roadmap that aligns with your business objectives. Our strategies are practical, phased, and designed to deliver quick wins while building toward long-term transformation goals.', 'gp-industry' ),
							'tags'  => array( __( 'Roadmap Planning', 'gp-industry' ), __( 'Risk Mitigation', 'gp-industry' ), __( 'ROI Modeling', 'gp-industry' ) ),
						),
						array(
							'icon'  => 'cog',
							'title' => __( 'Implementation & Execution', 'gp-industry' ),
							'text'  => __( 'Our consultants work alongside your teams to execute strategies with precision. We provide hands-on project management, change management support, and real-time adjustments to ensure seamless adoption and measurable progress.', 'gp-industry' ),
							'tags'  => array( __( 'Project Management', 'gp-industry' ), __( 'Change Management', 'gp-industry' ), __( 'Quality Control', 'gp-industry' ) ),
						),
						array(
							'icon'  => 'chart',
							'title' => __( 'Performance Monitoring & Optimization', 'gp-industry' ),
							'text'  => __( 'We track KPIs, analyze outcomes, and continuously refine processes to maximize results. Post-engagement support ensures sustainability and positions your organization for ongoing growth and innovation.', 'gp-industry' ),
							'tags'  => array( __( 'KPI Tracking', 'gp-industry' ), __( 'Continuous Improvement', 'gp-industry' ), __( 'Growth Analytics', 'gp-industry' ) ),
						),
					);

					$zz_index = 0;
					foreach ( $approach_items as $item ) :
						$zz_delay = $zz_index * 100;
						?>
						<div class="consult-zigzag-row<?php echo 0 === $zz_index % 2 ? '' : ' consult-zigzag-row-reverse'; ?>" data-reveal data-reveal-delay="<?php echo esc_attr( $zz_delay ); ?>">
							<div class="consult-zigzag-visual">
								<div class="consult-zigzag-icon-wrap">
									<span class="consult-zigzag-step"><?php echo esc_html( str_pad( $zz_index + 1, 2, '0', STR_PAD_LEFT ) ); ?></span>
									<?php gpi_the_icon( $item['icon'], 32 ); ?>
								</div>
							</div>
							<div class="consult-zigzag-content">
								<h3 class="consult-zigzag-title"><?php echo esc_html( $item['title'] ); ?></h3>
								<p class="consult-zigzag-text"><?php echo esc_html( $item['text'] ); ?></p>
								<?php if ( ! empty( $item['tags'] ) ) : ?>
									<div class="consult-tags">
										<?php foreach ( $item['tags'] as $tag ) : ?>
											<span class="consult-tag"><?php echo esc_html( $tag ); ?></span>
										<?php endforeach; ?>
									</div>
								<?php endif; ?>
							</div>
						</div>
						<?php
						$zz_index++;
					endforeach;
					?>
				</div>
			</div>
		</section>

		<!-- ── Consulting Domains ── -->
		<section class="consult-domains auto-section auto-section-alt">
			<div class="nova-container auto-section-inner">
				<div class="section-heading auto-heading align-center" data-reveal>
					<span class="section-eyebrow"><?php esc_html_e( 'What We Do', 'gp-industry' ); ?></span>
					<h2 class="section-title"><?php esc_html_e( 'Consulting Domains', 'gp-industry' ); ?></h2>
					<div class="section-text"><p><?php esc_html_e( 'Our expertise spans critical areas of business strategy, operations, and technology — empowering organizations to transform challenges into competitive advantages.', 'gp-industry' ); ?></p></div>
				</div>

				<div class="consult-domain-grid">
					<?php
					$domains = array(
						array( 'icon' => 'factory',     'title' => __( 'Operations Consulting', 'gp-industry' ),     'desc' => __( 'Streamline processes, optimize supply chains, and implement lean manufacturing principles for maximum operational efficiency.', 'gp-industry' ) ),
						array( 'icon' => 'bolt',        'title' => __( 'Digital Transformation', 'gp-industry' ),    'desc' => __( 'Leverage emerging technologies — AI, IoT, cloud, and automation — to modernize operations and drive innovation.', 'gp-industry' ) ),
						array( 'icon' => 'shield',      'title' => __( 'Risk & Compliance', 'gp-industry' ),         'desc' => __( 'Navigate regulatory landscapes, build robust compliance frameworks, and mitigate risks across your enterprise.', 'gp-industry' ) ),
						array( 'icon' => 'ruler',        'title' => __( 'Engineering Feasibility', 'gp-industry' ),   'desc' => __( 'Evaluate technical viability of new products, processes, and capital projects with precision engineering analysis.', 'gp-industry' ) ),
						array( 'icon' => 'chart',       'title' => __( 'Financial Advisory', 'gp-industry' ),        'desc' => __( 'Drive profitability with cost optimization, financial modeling, investment analysis, and strategic budget planning.', 'gp-industry' ) ),
						array( 'icon' => 'users',       'title' => __( 'Organizational Strategy', 'gp-industry' ),   'desc' => __( 'Design high-performance teams, build leadership capacity, and create cultures that accelerate business goals.', 'gp-industry' ) ),
					);

					$d_delay = 0;
					foreach ( $domains as $domain ) :
						?>
						<div class="consult-domain-card" data-reveal data-reveal-delay="<?php echo esc_attr( $d_delay ); ?>">
							<div class="consult-domain-icon"><?php gpi_the_icon( $domain['icon'], 28 ); ?></div>
							<h3 class="consult-domain-title"><?php echo esc_html( $domain['title'] ); ?></h3>
							<p class="consult-domain-desc"><?php echo esc_html( $domain['desc'] ); ?></p>
						</div>
						<?php
						$d_delay += 70;
					endforeach;
					?>
				</div>
			</div>
		</section>

		<!-- ── Engagement Process Timeline ── -->
		<section class="consult-process auto-section">
			<div class="nova-container auto-section-inner">
				<div class="section-heading auto-heading align-center" data-reveal>
					<span class="section-eyebrow"><?php esc_html_e( 'How We Work', 'gp-industry' ); ?></span>
					<h2 class="section-title"><?php esc_html_e( 'Engagement Process', 'gp-industry' ); ?></h2>
					<div class="section-text"><p><?php esc_html_e( 'A transparent, structured approach that keeps you informed and in control at every stage of our collaboration.', 'gp-industry' ); ?></p></div>
				</div>

				<div class="consult-timeline">
					<?php
					$timeline = array(
						array( 'step' => '01', 'title' => __( 'Initial Consultation', 'gp-industry' ),  'desc' => __( 'Free consultation to understand your needs, define scope, and establish success criteria.', 'gp-industry' ), 'duration' => __( 'Week 1', 'gp-industry' ) ),
						array( 'step' => '02', 'title' => __( 'Diagnostic Review', 'gp-industry' ),     'desc' => __( 'In-depth assessment of operations, processes, and market positioning with comprehensive reporting.', 'gp-industry' ), 'duration' => __( 'Weeks 2–3', 'gp-industry' ) ),
						array( 'step' => '03', 'title' => __( 'Strategy Proposal', 'gp-industry' ),     'desc' => __( 'Custom strategy presentation with ROI projections, resource planning, and implementation timeline.', 'gp-industry' ), 'duration' => __( 'Week 4', 'gp-industry' ) ),
						array( 'step' => '04', 'title' => __( 'Active Engagement', 'gp-industry' ),     'desc' => __( 'Hands-on implementation with regular progress reporting, milestone reviews, and course corrections.', 'gp-industry' ), 'duration' => __( 'Ongoing', 'gp-industry' ) ),
						array( 'step' => '05', 'title' => __( 'Review & Handoff', 'gp-industry' ),      'desc' => __( 'Final performance review, documentation, knowledge transfer, and sustainability planning.', 'gp-industry' ), 'duration' => __( 'Final Phase', 'gp-industry' ) ),
					);

					$t_delay = 0;
					foreach ( $timeline as $tl ) :
						?>
						<div class="consult-timeline-item" data-reveal data-reveal-delay="<?php echo esc_attr( $t_delay ); ?>">
							<div class="consult-timeline-marker">
								<span class="consult-timeline-dot"></span>
							</div>
							<div class="consult-timeline-card">
								<span class="consult-timeline-step"><?php echo esc_html( $tl['step'] ); ?></span>
								<span class="consult-timeline-duration"><?php echo esc_html( $tl['duration'] ); ?></span>
								<h3 class="consult-timeline-title"><?php echo esc_html( $tl['title'] ); ?></h3>
								<p class="consult-timeline-desc"><?php echo esc_html( $tl['desc'] ); ?></p>
							</div>
						</div>
						<?php
						$t_delay += 100;
					endforeach;
					?>
				</div>
			</div>
		</section>

		<!-- ── Why Choose Us ── -->
		<section class="consult-why auto-section auto-section-alt">
			<div class="nova-container auto-section-inner">
				<div class="section-heading auto-heading align-center" data-reveal>
					<span class="section-eyebrow"><?php esc_html_e( 'Why Us', 'gp-industry' ); ?></span>
					<h2 class="section-title"><?php esc_html_e( 'What Sets Us Apart', 'gp-industry' ); ?></h2>
				</div>

				<div class="consult-why-grid">
					<?php
					$reasons = array(
						array( 'icon' => 'hardhat',     'title' => __( 'Industry Veterans', 'gp-industry' ),        'text' => __( 'Our team brings 20+ years of cross-industry experience, delivering insights that come only from deep domain expertise.', 'gp-industry' ) ),
						array( 'icon' => 'target',      'title' => __( 'Results-Driven', 'gp-industry' ),           'text' => __( 'We measure our success by yours. Every engagement is tied to quantifiable KPIs and tangible business outcomes.', 'gp-industry' ) ),
						array( 'icon' => 'wrench',      'title' => __( 'Tailored Solutions', 'gp-industry' ),       'text' => __( 'No cookie-cutter frameworks. Every strategy is custom-designed to fit your unique business context and challenges.', 'gp-industry' ) ),
						array( 'icon' => 'shield-check','title' => __( 'Trusted Partner', 'gp-industry' ),          'text' => __( 'We maintain the highest standards of integrity, confidentiality, and ethical practice in every engagement.', 'gp-industry' ) ),
					);

					$w_delay = 0;
					foreach ( $reasons as $reason ) :
						?>
						<div class="consult-why-card" data-reveal data-reveal-delay="<?php echo esc_attr( $w_delay ); ?>">
							<div class="consult-why-icon"><?php gpi_the_icon( $reason['icon'], 26 ); ?></div>
							<h3 class="consult-why-title"><?php echo esc_html( $reason['title'] ); ?></h3>
							<p class="consult-why-text"><?php echo esc_html( $reason['text'] ); ?></p>
						</div>
						<?php
						$w_delay += 80;
					endforeach;
					?>
				</div>
			</div>
		</section>

		<!-- ── User-authored content (auto-designed) ── -->
		<?php gpi_the_auto_layout( null, true ); ?>

	</article>

	<?php
	get_template_part( 'template-parts/sections/cta' );

endwhile;

get_footer();
