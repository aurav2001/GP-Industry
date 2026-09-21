<?php
/**
 * Block patterns: ready-made industrial sections users can insert into any page
 * (Editor → "+" → Patterns → GP-Industry Sections).
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the "GP-Industry" pattern category and all patterns.
 */
function gpi_register_block_patterns() {
	if ( ! function_exists( 'register_block_pattern' ) ) {
		return;
	}

	register_block_pattern_category(
		'gp-industry',
		array( 'label' => esc_html__( 'GP-Industry Sections', 'gp-industry' ) )
	);

	$img    = esc_url( GPI_THEME_URI . '/assets/images/placeholder.svg' );
	$avatar = esc_url( GPI_THEME_URI . '/assets/images/avatar.svg' );

	$patterns = array(
		'hero'           => array( esc_html__( 'Hero: consultancy headline', 'gp-industry' ), gpi_pattern_hero( $img ) ),
		'products'       => array( esc_html__( 'Solutions Grid (3 cards)', 'gp-industry' ), gpi_pattern_products( $img ) ),
		'services'       => array( esc_html__( 'Services Grid (3 cards)', 'gp-industry' ), gpi_pattern_services() ),
		'industries'     => array( esc_html__( 'Industries We Serve', 'gp-industry' ), gpi_pattern_industries() ),
		'process'        => array( esc_html__( 'Our Process (4 steps)', 'gp-industry' ), gpi_pattern_process() ),
		'features'       => array( esc_html__( 'Why Choose Us: image + checklist', 'gp-industry' ), gpi_pattern_features( $img ) ),
		'stats'          => array( esc_html__( 'Stats row', 'gp-industry' ), gpi_pattern_stats() ),
		'certifications' => array( esc_html__( 'Certifications & Clients', 'gp-industry' ), gpi_pattern_certifications() ),
		'specs'          => array( esc_html__( 'Engagement Details table', 'gp-industry' ), gpi_pattern_specs() ),
		'projects'       => array( esc_html__( 'Case Studies Gallery', 'gp-industry' ), gpi_pattern_projects( $img ) ),
		'testimonials'   => array( esc_html__( 'Client Testimonials', 'gp-industry' ), gpi_pattern_testimonials() ),
		'team'           => array( esc_html__( 'Leadership Team', 'gp-industry' ), gpi_pattern_team( $avatar ) ),
		'faq'            => array( esc_html__( 'FAQ accordion', 'gp-industry' ), gpi_pattern_faq() ),
		'cta'            => array( esc_html__( 'Request a Proposal banner', 'gp-industry' ), gpi_pattern_cta() ),
		'quote'          => array( esc_html__( 'Request a Proposal: info + form', 'gp-industry' ), gpi_pattern_quote() ),
	);

	foreach ( $patterns as $slug => $pattern ) {
		register_block_pattern(
			'gp-industry/' . $slug,
			array(
				'title'         => $pattern[0],
				'categories'    => array( 'gp-industry' ),
				'content'       => $pattern[1],
				'keywords'      => array( 'gp', 'section', 'industrial', $slug ),
				'viewportWidth' => 1240,
			)
		);
	}
}
add_action( 'init', 'gpi_register_block_patterns' );

/* ---------- Helpers ---------- */

/**
 * Section heading group.
 *
 * @param string $eyebrow Eyebrow.
 * @param string $title   Title.
 * @param string $text    Text.
 * @return string
 */
function gpi_pattern_heading( $eyebrow, $title, $text = '' ) {
	$out  = '<!-- wp:group {"className":"section-heading align-center","layout":{"type":"constrained","contentSize":"680px"}} -->' . "\n";
	$out .= '<div class="wp-block-group section-heading align-center">';
	$out .= '<!-- wp:paragraph {"align":"center","className":"section-eyebrow"} --><p class="has-text-align-center section-eyebrow">' . esc_html( $eyebrow ) . '</p><!-- /wp:paragraph -->' . "\n";
	$out .= '<!-- wp:heading {"textAlign":"center","className":"section-title"} --><h2 class="wp-block-heading has-text-align-center section-title">' . esc_html( $title ) . '</h2><!-- /wp:heading -->' . "\n";
	if ( $text ) {
		$out .= '<!-- wp:paragraph {"align":"center","className":"section-text"} --><p class="has-text-align-center section-text">' . esc_html( $text ) . '</p><!-- /wp:paragraph -->' . "\n";
	}
	$out .= '</div><!-- /wp:group -->' . "\n";
	return $out;
}

/**
 * Wide section wrapper.
 *
 * @param string $inner Inner blocks.
 * @param string $class Extra class.
 * @return string
 */
function gpi_pattern_section( $inner, $class = '' ) {
	$class = trim( 'nova-section ' . $class );
	return '<!-- wp:group {"align":"wide","className":"' . $class . '","layout":{"type":"default"}} -->' . "\n"
		. '<div class="wp-block-group alignwide ' . $class . '">' . "\n" . $inner . '</div>' . "\n" . '<!-- /wp:group -->';
}

