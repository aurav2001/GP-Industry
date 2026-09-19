<?php
/**
 * Template Name: Courses Catalog / Listing
 * Template Post Type: page
 *
 * Displays a modern directory of training courses, programs, certifications,
 * with filter badges, duration, level, rating, and direct enroll links.
 *
 * @package GPIndustry
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>

	<!-- Courses Page Hero -->
	<section class="page-hero section-pad">
		<div class="nova-container">
			<?php gpi_breadcrumbs(); ?>
			<span class="section-eyebrow"><?php esc_html_e( 'Training & Certifications', 'gp-industry' ); ?></span>
			<h1 class="page-hero-title"><?php the_title(); ?></h1>
			<p class="page-hero-text">
				<?php
				if ( has_excerpt() ) {
					echo esc_html( get_the_excerpt() );
				} else {
					esc_html_e( 'Industry-accredited training programs engineered to bridge the skill gap with hands-on practical expertise.', 'gp-industry' );
				}
				?>
			</p>
		</div>
	</section>

	<section class="courses-catalog-section section-pad">
		<div class="nova-container">
			<!-- Intro content if written by user in WordPress editor -->
			<?php
			$gpi_content = trim( get_the_content() );
			if ( ! empty( $gpi_content ) ) :
				?>
				<div class="courses-page-intro entry-content" style="margin-bottom: var(--spacing-2xl);">
					<?php the_content(); ?>
				</div>
			<?php endif; ?>

			<!-- Child pages as Course cards, or default curated course grid -->
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
				<div class="courses-card-grid">
					<?php
					$i = 0;
					while ( $gpi_children->have_posts() ) :
						$gpi_children->the_post();
						?>
						<div class="course-card" data-reveal data-reveal-delay="<?php echo esc_attr( $i * 70 ); ?>">
							<div class="course-card-thumb">
								<?php
								if ( has_post_thumbnail() ) {
									the_post_thumbnail( 'nova-card' );
								} else {
									?>
									<div class="course-card-fallback-media">
										<span class="fallback-course-icon">🎓</span>
									</div>
									<?php
								}
								?>
								<span class="course-level-badge"><?php esc_html_e( 'Certified', 'gp-industry' ); ?></span>
							</div>

							<div class="course-card-body">
								<div class="course-card-meta-top">
									<span class="rating-stars">★★★★★ <span>4.9</span></span>
									<span class="course-hours">⏱ 8 Weeks</span>
								</div>

								<h3 class="course-card-title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h3>

								<p class="course-card-excerpt">
									<?php
									if ( has_excerpt() ) {
										echo esc_html( get_the_excerpt() );
									} else {
										echo esc_html( wp_trim_words( get_the_content(), 15 ) );
									}
									?>
								</p>

								<div class="course-card-footer">
									<a href="<?php the_permalink(); ?>" class="btn btn-sm btn-primary">
										<?php esc_html_e( 'View Syllabus', 'gp-industry' ); ?> →
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
				<!-- Showcase standard course cards if no child pages exist yet -->
				<div class="courses-card-grid">
					<!-- Course 1 -->
					<div class="course-card" data-reveal>
						<div class="course-card-thumb">
							<div class="course-card-fallback-media bg-gradient-1">
								<span class="fallback-course-icon">⚡</span>
							</div>
							<span class="course-level-badge"><?php esc_html_e( 'Most Popular', 'gp-industry' ); ?></span>
						</div>
						<div class="course-card-body">
							<div class="course-card-meta-top">
								<span class="rating-stars">★★★★★ <span>4.9</span></span>
								<span class="course-hours">⏱ 10 Weeks</span>
							</div>
							<h3 class="course-card-title"><?php esc_html_e( 'Industrial Automation & PLC/SCADA Programming', 'gp-industry' ); ?></h3>
							<p class="course-card-excerpt"><?php esc_html_e( 'Comprehensive training on Siemens & Allen-Bradley PLCs, HMI interfacing, wiring, sensor integration and live plant automation.', 'gp-industry' ); ?></p>
							<div class="course-card-footer">
								<span class="course-price"><?php esc_html_e( 'Certificate Included', 'gp-industry' ); ?></span>
								<a href="#inquire" class="btn btn-sm btn-primary"><?php esc_html_e( 'Learn More', 'gp-industry' ); ?> →</a>
							</div>
						</div>
					</div>

					<!-- Course 2 -->
					<div class="course-card" data-reveal data-reveal-delay="70">
						<div class="course-card-thumb">
							<div class="course-card-fallback-media bg-gradient-2">
								<span class="fallback-course-icon">⚙️</span>
							</div>
							<span class="course-level-badge"><?php esc_html_e( 'Hands-on Lab', 'gp-industry' ); ?></span>
						</div>
						<div class="course-card-body">
							<div class="course-card-meta-top">
								<span class="rating-stars">★★★★★ <span>4.8</span></span>
								<span class="course-hours">⏱ 8 Weeks</span>
							</div>
							<h3 class="course-card-title"><?php esc_html_e( 'CNC Machining & Precision CAD/CAM Design', 'gp-industry' ); ?></h3>
							<p class="course-card-excerpt"><?php esc_html_e( 'Master SolidWorks, AutoCAD 3D modeling, G-Code/M-Code programming, and precision CNC milling operation.', 'gp-industry' ); ?></p>
							<div class="course-card-footer">
								<span class="course-price"><?php esc_html_e( 'Industry Project', 'gp-industry' ); ?></span>
								<a href="#inquire" class="btn btn-sm btn-primary"><?php esc_html_e( 'Learn More', 'gp-industry' ); ?> →</a>
							</div>
						</div>
					</div>

					<!-- Course 3 -->
					<div class="course-card" data-reveal data-reveal-delay="140">
						<div class="course-card-thumb">
							<div class="course-card-fallback-media bg-gradient-3">
								<span class="fallback-course-icon">🛡️</span>
							</div>
							<span class="course-level-badge"><?php esc_html_e( 'Certified', 'gp-industry' ); ?></span>
						</div>
						<div class="course-card-body">
							<div class="course-card-meta-top">
								<span class="rating-stars">★★★★★ <span>5.0</span></span>
								<span class="course-hours">⏱ 6 Weeks</span>
							</div>
							<h3 class="course-card-title"><?php esc_html_e( 'Industrial Safety, OSHA & Quality Inspection', 'gp-industry' ); ?></h3>
							<p class="course-card-excerpt"><?php esc_html_e( 'Occupational health hazard management, ISO standards, Six Sigma quality control, and workplace safety compliance certification.', 'gp-industry' ); ?></p>
							<div class="course-card-footer">
								<span class="course-price"><?php esc_html_e( 'Govt. Recognized', 'gp-industry' ); ?></span>
								<a href="#inquire" class="btn btn-sm btn-primary"><?php esc_html_e( 'Learn More', 'gp-industry' ); ?> →</a>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<?php
	// Load CTA banner at bottom
	get_template_part( 'template-parts/sections/cta' );

endwhile;

get_footer();
