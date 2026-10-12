<?php
/**
 * Template Name: Product Detail
 * Template Post Type: page
 *
 * Dedicated Modern B2B Product Detail Layout:
 * Split Hero with Quick Specs & CTAs → Key Capabilities Bento Grid →
 * Full Technical Specifications Matrix → Custom Engineering & Consulting Workflow →
 * Direct CAD Drawing Evaluation Callout → Sibling Products Showcase.
 *
 * @package GPIndustry
 */

get_header();

while ( have_posts() ) :
	the_post();

	$gpi_parent_id = wp_get_post_parent_id( get_the_ID() );
	$gpi_cta_url   = gpi_get_option( 'header_cta_url', '#contact' );
	?>

	<!-- ── Product Detail Hero (Split 2-Column) ── -->
	<section class="single-prod-hero-section">
		<div class="hero-orbs" aria-hidden="true"><span class="orb orb-1"></span><span class="orb orb-2"></span></div>
		<div class="nova-container">
			<div class="single-prod-hero-inner">
				<div class="single-prod-hero-content" data-reveal>
					<?php gpi_breadcrumbs(); ?>

					<div class="b2b-kicker">
						<span class="b2b-kicker-dot"></span>
						<span><?php echo $gpi_parent_id ? esc_html( get_the_title( $gpi_parent_id ) ) : esc_html__( 'Products', 'gp-industry' ); ?> &bull; <?php esc_html_e( 'Precision Manufacturing', 'gp-industry' ); ?></span>
					</div>

					<h1 class="single-prod-title"><?php the_title(); ?></h1>

					<p class="single-prod-lead">
						<?php
						if ( has_excerpt() ) {
							echo esc_html( get_the_excerpt() );
						} else {
							esc_html_e( 'Precision engineered for high-duty industrial cycles, extreme environmental tolerances, and seamless enterprise system integration.', 'gp-industry' );
						}
						?>
					</p>

					<!-- Quick Specs Badges -->
					<div class="single-prod-specs-bar">
						<div class="prod-spec-box">
							<span class="spec-box-label"><?php esc_html_e( 'Tolerance', 'gp-industry' ); ?></span>
							<strong class="spec-box-val">&plusmn;0.005 mm</strong>
						</div>
						<div class="prod-spec-box">
							<span class="spec-box-label"><?php esc_html_e( 'Quality Assurance', 'gp-industry' ); ?></span>
							<strong class="spec-box-val">100% CMM Tested</strong>
						</div>
						<div class="prod-spec-box">
							<span class="spec-box-label"><?php esc_html_e( 'Compliance', 'gp-industry' ); ?></span>
							<strong class="spec-box-val">ISO 9001 / ASME</strong>
						</div>
						<div class="prod-spec-box">
							<span class="spec-box-label"><?php esc_html_e( 'Feasibility Review', 'gp-industry' ); ?></span>
							<strong class="spec-box-val">&lt; 24 Hours</strong>
						</div>
					</div>

					<div class="single-prod-actions">
						<a href="<?php echo esc_url( $gpi_cta_url ); ?>" class="btn btn-primary btn-lg">
							<span><?php esc_html_e( 'Request Technical RFQ', 'gp-industry' ); ?></span>
							<?php gpi_the_icon( 'arrow-right', 16 ); ?>
						</a>
						<a href="#tech-specs" class="btn btn-ghost btn-lg">
							<?php gpi_the_icon( 'file', 16 ); ?>
							<span><?php esc_html_e( 'View Specifications', 'gp-industry' ); ?></span>
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
							<div class="single-prod-fallback b2b-bg-1">
								<?php gpi_the_icon( 'cog', 64 ); ?>
								<span><?php the_title(); ?></span>
							</div>
							<?php
						}
						?>
						<div class="single-prod-badge">
							<span class="badge-dot"></span>
							<span><?php esc_html_e( 'Verified Industrial Standards &bull; ISO Certified', 'gp-industry' ); ?></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'template-page single-product-page' ); ?>>

		<!-- ── Technical Overview & Features ── -->
		<section class="single-prod-overview section-pad">
			<div class="nova-container">
				<div class="section-heading" data-reveal>
					<span class="section-eyebrow"><?php esc_html_e( 'Product Overview', 'gp-industry' ); ?></span>
					<h2 class="section-title"><?php esc_html_e( 'Engineered for Demanding Industrial Applications', 'gp-industry' ); ?></h2>
				</div>

				<div class="single-prod-prose entry-content" data-reveal>
					<?php the_content(); ?>
				</div>

				<!-- Core Capabilities (3 Bento Cards) -->
				<div class="single-prod-bento">
					<div class="bento-feature-card" data-reveal>
						<div class="bento-icon"><?php gpi_the_icon( 'target', 26 ); ?></div>
						<h3><?php esc_html_e( 'Micron-Level Tolerance', 'gp-industry' ); ?></h3>
						<p><?php esc_html_e( 'Fabricated on multi-axis CNC machining centers achieving precision repeatability to &plusmn;0.005mm with verified CMM metrology inspection logs.', 'gp-industry' ); ?></p>
					</div>
					<div class="bento-feature-card" data-reveal data-reveal-delay="70">
						<div class="bento-icon"><?php gpi_the_icon( 'shield-check', 26 ); ?></div>
						<h3><?php esc_html_e( 'Certified Material Alloys', 'gp-industry' ); ?></h3>
						<p><?php esc_html_e( 'Machined from certified Titanium Grade 5, Inconel 718, Stainless Steel (316L/Duplex), and Aerospace Aluminum with EN 10204 3.1 mill test certificates.', 'gp-industry' ); ?></p>
					</div>
					<div class="bento-feature-card" data-reveal data-reveal-delay="140">
						<div class="bento-icon"><?php gpi_the_icon( 'award', 26 ); ?></div>
						<h3><?php esc_html_e( '100% FAT Testing', 'gp-industry' ); ?></h3>
						<p><?php esc_html_e( 'Every unit undergoes rigorous Factory Acceptance Testing (FAT), surface roughness verification (Ra &le; 0.4&mu;m), and ultrasonic NDT before dispatch.', 'gp-industry' ); ?></p>
					</div>
				</div>
			</div>
		</section>

		<!-- ── Full Technical Specifications Table ── -->
		<section id="tech-specs" class="single-prod-specs-section section-pad">
			<div class="nova-container">
				<div class="section-heading align-center" data-reveal>
					<span class="section-eyebrow"><?php esc_html_e( 'Technical Matrix', 'gp-industry' ); ?></span>
					<h2 class="section-title"><?php esc_html_e( 'Manufacturing &amp; Engineering Specifications', 'gp-industry' ); ?></h2>
					<p class="section-text"><?php esc_html_e( 'Detailed dimensional limits, material grades, inspection protocols, and lead times.', 'gp-industry' ); ?></p>
				</div>

				<div class="single-specs-card" data-reveal>
					<table class="single-specs-table">
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
		</section>

		<!-- ── CAD / Drawing Evaluation Callout (Direct RFQ) ── -->
		<section id="contact" class="single-prod-cad-section section-pad">
			<div class="nova-container">
				<div class="single-cad-banner" data-reveal>
					<div class="single-cad-left">
						<span class="b2b-kicker">
							<span class="b2b-kicker-dot"></span>
							<span><?php esc_html_e( '24-Hour Engineering Feasibility', 'gp-industry' ); ?></span>
						</span>
						<h2><?php esc_html_e( 'Have CAD Blueprints or Custom Specifications?', 'gp-industry' ); ?></h2>
						<p><?php esc_html_e( 'Upload your 2D/3D drawings (STEP, IGES, DXF, DWG, PDF). Our senior application engineers will evaluate DFM feasibility, review tolerances, and provide an itemized proposal under mutual NDA.', 'gp-industry' ); ?></p>
						<div class="single-cad-features">
							<span><?php gpi_the_icon( 'shield-check', 16 ); ?> <?php esc_html_e( 'Strict Confidentiality &amp; NDA', 'gp-industry' ); ?></span>
							<span><?php gpi_the_icon( 'clock', 16 ); ?> <?php esc_html_e( 'Guaranteed 24h Turnaround', 'gp-industry' ); ?></span>
							<span><?php gpi_the_icon( 'file', 16 ); ?> <?php esc_html_e( 'Full DFM Optimization Report', 'gp-industry' ); ?></span>
						</div>
					</div>
					<div class="single-cad-right">
						<a href="<?php echo esc_url( $gpi_cta_url ); ?>" class="btn btn-primary btn-lg">
							<span><?php esc_html_e( 'Submit CAD for Engineering Review', 'gp-industry' ); ?></span>
							<?php gpi_the_icon( 'arrow-right', 16 ); ?>
						</a>
						<?php if ( gpi_get_option( 'phone' ) ) : ?>
							<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', gpi_get_option( 'phone' ) ) ); ?>" class="btn btn-ghost btn-lg">
								<?php gpi_the_icon( 'clock', 16 ); ?>
								<span><?php esc_html_e( 'Call Technical Desk', 'gp-industry' ); ?></span>
							</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</section>

		<!-- ── Other Solutions in This Category ── -->
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
						<span class="section-eyebrow"><?php esc_html_e( 'Related Solutions', 'gp-industry' ); ?></span>
						<h2 class="section-title"><?php esc_html_e( 'Explore Other Systems in This Lineup', 'gp-industry' ); ?></h2>
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
										<div class="b2b-card-fallback-media b2b-bg-1">
											<?php gpi_the_icon( 'cog', 44 ); ?>
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
											<span><?php esc_html_e( 'View Specifications', 'gp-industry' ); ?></span>
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