/**
 * Button block.
 *
 * @param string $text  Label.
 * @param string $style Style class.
 * @param string $href  URL.
 * @return string
 */
function gpi_pattern_button( $text, $style = '', $href = '#contact' ) {
	$attr = $style ? '{"className":"' . $style . '"}' : '';
	return '<!-- wp:button ' . $attr . ' --><div class="wp-block-button ' . $style . '"><a class="wp-block-button__link wp-element-button" href="' . esc_url( $href ) . '">' . esc_html( $text ) . '</a></div><!-- /wp:button -->';
}

/**
 * Card column with emoji icon, title, text and optional button.
 *
 * @param string $icon   Emoji / text icon.
 * @param string $title  Title.
 * @param string $text   Text.
 * @param string $button Button label ('' to omit).
 * @param string $class  Column class.
 * @return string
 */
function gpi_pattern_card( $icon, $title, $text, $button = '', $class = 'nova-card' ) {
	$out  = '<!-- wp:column {"className":"' . $class . '"} --><div class="wp-block-column ' . $class . '">';
	if ( $icon ) {
		$out .= '<!-- wp:paragraph {"className":"nova-card-icon"} --><p class="nova-card-icon">' . $icon . '</p><!-- /wp:paragraph -->';
	}
	$out .= '<!-- wp:heading {"level":3,"className":"nova-card-title"} --><h3 class="wp-block-heading nova-card-title">' . esc_html( $title ) . '</h3><!-- /wp:heading -->';
	$out .= '<!-- wp:paragraph {"className":"nova-card-text"} --><p class="nova-card-text">' . esc_html( $text ) . '</p><!-- /wp:paragraph -->';
	if ( $button ) {
		$out .= '<!-- wp:buttons --><div class="wp-block-buttons">' . gpi_pattern_button( $button, 'is-style-outline', '#' ) . '</div><!-- /wp:buttons -->';
	}
	$out .= '</div><!-- /wp:column -->' . "\n";
	return $out;
}

/* ---------- Patterns ---------- */

/**
 * Hero.
 *
 * @param string $img Image URL.
 * @return string
 */
function gpi_pattern_hero( $img ) {
	$inner  = '<!-- wp:group {"className":"nova-pattern-hero","layout":{"type":"constrained","contentSize":"860px"}} -->' . "\n";
	$inner .= '<div class="wp-block-group nova-pattern-hero">';
	$inner .= '<!-- wp:paragraph {"align":"center","className":"section-eyebrow"} --><p class="has-text-align-center section-eyebrow">' . esc_html__( 'Corporate consultancy · ISO 9001 certified', 'gp-industry' ) . '</p><!-- /wp:paragraph -->' . "\n";
	$inner .= '<!-- wp:heading {"textAlign":"center","level":1,"className":"hero-title"} --><h1 class="wp-block-heading has-text-align-center hero-title">' . esc_html__( 'Workforce & facility solutions for', 'gp-industry' ) . ' <span>' . esc_html__( 'growing businesses', 'gp-industry' ) . '</span></h1><!-- /wp:heading -->' . "\n";
	$inner .= '<!-- wp:paragraph {"align":"center","className":"hero-subtitle"} --><p class="has-text-align-center hero-subtitle">' . esc_html__( 'Staffing, payroll, compliance, housekeeping and security — delivered by one accountable partner. Replace this text with your own pitch.', 'gp-industry' ) . '</p><!-- /wp:paragraph -->' . "\n";
	$inner .= '<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} --><div class="wp-block-buttons">' . gpi_pattern_button( esc_html__( 'Book a Consultation', 'gp-industry' ), 'is-style-nova-gradient' ) . gpi_pattern_button( esc_html__( 'Download Profile', 'gp-industry' ), 'is-style-outline', '#' ) . '</div><!-- /wp:buttons -->' . "\n";
	$inner .= '</div><!-- /wp:group -->' . "\n";
	$inner .= '<!-- wp:image {"sizeSlug":"large","className":"nova-pattern-hero-image"} --><figure class="wp-block-image size-large nova-pattern-hero-image"><img src="' . $img . '" alt=""/></figure><!-- /wp:image -->' . "\n";
	return gpi_pattern_section( $inner, 'nova-section-hero' );
}

/**
 * Products grid with images.
 *
 * @param string $img Image URL.
 * @return string
 */
