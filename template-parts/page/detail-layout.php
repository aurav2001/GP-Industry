<?php
/**
 * Modern Detail Page Layout for Products & Services
 *
 * Featured Media & Status Ribbon → Technical Spec Mini-Strip →
 * Interactive Content Tabs (Overview, Specs, Consulting, Quality Certs) →
 * Consulting & Solutions Section → CAD / RFQ Consultation Box →
 * Sticky Engineering Sidebar → Related Solutions Grid.
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = wp_parse_args(
	isset( $args ) ? $args : array(),
	array(
		'nav_title_fallback' => esc_html__( 'Solutions', 'gp-industry' ),
		'quote_button'       => esc_html__( 'Request a Proposal', 'gp-industry' ),
	)
);

$gpi_parent_id = wp_get_post_parent_id( get_the_ID() );
$gpi_cta_url   = gpi_get_option( 'header_cta_url', '#contact' );
?>

<div class="nova-container detail-page-container">
	<div class="service-layout detail-layout-modern">
		
		<!-- ── Main Content Column ── -->
		<div class="service-main detail-main-modern">
			
			<!-- Featured Media Frame with Status Badge -->
			<?php
			$detail_thumb_id   = get_post_thumbnail_id( get_the_ID() );
			$detail_thumb_post = $detail_thumb_id ? get_post( $detail_thumb_id ) : null;
			$detail_is_synth   = $detail_thumb_post && ( false !== strpos( $detail_thumb_post->post_name, 'gpi-demo-' ) || false !== strpos( (string) $detail_thumb_post->guid, 'gpi-demo-' ) );
			$gpi_detail_img    = '';

			if ( ! $detail_is_synth && has_post_thumbnail() ) {
				$gpi_detail_img = get_the_post_thumbnail( get_the_ID(), 'nova-wide', array( 'class' => 'detail-featured-media' ) );
			} else {
				$fallback_src = function_exists( 'gpi_get_page_image_url' ) ? gpi_get_page_image_url( get_the_ID() ) : '';
				if ( $fallback_src ) {
					$gpi_detail_img = '<img src="' . esc_url( $fallback_src ) . '" alt="' . the_title_attribute( array( 'echo' => false ) ) . '" class="detail-featured-media">';
				}
			}

			if ( $gpi_detail_img ) :
				?>
				<figure class="service-featured detail-hero-figure" data-reveal>
					<?php echo $gpi_detail_img; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<div class="service-featured-badge">
						<span class="badge-dot"></span>
						<span class="badge-text"><?php esc_html_e( 'Precision Engineered &bull; 100% Quality Inspected', 'gp-industry' ); ?></span>
					</div>
					<div class="detail-model-tag">
						<span><?php esc_html_e( 'Model / Spec ID: GPI-', 'gp-industry' ); ?><?php the_ID(); ?></span>
					</div>
				</figure>
			<?php endif; ?>

			<!-- ── Engineering Specs Quick Ribbon ── -->
			<div class="service-spec-strip detail-spec-strip" data-reveal>
				<div class="spec-strip-item">
					<div class="spec-strip-icon"><?php gpi_the_icon( 'target', 20 ); ?></div>
					<div class="spec-strip-info">
						<span class="spec-strip-label"><?php esc_html_e( 'Precision Tolerance', 'gp-industry' ); ?></span>
						<strong class="spec-strip-val">&plusmn;0.005 mm (5&mu;)</strong>
					</div>
				</div>
				<div class="spec-strip-item">
					<div class="spec-strip-icon"><?php gpi_the_icon( 'shield-check', 20 ); ?></div>
					<div class="spec-strip-info">
						<span class="spec-strip-label"><?php esc_html_e( 'QA Metrology', 'gp-industry' ); ?></span>
						<strong class="spec-strip-val">100% CMM Inspected</strong>
					</div>
				</div>
				<div class="spec-strip-item">
					<div class="spec-strip-icon"><?php gpi_the_icon( 'clock', 20 ); ?></div>
					<div class="spec-strip-info">
						<span class="spec-strip-label"><?php esc_html_e( 'Engineering Review', 'gp-industry' ); ?></span>
						<strong class="spec-strip-val">&lt; 24h Turnaround</strong>
					</div>
				</div>
				<div class="spec-strip-item">
					<div class="spec-strip-icon"><?php gpi_the_icon( 'award', 20 ); ?></div>
					<div class="spec-strip-info">
						<span class="spec-strip-label"><?php esc_html_e( 'Standard Compliance', 'gp-industry' ); ?></span>
						<strong class="spec-strip-val">ISO 9001 / ASME</strong>
					</div>
				</div>
			</div>

			<!-- ── Interactive Technical Tabs ── -->
			<div class="detail-tabs-wrapper" data-reveal>
				<div class="detail-tabs-nav" role="tablist">
					<button class="detail-tab-btn is-active" data-tab="tab-overview" role="tab" aria-selected="true">
						<?php gpi_the_icon( 'layers', 16 ); ?>
						<span><?php esc_html_e( 'Overview &amp; Scope', 'gp-industry' ); ?></span>
					</button>
					<button class="detail-tab-btn" data-tab="tab-specs" role="tab" aria-selected="false">
						<?php gpi_the_icon( 'cog', 16 ); ?>
						<span><?php esc_html_e( 'Technical Specs', 'gp-industry' ); ?></span>
					</button>
					<button class="detail-tab-btn" data-tab="tab-consulting" role="tab" aria-selected="false">
						<?php gpi_the_icon( 'chart', 16 ); ?>
						<span><?php esc_html_e( 'Engineering Consulting', 'gp-industry' ); ?></span>
					</button>
					<button class="detail-tab-btn" data-tab="tab-qa" role="tab" aria-selected="false">
						<?php gpi_the_icon( 'shield-check', 16 ); ?>
						<span><?php esc_html_e( 'Quality &amp; Certs', 'gp-industry' ); ?></span>
					</button>
				</div>

				<!-- Tab 1: Overview & Page Content -->
				<div id="tab-overview" class="detail-tab-pane is-active" role="tabpanel">
					<div class="detail-prose-content entry-content">
						<?php
						if ( function_exists( 'gpi_get_enhanced_detail_content' ) ) {
							echo gpi_get_enhanced_detail_content(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						} else {
							the_content();
						}
						?>
					</div>
				</div>

				<!-- Tab 2: Technical Specifications Matrix -->
				<div id="tab-specs" class="detail-tab-pane" role="tabpanel">
					<div class="detail-specs-table-card">
						<h3 class="detail-pane-title"><?php esc_html_e( 'Manufacturing &amp; Engineering Parameters', 'gp-industry' ); ?></h3>
						<table class="detail-specs-table">
							<tbody>
								<tr>
									<th><?php esc_html_e( 'Machining Tolerances', 'gp-industry' ); ?></th>
									<td>&plusmn;0.005 mm (5 microns) on 5-Axis CNC Machining Centers</td>
								</tr>
								<tr>
									<th><?php esc_html_e( 'Material Compatibility', 'gp-industry' ); ?></th>
									<td>Titanium, Inconel 718, Stainless Steel (304/316/Duplex), Alloy Steel, Forged Aluminum 7075</td>
								</tr>
								<tr>
									<th><?php esc_html_e( 'Surface Finishing', 'gp-industry' ); ?></th>
									<td>Ra 0.4 &mu;m (Precision Ground), Hard Anodizing, Electropolishing, Passivation, Ceramic Coating</td>
								</tr>
								<tr>
									<th><?php esc_html_e( 'Non-Destructive Testing (NDT)', 'gp-industry' ); ?></th>
									<td>Ultrasonic Testing (UT), Magnetic Particle (MPI), Dye Penetrant (DPI), Hydrostatic Testing up to 1,000 bar</td>
								</tr>
								<tr>
									<th><?php esc_html_e( 'Quality Documentation', 'gp-industry' ); ?></th>
									<td>EN 10204 3.1 Material Test Certificates (MTC), Full CMM 3D Coordinate Inspection Logs, Heat Treatment Charts</td>
								</tr>
								<tr>
									<th><?php esc_html_e( 'Maximum Machining Envelope', 'gp-industry' ); ?></th>
									<td>Up to 4,500 mm &times; 2,800 mm &times; 1,800 mm (X/Y/Z) with 25-tonne heavy workpiece capacity</td>
								</tr>
								<tr>
									<th><?php esc_html_e( 'Turnaround &amp; Lead Time', 'gp-industry' ); ?></th>
									<td>Rapid Prototypes: 5&ndash;10 business days | Production Batches: 3&ndash;4 weeks with buffer stock agreement</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<!-- Tab 3: Engineering Consulting & Customization -->
				<div id="tab-consulting" class="detail-tab-pane" role="tabpanel">
					<div class="detail-consult-card">
						<div class="detail-consult-header">
							<span class="detail-consult-kicker"><?php gpi_the_icon( 'target', 14 ); ?> <?php esc_html_e( 'Strategic Industrial Consulting', 'gp-industry' ); ?></span>
							<h3 class="detail-consult-title"><?php esc_html_e( 'Custom Engineering &amp; Application Advisory', 'gp-industry' ); ?></h3>
							<p class="detail-consult-desc"><?php esc_html_e( 'Every engineering challenge is unique. Our senior application consultants work directly with your design and plant operations teams to optimize performance, eliminate failure modes, and reduce unit costs.', 'gp-industry' ); ?></p>
						</div>

						<div class="detail-consult-pillars">
							<div class="consult-pillar">
								<div class="pillar-icon"><?php gpi_the_icon( 'file', 22 ); ?></div>
								<h4><?php esc_html_e( 'DFM &amp; CAD Optimization', 'gp-industry' ); ?></h4>
								<p><?php esc_html_e( 'We analyze your 3D models for Design for Manufacturability (DFM), reducing cycle times and eliminating stress concentration points.', 'gp-industry' ); ?></p>
							</div>
							<div class="consult-pillar">
								<div class="pillar-icon"><?php gpi_the_icon( 'chart', 22 ); ?></div>
								<h4><?php esc_html_e( 'Finite Element Simulation (FEA)', 'gp-industry' ); ?></h4>
								<p><?php esc_html_e( 'Thermal and mechanical stress simulation under real-world operating loads to ensure zero fatigue failure in service.', 'gp-industry' ); ?></p>
							</div>
							<div class="consult-pillar">
								<div class="pillar-icon"><?php gpi_the_icon( 'cog', 22 ); ?></div>
								<h4><?php esc_html_e( 'Metallurgical Consulting', 'gp-industry' ); ?></h4>
								<p><?php esc_html_e( 'Expert material selection for extreme temperatures, corrosive fluids, high-pressure environments, and cryogenic duty.', 'gp-industry' ); ?></p>
							</div>
							<div class="consult-pillar">
								<div class="pillar-icon"><?php gpi_the_icon( 'shield-check', 22 ); ?></div>
								<h4><?php esc_html_e( 'Turnkey Integration &amp; AMC', 'gp-industry' ); ?></h4>
								<p><?php esc_html_e( 'On-site installation, factory acceptance testing, alignment verification, and ongoing maintenance coverage.', 'gp-industry' ); ?></p>
							</div>
						</div>
					</div>
				</div>

				<!-- Tab 4: Quality & Certifications -->
				<div id="tab-qa" class="detail-tab-pane" role="tabpanel">
					<div class="detail-qa-card">
						<h3 class="detail-pane-title"><?php esc_html_e( 'Traceability &amp; Quality Governance', 'gp-industry' ); ?></h3>
						<p><?php esc_html_e( 'All manufacturing and engineering execution adheres to accredited international standards with complete traceability from raw ingot to finished assembly.', 'gp-industry' ); ?></p>
						
						<div class="detail-qa-grid">
							<div class="qa-item">
								<span class="qa-badge">ISO 9001:2015</span>
								<strong><?php esc_html_e( 'Quality Management', 'gp-industry' ); ?></strong>
								<span><?php esc_html_e( 'Audited quality procedures and calibrated metrology inspection logs.', 'gp-industry' ); ?></span>
							</div>
							<div class="qa-item">
								<span class="qa-badge">EN 10204 3.1</span>
								<strong><?php esc_html_e( 'Material Test Certificates', 'gp-industry' ); ?></strong>
								<span><?php esc_html_e( 'Chemical composition, mechanical tensile strength, and heat number batch logs.', 'gp-industry' ); ?></span>
							</div>
							<div class="qa-item">
								<span class="qa-badge">ASME Sec IX</span>
								<strong><?php esc_html_e( 'Coded Welding &amp; Pressure', 'gp-industry' ); ?></strong>
								<span><?php esc_html_e( 'Qualified welding procedure specifications (WPS) and Welder Performance Qualifications (WPQ).', 'gp-industry' ); ?></span>
							</div>
							<div class="qa-item">
								<span class="qa-badge">CE / UL</span>
								<strong><?php esc_html_e( 'Electrical &amp; Machinery Safety', 'gp-industry' ); ?></strong>
								<span><?php esc_html_e( 'Low voltage directive, EMC compliance, and safety interlock verification.', 'gp-industry' ); ?></span>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- ── CAD / Drawing Review Consultation Banner ── -->
			<div class="detail-cad-box" data-reveal>
				<div class="detail-cad-left">
					<div class="cad-badge"><?php gpi_the_icon( 'file', 16 ); ?> <?php esc_html_e( 'Rapid CAD Evaluation', 'gp-industry' ); ?></div>
					<h3 class="cad-title"><?php esc_html_e( 'Have CAD Drawings or Custom Engineering Specs?', 'gp-industry' ); ?></h3>
					<p class="cad-desc"><?php esc_html_e( 'Upload your 2D/3D drawings (STEP, IGES, DXF, DWG, PDF). Our engineering team will review tolerances, run DFM feasibility, and provide an itemized quote within 24 hours under NDA.', 'gp-industry' ); ?></p>
				</div>
				<div class="detail-cad-right">
					<a href="<?php echo esc_url( $gpi_cta_url ); ?>" class="btn btn-primary btn-lg">
						<?php gpi_the_icon( 'file', 18 ); ?>
						<span><?php esc_html_e( 'Submit CAD for Review', 'gp-industry' ); ?></span>
					</a>
					<span class="cad-nda-note"><?php gpi_the_icon( 'shield-check', 14 ); ?> <?php esc_html_e( 'Confidential &bull; NDA Protected', 'gp-industry' ); ?></span>
				</div>
			</div>

		</div>

		<!-- ── Sticky Engineering Sidebar ── -->
		<aside class="service-sidebar detail-sidebar-modern">
			<div class="service-sidebar-inner">
				
				<!-- Sibling Solutions Directory Navigation -->
				<?php
				$gpi_siblings = get_pages(
					array(
						'parent'      => $gpi_parent_id ? $gpi_parent_id : get_the_ID(),
						'sort_column' => 'menu_order,post_title',
					)
				);

				if ( $gpi_siblings && count( $gpi_siblings ) > 1 ) :
					?>
					<div class="service-nav-card detail-nav-card" data-reveal>
						<div class="service-nav-header">
							<span class="service-nav-badge"><?php echo count( $gpi_siblings ); ?> <?php esc_html_e( 'Solutions', 'gp-industry' ); ?></span>
							<h3 class="service-nav-title"><?php echo $gpi_parent_id ? esc_html( get_the_title( $gpi_parent_id ) ) : esc_html( $args['nav_title_fallback'] ); ?></h3>
						</div>
						<ul class="service-nav">
							<?php foreach ( $gpi_siblings as $gpi_sib ) : ?>
								<li class="<?php echo get_the_ID() === $gpi_sib->ID ? 'is-current' : ''; ?>">
									<a href="<?php echo esc_url( get_permalink( $gpi_sib ) ); ?>">
										<span class="nav-sib-title"><?php echo esc_html( $gpi_sib->post_title ); ?></span>
										<?php gpi_the_icon( 'chevron-right', 14 ); ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>

				<!-- Senior Application Engineer Direct Contact Card -->
				<div class="detail-engineer-card" data-reveal>
					<div class="engineer-card-badge"><?php gpi_the_icon( 'users', 14 ); ?> <?php esc_html_e( 'Technical Support Desk', 'gp-industry' ); ?></div>
					<h4 class="engineer-card-title"><?php esc_html_e( 'Speak Directly With an Application Specialist', 'gp-industry' ); ?></h4>
					<p class="engineer-card-text"><?php esc_html_e( 'Get expert answers regarding material selection, surface coatings, tolerances, or custom batch pricing.', 'gp-industry' ); ?></p>
					<?php if ( gpi_get_option( 'phone' ) ) : ?>
						<a class="engineer-phone-btn" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', gpi_get_option( 'phone' ) ) ); ?>">
							<?php gpi_the_icon( 'clock', 16 ); ?>
							<span><?php echo esc_html( gpi_get_option( 'phone' ) ); ?></span>
						</a>
					<?php endif; ?>
				</div>

				<!-- Rapid Feasibility / RFQ Card -->
				<?php if ( $args['quote_button'] ) : ?>
					<div class="sidebar-cta-card" data-reveal>
						<div class="sidebar-cta-badge"><?php gpi_the_icon( 'bolt', 14 ); ?><?php esc_html_e( 'Engineering Proposal', 'gp-industry' ); ?></div>
						<h4 class="sidebar-cta-title"><?php esc_html_e( 'Ready for an Official Feasibility Review?', 'gp-industry' ); ?></h4>
						<p class="sidebar-cta-desc"><?php esc_html_e( 'Tell us your project scope, quantity requirements, and target timeline for a detailed technical proposal.', 'gp-industry' ); ?></p>
						<a class="btn btn-primary btn-block btn-lg" href="<?php echo esc_url( $gpi_cta_url ); ?>">
							<?php gpi_the_icon( 'file', 18 ); ?>
							<span><?php echo esc_html( $args['quote_button'] ); ?></span>
						</a>
						<div class="sidebar-guarantee">
							<?php gpi_the_icon( 'shield-check', 14 ); ?>
							<span><?php esc_html_e( 'Confidential &bull; NDA Protected', 'gp-industry' ); ?></span>
						</div>
					</div>
				<?php endif; ?>

			</div>
		</aside>

	</div>
</div>

<!-- Interactive Detail Tabs Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
	var tabBtns = document.querySelectorAll('.detail-tab-btn');
	var tabPanes = document.querySelectorAll('.detail-tab-pane');

	if (!tabBtns.length) return;

	tabBtns.forEach(function (btn) {
		btn.addEventListener('click', function () {
			var targetId = btn.getAttribute('data-tab');

			tabBtns.forEach(function (b) {
				b.classList.remove('is-active');
				b.setAttribute('aria-selected', 'false');
			});

			tabPanes.forEach(function (pane) {
				pane.classList.remove('is-active');
			});

			btn.classList.add('is-active');
			btn.setAttribute('aria-selected', 'true');

			var targetPane = document.getElementById(targetId);
			if (targetPane) {
				targetPane.classList.add('is-active');
			}
		});
	});
});
</script>
