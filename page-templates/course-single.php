<?php
/**
 * Template Name: Course Detail / Syllabus
 * Template Post Type: page
 *
 * Dedicated modern layout for training courses, academy classes and workshops.
 * Features: Rich Course Hero, Curriculum/Syllabus, What You'll Learn, Sticky Enrollment Sidebar & Quick Inquiry.
 *
 * @package GPIndustry
 */

get_header();

while ( have_posts() ) :
	the_post();

	$gpi_form_result = gpi_process_contact_form();

	$gpi_duration = get_post_meta( get_the_ID(), '_course_duration', true );
	if ( ! $gpi_duration ) {
		$gpi_duration = esc_html__( '8 Weeks (Self-paced + Live)', 'gp-industry' );
	}

	$gpi_level = get_post_meta( get_the_ID(), '_course_level', true );
	if ( ! $gpi_level ) {
		$gpi_level = esc_html__( 'Beginner to Advanced', 'gp-industry' );
	}

	$gpi_cert = get_post_meta( get_the_ID(), '_course_cert', true );
	if ( ! $gpi_cert ) {
		$gpi_cert = esc_html__( 'Govt. / Industry Recognized Certificate', 'gp-industry' );
	}
	?>

	<!-- Course Hero -->
	<section class="course-hero section-pad">
		<div class="nova-container">
			<?php gpi_breadcrumbs(); ?>
			<div class="course-hero-badges">
				<span class="course-badge course-badge-highlight">★ <?php esc_html_e( 'Popular Course', 'gp-industry' ); ?></span>
				<span class="course-badge"><?php echo esc_html( $gpi_level ); ?></span>
			</div>
			<h1 class="course-hero-title"><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?>
				<p class="course-hero-subtitle"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php endif; ?>

			<div class="course-meta-pills">
				<div class="course-meta-pill">
					<span class="pill-icon"><?php gpi_the_icon( 'clock', 18 ); ?></span>
					<div>
						<small><?php esc_html_e( 'Duration', 'gp-industry' ); ?></small>
						<strong><?php echo esc_html( $gpi_duration ); ?></strong>
					</div>
				</div>
				<div class="course-meta-pill">
					<span class="pill-icon"><?php gpi_the_icon( 'award', 18 ); ?></span>
					<div>
						<small><?php esc_html_e( 'Certification', 'gp-industry' ); ?></small>
						<strong><?php echo esc_html( $gpi_cert ); ?></strong>
					</div>
				</div>
				<div class="course-meta-pill">
					<span class="pill-icon"><?php gpi_the_icon( 'star', 18 ); ?></span>
					<div>
						<small><?php esc_html_e( 'Student Rating', 'gp-industry' ); ?></small>
						<strong>4.9 / 5.0 (250+ Reviews)</strong>
					</div>
				</div>
			</div>
		</div>
	</section>

	<div class="nova-container section-pad">
		<div class="course-layout-grid">
			<!-- Main Content Column -->
			<div class="course-main-content">
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="course-featured-media" data-reveal>
						<?php the_post_thumbnail( 'nova-wide' ); ?>
					</div>
				<?php endif; ?>

				<!-- What you will learn highlight card -->
				<div class="course-highlights-card" data-reveal>
					<h3 class="highlights-title"><?php gpi_the_icon( 'target', 20 ); ?> <?php esc_html_e( 'What You Will Learn In This Course', 'gp-industry' ); ?></h3>
					<ul class="highlights-grid">
						<li><?php gpi_the_icon( 'check', 16 ); ?> <?php esc_html_e( 'Hands-on practical training with real-world case studies', 'gp-industry' ); ?></li>
						<li><?php gpi_the_icon( 'check', 16 ); ?> <?php esc_html_e( 'Industry standard best practices, safety codes & procedures', 'gp-industry' ); ?></li>
						<li><?php gpi_the_icon( 'check', 16 ); ?> <?php esc_html_e( 'Comprehensive troubleshooting, tools & modern techniques', 'gp-industry' ); ?></li>
						<li><?php gpi_the_icon( 'check', 16 ); ?> <?php esc_html_e( 'Live project completion with mentor guidance and evaluation', 'gp-industry' ); ?></li>
					</ul>
				</div>

				<!-- Course Description / Editor Content -->
				<div class="course-content-block" data-reveal>
					<h2 class="course-section-heading"><?php esc_html_e( 'Course Overview & Curriculum', 'gp-industry' ); ?></h2>
					<div class="entry-content">
						<?php
						$gpi_content = trim( get_the_content() );
						if ( ! empty( $gpi_content ) ) {
							the_content();
						} else {
							// Helpful starter outline if page is newly created
							?>
							<p><?php esc_html_e( 'This course is tailored for students and working professionals aiming to master industrial and engineering principles through structured modules, practical lab sessions, and direct expert mentorship.', 'gp-industry' ); ?></p>
							
							<div class="course-curriculum-accordion">
								<div class="curriculum-item">
									<div class="curriculum-header">
										<span class="module-number"><?php esc_html_e( 'Module 1', 'gp-industry' ); ?></span>
										<h4><?php esc_html_e( 'Fundamental Concepts & Industry Introduction', 'gp-industry' ); ?></h4>
									</div>
									<div class="curriculum-body">
										<p><?php esc_html_e( 'Overview of foundational theories, safety guidelines, terminology, and core workflow setup.', 'gp-industry' ); ?></p>
									</div>
								</div>
								<div class="curriculum-item">
									<div class="curriculum-header">
										<span class="module-number"><?php esc_html_e( 'Module 2', 'gp-industry' ); ?></span>
										<h4><?php esc_html_e( 'Applied Technical Methodologies & Tools', 'gp-industry' ); ?></h4>
									</div>
									<div class="curriculum-body">
										<p><?php esc_html_e( 'Working with industrial equipment, software simulations, and diagnostic instruments.', 'gp-industry' ); ?></p>
									</div>
								</div>
								<div class="curriculum-item">
									<div class="curriculum-header">
										<span class="module-number"><?php esc_html_e( 'Module 3', 'gp-industry' ); ?></span>
										<h4><?php esc_html_e( 'Advanced Optimization & Real-World Capstone Project', 'gp-industry' ); ?></h4>
									</div>
									<div class="curriculum-body">
										<p><?php esc_html_e( 'Execution of an end-to-end industrial project, final review, and certification assessment.', 'gp-industry' ); ?></p>
									</div>
								</div>
							</div>
							<?php
						}
						?>
					</div>
				</div>

				<!-- Certification & Career Guidance Block -->
				<div class="course-cert-card" data-reveal>
					<div class="cert-icon"><?php gpi_the_icon( 'award', 28 ); ?></div>
					<div class="cert-info">
						<h3><?php esc_html_e( 'Industry Recognized Certification', 'gp-industry' ); ?></h3>
						<p><?php esc_html_e( 'Upon successful completion, receive a verified digital certificate that you can showcase on LinkedIn, your resume, and to prospective employers.', 'gp-industry' ); ?></p>
					</div>
				</div>
			</div>

			<!-- Sticky Enrollment Sidebar -->
			<aside class="course-sidebar">
				<div class="course-sidebar-sticky">
					<div class="course-enroll-card" data-reveal>
						<div class="enroll-badge"><?php esc_html_e( 'Admissions Open', 'gp-industry' ); ?></div>
						<h3 class="enroll-title"><?php esc_html_e( 'Enroll In This Course', 'gp-industry' ); ?></h3>
						<p class="enroll-subtitle"><?php esc_html_e( 'Limited seats per batch for personalized mentoring.', 'gp-industry' ); ?></p>

						<ul class="course-perks-list">
							<li><span class="perk-check"><?php gpi_the_icon( 'check', 14 ); ?></span> <?php esc_html_e( 'Full Course Access & Materials', 'gp-industry' ); ?></li>
							<li><span class="perk-check"><?php gpi_the_icon( 'check', 14 ); ?></span> <?php esc_html_e( '1-on-1 Mentor Doubt Sessions', 'gp-industry' ); ?></li>
							<li><span class="perk-check"><?php gpi_the_icon( 'check', 14 ); ?></span> <?php esc_html_e( 'Practical Lab & Project Assignments', 'gp-industry' ); ?></li>
							<li><span class="perk-check"><?php gpi_the_icon( 'check', 14 ); ?></span> <?php esc_html_e( 'Placement Assistance & Resume Review', 'gp-industry' ); ?></li>
						</ul>

						<!-- Quick Inquiry Form inside Course Sidebar -->
						<div class="course-inquiry-box">
							<h4><?php esc_html_e( 'Request Syllabus & Fee Details', 'gp-industry' ); ?></h4>
							<?php gpi_contact_form_alert( $gpi_form_result ); ?>
							<form method="post" action="<?php echo esc_url( get_permalink() . '#enquire' ); ?>" class="course-quick-form" id="enquire">
								<?php wp_nonce_field( 'gpi_contact_action', 'gpi_contact_nonce' ); ?>
								<div class="gpi-hp" aria-hidden="true"><label>Website<input type="text" name="gpi_website" tabindex="-1" autocomplete="off"></label></div>
								<input type="hidden" name="gpi_subject" value="<?php echo esc_attr( 'Course Inquiry: ' . get_the_title() ); ?>">
								
								<div class="form-group-compact">
									<input type="text" name="gpi_name" required placeholder="<?php esc_attr_e( 'Your Name', 'gp-industry' ); ?>" class="compact-input">
								</div>
								<div class="form-group-compact">
									<input type="tel" name="gpi_phone" required placeholder="<?php esc_attr_e( 'Phone / WhatsApp', 'gp-industry' ); ?>" class="compact-input">
								</div>
								<div class="form-group-compact">
									<input type="email" name="gpi_email" required placeholder="<?php esc_attr_e( 'Email Address', 'gp-industry' ); ?>" class="compact-input">
								</div>
								<input type="hidden" name="gpi_message" value="<?php echo esc_attr( 'Interested in syllabus and enrollment for course: ' . get_the_title() ); ?>">

								<button type="submit" name="gpi_contact_submit" class="btn btn-primary btn-block">
									<?php esc_html_e( 'Request syllabus & fees', 'gp-industry' ); ?><?php gpi_the_icon( 'arrow-right', 16 ); ?>
								</button>
							</form>
						</div>
					</div>

					<!-- Direct Helpline Card -->
					<div class="course-helpline-card" data-reveal data-reveal-delay="100">
						<div class="helpline-icon"><?php gpi_the_icon( 'phone', 22 ); ?></div>
						<div>
							<small><?php esc_html_e( 'Have questions about eligibility?', 'gp-industry' ); ?></small>
							<?php
							$gpi_phone = gpi_get_option( 'contact_phone', '' );
							?>
							<strong><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $gpi_phone ) ); ?>"><?php echo esc_html( $gpi_phone ); ?></a></strong>
						</div>
					</div>
				</div>
			</aside>
		</div>
	</div>

	<?php
	// Load CTA banner at bottom
	get_template_part( 'template-parts/sections/cta' );

endwhile;

get_footer();