function gpi_pattern_products( $img ) {
	$items = array(
		array( esc_html__( 'Workforce Outsourcing', 'gp-industry' ), esc_html__( 'Verified, trained staff on our payroll with supervision and a replacement guarantee.', 'gp-industry' ) ),
		array( esc_html__( 'Payroll & Compliance', 'gp-industry' ), esc_html__( 'End-to-end payroll with PF, ESIC, PT and labour-law compliance, audit-ready every month.', 'gp-industry' ) ),
		array( esc_html__( 'Facility Management', 'gp-industry' ), esc_html__( 'Housekeeping, security, pantry and maintenance under one accountable contract.', 'gp-industry' ) ),
	);
	$cols = '';
	foreach ( $items as $item ) {
		$cols .= '<!-- wp:column {"className":"nova-card nova-product-card"} --><div class="wp-block-column nova-card nova-product-card">';
		$cols .= '<!-- wp:image {"sizeSlug":"large","className":"nova-product-image"} --><figure class="wp-block-image size-large nova-product-image"><img src="' . $img . '" alt=""/></figure><!-- /wp:image -->';
		$cols .= '<!-- wp:heading {"level":3,"className":"nova-card-title"} --><h3 class="wp-block-heading nova-card-title">' . $item[0] . '</h3><!-- /wp:heading -->';
		$cols .= '<!-- wp:paragraph {"className":"nova-card-text"} --><p class="nova-card-text">' . $item[1] . '</p><!-- /wp:paragraph -->';
		$cols .= '<!-- wp:buttons --><div class="wp-block-buttons">' . gpi_pattern_button( esc_html__( 'View details', 'gp-industry' ), 'is-style-outline', '#' ) . '</div><!-- /wp:buttons -->';
		$cols .= '</div><!-- /wp:column -->' . "\n";
	}
	$inner  = gpi_pattern_heading( esc_html__( 'Our solutions', 'gp-industry' ), esc_html__( 'Solutions that keep your business running', 'gp-industry' ), esc_html__( 'Duplicate a column to add more solutions.', 'gp-industry' ) );
	$inner .= '<!-- wp:columns {"className":"nova-cards"} --><div class="wp-block-columns nova-cards">' . "\n" . $cols . '</div><!-- /wp:columns -->' . "\n";
	return gpi_pattern_section( $inner, 'nova-section-products' );
}

/**
 * Services grid.
 *
 * @return string
 */
function gpi_pattern_services() {
	$cols  = gpi_pattern_card( '👥', esc_html__( 'HR Staffing & Payroll', 'gp-industry' ), esc_html__( 'Vetted personnel, manager-level staff and 100% statutory payroll.', 'gp-industry' ), esc_html__( 'Learn more', 'gp-industry' ) );
	$cols .= gpi_pattern_card( '🧹', esc_html__( 'Housekeeping & Hygiene', 'gp-industry' ), esc_html__( 'Mechanised cleaning, pest control and hygiene audits.', 'gp-industry' ), esc_html__( 'Learn more', 'gp-industry' ) );
	$cols .= gpi_pattern_card( '🛡️', esc_html__( 'Security Services', 'gp-industry' ), esc_html__( 'PSARA-compliant guards, supervisors and access control.', 'gp-industry' ), esc_html__( 'Learn more', 'gp-industry' ) );
	$inner  = gpi_pattern_heading( esc_html__( 'Our services', 'gp-industry' ), esc_html__( 'Services you can rely on', 'gp-industry' ) );
	$inner .= '<!-- wp:columns {"className":"nova-cards"} --><div class="wp-block-columns nova-cards">' . "\n" . $cols . '</div><!-- /wp:columns -->' . "\n";
	return gpi_pattern_section( $inner, 'nova-section-services' );
}

/**
 * Industries we serve.
 *
 * @return string
 */
function gpi_pattern_industries() {
	$rows = array(
		array( '🏭', esc_html__( 'Manufacturing', 'gp-industry' ), esc_html__( 'Plant manpower, housekeeping and security.', 'gp-industry' ) ),
		array( '🏢', esc_html__( 'Corporate & IT', 'gp-industry' ), esc_html__( 'Facility management and support staff.', 'gp-industry' ) ),
		array( '🏥', esc_html__( 'Healthcare', 'gp-industry' ), esc_html__( 'Hygiene, housekeeping and patient support.', 'gp-industry' ) ),
		array( '🏨', esc_html__( 'Hospitality & Retail', 'gp-industry' ), esc_html__( 'Front-office, housekeeping and security teams.', 'gp-industry' ) ),
		array( '🏗️', esc_html__( 'Real Estate & Infra', 'gp-industry' ), esc_html__( 'Site security, maintenance and admin staffing.', 'gp-industry' ) ),
		array( '🎓', esc_html__( 'Education', 'gp-industry' ), esc_html__( 'Campus facility and support services.', 'gp-industry' ) ),
	);
	$cols = '';
	foreach ( $rows as $i => $row ) {
		if ( 0 === $i % 3 ) {
			$cols .= '<!-- wp:columns {"className":"nova-cards nova-industries"} --><div class="wp-block-columns nova-cards nova-industries">' . "\n";
		}
		$cols .= gpi_pattern_card( $row[0], $row[1], $row[2], '', 'nova-card nova-industry-card' );
		if ( 2 === $i % 3 ) {
			$cols .= '</div><!-- /wp:columns -->' . "\n";
		}
	}
	$inner = gpi_pattern_heading( esc_html__( 'Industries', 'gp-industry' ), esc_html__( 'Industries we serve', 'gp-industry' ), esc_html__( 'Proven experience across corporate, industrial and service sectors.', 'gp-industry' ) ) . $cols;
	return gpi_pattern_section( $inner, 'nova-section-industries' );
}

/**
 * Process steps.
 *
 * @return string
 */
function gpi_pattern_process() {
	$steps = array(
		array( esc_html__( 'Consultation', 'gp-industry' ), esc_html__( 'We study your sites, headcount, shifts and compliance needs.', 'gp-industry' ) ),
		array( esc_html__( 'Proposal', 'gp-industry' ), esc_html__( 'A tailored plan with SLAs, transparent costing and timelines.', 'gp-industry' ) ),
		array( esc_html__( 'Deployment', 'gp-industry' ), esc_html__( 'Vetted, trained personnel mobilised with on-site supervision.', 'gp-industry' ) ),
		array( esc_html__( 'Support & Reporting', 'gp-industry' ), esc_html__( 'Dedicated account manager, monthly MIS and compliance audits.', 'gp-industry' ) ),
	);
	$cols = '';
	foreach ( $steps as $i => $step ) {
		$cols .= '<!-- wp:column {"className":"nova-step"} --><div class="wp-block-column nova-step">';
		$cols .= '<!-- wp:paragraph {"className":"nova-step-number"} --><p class="nova-step-number">' . sprintf( '%02d', $i + 1 ) . '</p><!-- /wp:paragraph -->';
		$cols .= '<!-- wp:heading {"level":3,"className":"nova-step-title"} --><h3 class="wp-block-heading nova-step-title">' . $step[0] . '</h3><!-- /wp:heading -->';
		$cols .= '<!-- wp:paragraph {"className":"nova-step-text"} --><p class="nova-step-text">' . $step[1] . '</p><!-- /wp:paragraph -->';
		$cols .= '</div><!-- /wp:column -->' . "\n";
	}
	$inner  = gpi_pattern_heading( esc_html__( 'How we work', 'gp-industry' ), esc_html__( 'From consultation to deployment in four steps', 'gp-industry' ) );
	$inner .= '<!-- wp:columns {"className":"nova-process"} --><div class="wp-block-columns nova-process">' . "\n" . $cols . '</div><!-- /wp:columns -->' . "\n";
	return gpi_pattern_section( $inner, 'nova-section-process' );
}

/**
 * Why choose us: image + checklist.
 *
 * @param string $img Image URL.
 * @return string
 */
function gpi_pattern_features( $img ) {
	$rows = array(
		array( esc_html__( 'Vetted, trained workforce', 'gp-industry' ), esc_html__( 'Background-verified staff with role-specific induction from our own resource cell.', 'gp-industry' ) ),
		array( esc_html__( '100% statutory compliance', 'gp-industry' ), esc_html__( 'PF, ESIC, labour law and payroll handled end-to-end, audit-ready every month.', 'gp-industry' ) ),
		array( esc_html__( 'Pan-India deployment', 'gp-industry' ), esc_html__( 'Local supervisors and a central account manager for consistent service across sites.', 'gp-industry' ) ),
	);
	$list = '';
	foreach ( $rows as $row ) {
		$list .= '<!-- wp:group {"className":"nova-feature-row","layout":{"type":"default"}} --><div class="wp-block-group nova-feature-row">';
		$list .= '<!-- wp:heading {"level":4} --><h4 class="wp-block-heading">' . $row[0] . '</h4><!-- /wp:heading -->';
		$list .= '<!-- wp:paragraph --><p>' . $row[1] . '</p><!-- /wp:paragraph -->';
		$list .= '</div><!-- /wp:group -->' . "\n";
	}
	$inner  = '<!-- wp:columns {"verticalAlignment":"center","className":"nova-split"} --><div class="wp-block-columns are-vertically-aligned-center nova-split">' . "\n";
	$inner .= '<!-- wp:column {"verticalAlignment":"center"} --><div class="wp-block-column is-vertically-aligned-center">';
	$inner .= '<!-- wp:image {"sizeSlug":"large","className":"nova-split-image"} --><figure class="wp-block-image size-large nova-split-image"><img src="' . $img . '" alt=""/></figure><!-- /wp:image -->';
	$inner .= '</div><!-- /wp:column -->' . "\n";
	$inner .= '<!-- wp:column {"verticalAlignment":"center"} --><div class="wp-block-column is-vertically-aligned-center">';
	$inner .= '<!-- wp:paragraph {"className":"section-eyebrow"} --><p class="section-eyebrow">' . esc_html__( 'Why choose us', 'gp-industry' ) . '</p><!-- /wp:paragraph -->';
	$inner .= '<!-- wp:heading {"className":"section-title"} --><h2 class="wp-block-heading section-title">' . esc_html__( 'A consultancy partner you can depend on', 'gp-industry' ) . '</h2><!-- /wp:heading -->';
	$inner .= $list;
	$inner .= '<!-- wp:buttons --><div class="wp-block-buttons">' . gpi_pattern_button( esc_html__( 'Talk to a consultant', 'gp-industry' ), 'is-style-nova-gradient' ) . '</div><!-- /wp:buttons -->';
	$inner .= '</div><!-- /wp:column -->' . "\n";
	$inner .= '</div><!-- /wp:columns -->' . "\n";
	return gpi_pattern_section( $inner, 'nova-section-features' );
}

/**
 * Stats row.
 *
 * @return string
 */
function gpi_pattern_stats() {
	$stats = array(
		array( '12+', esc_html__( 'Years of experience', 'gp-industry' ) ),
		array( '300+', esc_html__( 'Corporate clients', 'gp-industry' ) ),
		array( '5,000+', esc_html__( 'Personnel deployed', 'gp-industry' ) ),
		array( '25+', esc_html__( 'Cities served', 'gp-industry' ) ),
	);
	$cols = '';
	foreach ( $stats as $stat ) {
		$cols .= '<!-- wp:column {"className":"nova-stat"} --><div class="wp-block-column nova-stat">';
		$cols .= '<!-- wp:paragraph {"align":"center","className":"nova-stat-number"} --><p class="has-text-align-center nova-stat-number">' . $stat[0] . '</p><!-- /wp:paragraph -->';
		$cols .= '<!-- wp:paragraph {"align":"center","className":"nova-stat-label"} --><p class="has-text-align-center nova-stat-label">' . $stat[1] . '</p><!-- /wp:paragraph -->';
		$cols .= '</div><!-- /wp:column -->' . "\n";
	}
	$inner = '<!-- wp:columns {"className":"nova-stats"} --><div class="wp-block-columns nova-stats">' . "\n" . $cols . '</div><!-- /wp:columns -->' . "\n";
	return gpi_pattern_section( $inner, 'nova-section-stats' );
}

/**
 * Certifications & clients.
 *
 * @return string
 */
function gpi_pattern_certifications() {
	$certs = array( 'ISO 9001:2015', 'PSARA Licensed', 'PF & ESIC Registered', 'MSME Registered', 'Contract Labour Act' );
	$badges = '';
	foreach ( $certs as $cert ) {
		$badges .= '<!-- wp:column {"className":"nova-cert"} --><div class="wp-block-column nova-cert">';
		$badges .= '<!-- wp:paragraph {"align":"center","className":"nova-cert-icon"} --><p class="has-text-align-center nova-cert-icon">🏅</p><!-- /wp:paragraph -->';
		$badges .= '<!-- wp:paragraph {"align":"center","className":"nova-cert-name"} --><p class="has-text-align-center nova-cert-name">' . esc_html( $cert ) . '</p><!-- /wp:paragraph -->';
		$badges .= '</div><!-- /wp:column -->' . "\n";
	}
	$clients = array( 'Tata Motors', 'Infosys', 'Apollo Hospitals', 'DLF', 'Marriott', 'L&T' );
	$logos = '';
	foreach ( $clients as $client ) {
		$logos .= '<!-- wp:column {"className":"nova-client"} --><div class="wp-block-column nova-client">';
		$logos .= '<!-- wp:paragraph {"align":"center","className":"nova-client-name"} --><p class="has-text-align-center nova-client-name">' . esc_html( $client ) . '</p><!-- /wp:paragraph -->';
		$logos .= '</div><!-- /wp:column -->' . "\n";
	}
	$inner  = gpi_pattern_heading( esc_html__( 'Certifications', 'gp-industry' ), esc_html__( 'Certified. Audited. Trusted.', 'gp-industry' ), esc_html__( 'Replace the badge text with your certificates, and the client names with logo images.', 'gp-industry' ) );
	$inner .= '<!-- wp:columns {"className":"nova-certs"} --><div class="wp-block-columns nova-certs">' . "\n" . $badges . '</div><!-- /wp:columns -->' . "\n";
	$inner .= '<!-- wp:paragraph {"align":"center","className":"nova-clients-label"} --><p class="has-text-align-center nova-clients-label">' . esc_html__( 'Trusted by leading organisations', 'gp-industry' ) . '</p><!-- /wp:paragraph -->' . "\n";
	$inner .= '<!-- wp:columns {"className":"nova-clients"} --><div class="wp-block-columns nova-clients">' . "\n" . $logos . '</div><!-- /wp:columns -->' . "\n";
	return gpi_pattern_section( $inner, 'nova-section-certifications' );
}

/**
 * Product specifications table.
 *
 * @return string
 */
function gpi_pattern_specs() {
	$rows = array(
		array( esc_html__( 'Engagement model', 'gp-industry' ), esc_html__( 'Monthly retainer or per-head / per-site contract', 'gp-industry' ) ),
		array( esc_html__( 'Deployment time', 'gp-industry' ), esc_html__( '7–10 working days from sign-off', 'gp-industry' ) ),
		array( esc_html__( 'Verification', 'gp-industry' ), esc_html__( 'Document, address and police verification for all personnel', 'gp-industry' ) ),
		array( esc_html__( 'Supervision', 'gp-industry' ), esc_html__( 'On-site supervisor per shift + central account manager', 'gp-industry' ) ),
		array( esc_html__( 'Compliance', 'gp-industry' ), esc_html__( 'PF, ESIC, PT, LWF and labour licences with monthly audit-ready reports', 'gp-industry' ) ),
		array( esc_html__( 'Reporting', 'gp-industry' ), esc_html__( 'Monthly MIS: attendance, incidents, compliance calendar', 'gp-industry' ) ),
		array( esc_html__( 'Replacement guarantee', 'gp-industry' ), esc_html__( 'Within 48 hours for any deployed personnel', 'gp-industry' ) ),
	);
	$body = '';
	foreach ( $rows as $r ) {
		$body .= '<tr><td><strong>' . $r[0] . '</strong></td><td>' . $r[1] . '</td></tr>';
	}
	$inner  = '<!-- wp:heading {"level":3} --><h3 class="wp-block-heading">' . esc_html__( 'Engagement details', 'gp-industry' ) . '</h3><!-- /wp:heading -->' . "\n";
	$inner .= '<!-- wp:table {"className":"is-style-stripes nova-specs"} --><figure class="wp-block-table is-style-stripes nova-specs"><table><tbody>' . $body . '</tbody></table></figure><!-- /wp:table -->' . "\n";
	$inner .= '<!-- wp:buttons --><div class="wp-block-buttons">' . gpi_pattern_button( esc_html__( 'Request a Proposal', 'gp-industry' ), 'is-style-nova-gradient' ) . gpi_pattern_button( esc_html__( 'Download brochure (PDF)', 'gp-industry' ), 'is-style-outline', '#' ) . '</div><!-- /wp:buttons -->' . "\n";
	return '<!-- wp:group {"className":"nova-section nova-section-specs","layout":{"type":"constrained","contentSize":"860px"}} --><div class="wp-block-group nova-section nova-section-specs">' . "\n" . $inner . '</div><!-- /wp:group -->';
}

/**
 * Projects gallery.
 *
 * @param string $img Image URL.
 * @return string
 */
function gpi_pattern_projects( $img ) {
	$projects = array(
		esc_html__( 'Facility management — IT park, Noida', 'gp-industry' ),
		esc_html__( '400-guard security rollout — auto plant', 'gp-industry' ),
		esc_html__( 'Payroll & compliance for 1,200 staff', 'gp-industry' ),
		esc_html__( 'Hospital housekeeping & hygiene program', 'gp-industry' ),
		esc_html__( 'Retail chain manpower — 25 cities', 'gp-industry' ),
		esc_html__( 'Campus facility services — university', 'gp-industry' ),
	);
	$items = '';
	foreach ( $projects as $p ) {
		$items .= '<!-- wp:image {"sizeSlug":"large","className":"nova-project"} --><figure class="wp-block-image size-large nova-project"><img src="' . $img . '" alt=""/><figcaption class="wp-element-caption">' . $p . '</figcaption></figure><!-- /wp:image -->' . "\n";
	}
	$inner  = gpi_pattern_heading( esc_html__( 'Case studies', 'gp-industry' ), esc_html__( 'Recent engagements and results', 'gp-industry' ), esc_html__( 'Click an image to replace it with your own photo.', 'gp-industry' ) );
	$inner .= '<!-- wp:gallery {"columns":3,"linkTo":"none","className":"nova-projects"} --><figure class="wp-block-gallery has-nested-images columns-3 is-cropped nova-projects">' . "\n" . $items . '</figure><!-- /wp:gallery -->' . "\n";
	return gpi_pattern_section( $inner, 'nova-section-projects' );
}

/**
 * Testimonials.
 *
 * @return string
 */
function gpi_pattern_testimonials() {
	$quotes = array(
		array( esc_html__( '“They took over our payroll and compliance completely — zero notices, zero headaches, and our HR team finally has time for people.”', 'gp-industry' ), 'Ramesh Iyer', esc_html__( 'Head of HR, AutoTech Ltd', 'gp-industry' ) ),
		array( esc_html__( '“Housekeeping and security at three of our plants are now handled by one accountable partner. The monthly reports make audits effortless.”', 'gp-industry' ), 'Sneha Kulkarni', esc_html__( 'Admin Manager, Vertex Energy', 'gp-industry' ) ),
		array( esc_html__( '“Rapid deployment and honest communication. Exactly what you want from a consultancy.”', 'gp-industry' ), 'Priya Nair', esc_html__( 'Operations Director, Orbit Hospitals', 'gp-industry' ) ),
	);
	$cols = '';
	foreach ( $quotes as $q ) {
		$cols .= '<!-- wp:column {"className":"nova-testimonial"} --><div class="wp-block-column nova-testimonial">';
		$cols .= '<!-- wp:paragraph {"className":"nova-testimonial-stars"} --><p class="nova-testimonial-stars">★★★★★</p><!-- /wp:paragraph -->';
		$cols .= '<!-- wp:paragraph {"className":"nova-testimonial-text"} --><p class="nova-testimonial-text">' . $q[0] . '</p><!-- /wp:paragraph -->';
		$cols .= '<!-- wp:paragraph {"className":"nova-testimonial-author"} --><p class="nova-testimonial-author"><strong>' . esc_html( $q[1] ) . '</strong><br>' . $q[2] . '</p><!-- /wp:paragraph -->';
		$cols .= '</div><!-- /wp:column -->' . "\n";
	}
	$inner  = gpi_pattern_heading( esc_html__( 'Testimonials', 'gp-industry' ), esc_html__( 'What our clients say', 'gp-industry' ) );
	$inner .= '<!-- wp:columns {"className":"nova-testimonials"} --><div class="wp-block-columns nova-testimonials">' . "\n" . $cols . '</div><!-- /wp:columns -->' . "\n";
	return gpi_pattern_section( $inner, 'nova-section-testimonials' );
}

/**
 * Team.
 *
 * @param string $avatar Avatar URL.
 * @return string
 */
function gpi_pattern_team( $avatar ) {
	$members = array(
		array( 'Gulshan Pandey', esc_html__( 'Founder & Managing Director', 'gp-industry' ) ),
		array( 'Anil Deshmukh', esc_html__( 'Head of Operations', 'gp-industry' ) ),
		array( 'Priya Nair', esc_html__( 'Compliance & Payroll Lead', 'gp-industry' ) ),
		array( 'Vikram Singh', esc_html__( 'Client Relations', 'gp-industry' ) ),
	);
	$cols = '';
	foreach ( $members as $m ) {
		$cols .= '<!-- wp:column {"className":"nova-team-card"} --><div class="wp-block-column nova-team-card">';
		$cols .= '<!-- wp:image {"sizeSlug":"medium","className":"nova-team-photo"} --><figure class="wp-block-image size-medium nova-team-photo"><img src="' . $avatar . '" alt=""/></figure><!-- /wp:image -->';
		$cols .= '<!-- wp:heading {"textAlign":"center","level":3,"className":"nova-team-name"} --><h3 class="wp-block-heading has-text-align-center nova-team-name">' . esc_html( $m[0] ) . '</h3><!-- /wp:heading -->';
		$cols .= '<!-- wp:paragraph {"align":"center","className":"nova-team-role"} --><p class="has-text-align-center nova-team-role">' . $m[1] . '</p><!-- /wp:paragraph -->';
		$cols .= '</div><!-- /wp:column -->' . "\n";
	}
	$inner  = gpi_pattern_heading( esc_html__( 'Leadership', 'gp-industry' ), esc_html__( 'The team behind the service', 'gp-industry' ) );
	$inner .= '<!-- wp:columns {"className":"nova-team"} --><div class="wp-block-columns nova-team">' . "\n" . $cols . '</div><!-- /wp:columns -->' . "\n";
	return gpi_pattern_section( $inner, 'nova-section-team' );
}

/**
 * FAQ.
 *
 * @return string
 */
function gpi_pattern_faq() {
	$faqs = array(
		array( esc_html__( 'How quickly can staff be deployed?', 'gp-industry' ), esc_html__( 'Most engagements go live within 7–10 working days, including sourcing, verification and induction.', 'gp-industry' ) ),
		array( esc_html__( 'Are your personnel background-verified?', 'gp-industry' ), esc_html__( 'Yes. Every candidate goes through document, address and police verification plus role-specific training before deployment.', 'gp-industry' ) ),
		array( esc_html__( 'Who handles PF, ESIC and payroll compliance?', 'gp-industry' ), esc_html__( 'We do. Statutory registrations, monthly filings and challans are managed end-to-end with audit-ready records shared every month.', 'gp-industry' ) ),
		array( esc_html__( 'Can you cover multiple cities or sites?', 'gp-industry' ), esc_html__( 'Yes. We deploy across 25+ cities with local supervisors and a central account manager for consistent service.', 'gp-industry' ) ),
	);
	$items = '';
	foreach ( $faqs as $faq ) {
		$items .= '<!-- wp:details {"className":"nova-faq-item"} --><details class="wp-block-details nova-faq-item"><summary>' . $faq[0] . '</summary><!-- wp:paragraph --><p>' . $faq[1] . '</p><!-- /wp:paragraph --></details><!-- /wp:details -->' . "\n";
	}
	$inner  = gpi_pattern_heading( esc_html__( 'FAQ', 'gp-industry' ), esc_html__( 'Frequently asked questions', 'gp-industry' ) );
	$inner .= '<!-- wp:group {"className":"nova-faq","layout":{"type":"constrained","contentSize":"820px"}} --><div class="wp-block-group nova-faq">' . "\n" . $items . '</div><!-- /wp:group -->' . "\n";
	return gpi_pattern_section( $inner, 'nova-section-faq' );
}

/**
 * CTA banner.
 *
 * @return string
 */
function gpi_pattern_cta() {
	$inner  = '<!-- wp:group {"className":"cta-banner","layout":{"type":"constrained","contentSize":"720px"}} --><div class="wp-block-group cta-banner">';
	$inner .= '<!-- wp:heading {"textAlign":"center","className":"cta-title"} --><h2 class="wp-block-heading has-text-align-center cta-title">' . esc_html__( 'Ready to streamline your workforce and facilities?', 'gp-industry' ) . '</h2><!-- /wp:heading -->';
	$inner .= '<!-- wp:paragraph {"align":"center","className":"cta-text"} --><p class="has-text-align-center cta-text">' . esc_html__( 'Share your requirement and our consultants will respond with a tailored proposal, timelines and transparent costing.', 'gp-industry' ) . '</p><!-- /wp:paragraph -->';
	$inner .= '<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} --><div class="wp-block-buttons">' . gpi_pattern_button( esc_html__( 'Request a Proposal', 'gp-industry' ), 'is-style-nova-light' ) . '</div><!-- /wp:buttons -->';
	$inner .= '</div><!-- /wp:group -->' . "\n";
	return gpi_pattern_section( $inner, 'nova-section-cta' );
}

/**
 * Request a quote: info + form placeholder.
 *
 * @return string
 */
function gpi_pattern_quote() {
	$inner  = gpi_pattern_heading( esc_html__( 'Request a proposal', 'gp-industry' ), esc_html__( 'Tell us about your requirement', 'gp-industry' ) );
	$inner .= '<!-- wp:columns {"className":"nova-contact"} --><div class="wp-block-columns nova-contact">' . "\n";
	$inner .= '<!-- wp:column {"width":"40%","className":"nova-contact-info"} --><div class="wp-block-column nova-contact-info" style="flex-basis:40%">';
	$inner .= '<!-- wp:heading {"level":3} --><h3 class="wp-block-heading">' . esc_html__( 'What to include', 'gp-industry' ) . '</h3><!-- /wp:heading -->';
	$inner .= '<!-- wp:list {"className":"nova-price-list"} --><ul class="wp-block-list nova-price-list">';
	foreach ( array( esc_html__( 'Number of sites and locations', 'gp-industry' ), esc_html__( 'Headcount, roles and shift pattern', 'gp-industry' ), esc_html__( 'Services required (staffing, housekeeping, security…)', 'gp-industry' ), esc_html__( 'Target start date', 'gp-industry' ) ) as $li ) {
		$inner .= '<!-- wp:list-item --><li>' . $li . '</li><!-- /wp:list-item -->';
	}
	$inner .= '</ul><!-- /wp:list -->';
	$inner .= '<!-- wp:paragraph --><p>📞 +91 98765 43210<br>✉️ info@example.com<br>🕒 ' . esc_html__( 'Mon – Sat, 9:00 – 18:00', 'gp-industry' ) . '</p><!-- /wp:paragraph -->';
	$inner .= '</div><!-- /wp:column -->' . "\n";
	$inner .= '<!-- wp:column {"width":"60%","className":"nova-contact-form"} --><div class="wp-block-column nova-contact-form" style="flex-basis:60%">';
	$inner .= '<!-- wp:heading {"level":3} --><h3 class="wp-block-heading">' . esc_html__( 'Proposal request form', 'gp-industry' ) . '</h3><!-- /wp:heading -->';
	$inner .= '<!-- wp:paragraph --><p>' . esc_html__( 'Replace this paragraph with your form plugin shortcode or block (Contact Form 7, WPForms, Fluent Forms…), e.g. [contact-form-7 id="123"].', 'gp-industry' ) . '</p><!-- /wp:paragraph -->';
	$inner .= '</div><!-- /wp:column -->' . "\n";
	$inner .= '</div><!-- /wp:columns -->' . "\n";
	return gpi_pattern_section( $inner, 'nova-section-quote' );
}
