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
		'hero'           => array( esc_html__( 'Hero: industrial headline', 'gp-industry' ), gpi_pattern_hero( $img ) ),
		'products'       => array( esc_html__( 'Products Grid (3 cards)', 'gp-industry' ), gpi_pattern_products( $img ) ),
		'services'       => array( esc_html__( 'Services Grid (3 cards)', 'gp-industry' ), gpi_pattern_services() ),
		'industries'     => array( esc_html__( 'Industries We Serve', 'gp-industry' ), gpi_pattern_industries() ),
		'process'        => array( esc_html__( 'Our Process (4 steps)', 'gp-industry' ), gpi_pattern_process() ),
		'features'       => array( esc_html__( 'Why Choose Us: image + checklist', 'gp-industry' ), gpi_pattern_features( $img ) ),
		'stats'          => array( esc_html__( 'Stats row', 'gp-industry' ), gpi_pattern_stats() ),
		'certifications' => array( esc_html__( 'Certifications & Clients', 'gp-industry' ), gpi_pattern_certifications() ),
		'specs'          => array( esc_html__( 'Product Specifications table', 'gp-industry' ), gpi_pattern_specs() ),
		'projects'       => array( esc_html__( 'Projects Gallery', 'gp-industry' ), gpi_pattern_projects( $img ) ),
		'testimonials'   => array( esc_html__( 'Client Testimonials', 'gp-industry' ), gpi_pattern_testimonials() ),
		'team'           => array( esc_html__( 'Leadership Team', 'gp-industry' ), gpi_pattern_team( $avatar ) ),
		'faq'            => array( esc_html__( 'FAQ accordion', 'gp-industry' ), gpi_pattern_faq() ),
		'cta'            => array( esc_html__( 'Request a Quote banner', 'gp-industry' ), gpi_pattern_cta() ),
		'quote'          => array( esc_html__( 'Request a Quote: info + form', 'gp-industry' ), gpi_pattern_quote() ),
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
	$inner .= '<!-- wp:paragraph {"align":"center","className":"section-eyebrow"} --><p class="has-text-align-center section-eyebrow">' . esc_html__( 'Since 1998 · ISO 9001 Certified', 'gp-industry' ) . '</p><!-- /wp:paragraph -->' . "\n";
	$inner .= '<!-- wp:heading {"textAlign":"center","level":1,"className":"hero-title"} --><h1 class="wp-block-heading has-text-align-center hero-title">' . esc_html__( 'Precision manufacturing for', 'gp-industry' ) . ' <span>' . esc_html__( 'demanding industries', 'gp-industry' ) . '</span></h1><!-- /wp:heading -->' . "\n";
	$inner .= '<!-- wp:paragraph {"align":"center","className":"hero-subtitle"} --><p class="has-text-align-center hero-subtitle">' . esc_html__( 'Components, machinery and industrial solutions engineered to specification and delivered on schedule. Replace this text with your own pitch.', 'gp-industry' ) . '</p><!-- /wp:paragraph -->' . "\n";
	$inner .= '<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} --><div class="wp-block-buttons">' . gpi_pattern_button( esc_html__( 'Request a Quote', 'gp-industry' ), 'is-style-nova-gradient' ) . gpi_pattern_button( esc_html__( 'Download Brochure', 'gp-industry' ), 'is-style-outline', '#' ) . '</div><!-- /wp:buttons -->' . "\n";
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
		array( esc_html__( 'Precision Machined Parts', 'gp-industry' ), esc_html__( 'CNC turned and milled components in steel, aluminium and brass to ±0.01 mm.', 'gp-industry' ) ),
		array( esc_html__( 'Industrial Fasteners', 'gp-industry' ), esc_html__( 'Bolts, nuts, studs and custom fasteners in grades 8.8, 10.9, 12.9 and stainless.', 'gp-industry' ) ),
		array( esc_html__( 'Fabricated Assemblies', 'gp-industry' ), esc_html__( 'Welded structures, enclosures and sub-assemblies built to your drawings.', 'gp-industry' ) ),
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
	$inner  = gpi_pattern_heading( esc_html__( 'Our products', 'gp-industry' ), esc_html__( 'Engineered products, built to specification', 'gp-industry' ), esc_html__( 'Duplicate a column to add more product categories.', 'gp-industry' ) );
	$inner .= '<!-- wp:columns {"className":"nova-cards"} --><div class="wp-block-columns nova-cards">' . "\n" . $cols . '</div><!-- /wp:columns -->' . "\n";
	return gpi_pattern_section( $inner, 'nova-section-products' );
}

/**
 * Services grid.
 *
 * @return string
 */
function gpi_pattern_services() {
	$cols  = gpi_pattern_card( '⚙️', esc_html__( 'Contract Manufacturing', 'gp-industry' ), esc_html__( 'End-to-end production from prototyping to high-volume runs.', 'gp-industry' ), esc_html__( 'Learn more', 'gp-industry' ) );
	$cols .= gpi_pattern_card( '🔧', esc_html__( 'Maintenance & Repair', 'gp-industry' ), esc_html__( 'Preventive maintenance, breakdown support and spare parts supply.', 'gp-industry' ), esc_html__( 'Learn more', 'gp-industry' ) );
	$cols .= gpi_pattern_card( '📐', esc_html__( 'Design & Engineering', 'gp-industry' ), esc_html__( 'CAD/CAM design, reverse engineering and DFM consultation.', 'gp-industry' ), esc_html__( 'Learn more', 'gp-industry' ) );
	$inner  = gpi_pattern_heading( esc_html__( 'Our services', 'gp-industry' ), esc_html__( 'Industrial services you can rely on', 'gp-industry' ) );
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
		array( '🚗', esc_html__( 'Automotive', 'gp-industry' ), esc_html__( 'OEM & tier-1 component supply.', 'gp-industry' ) ),
		array( '🏗️', esc_html__( 'Construction', 'gp-industry' ), esc_html__( 'Structural steel and fittings.', 'gp-industry' ) ),
		array( '⚡', esc_html__( 'Energy & Power', 'gp-industry' ), esc_html__( 'Turbine, solar and grid hardware.', 'gp-industry' ) ),
		array( '🛢️', esc_html__( 'Oil & Gas', 'gp-industry' ), esc_html__( 'Valves, flanges and pressure parts.', 'gp-industry' ) ),
		array( '✈️', esc_html__( 'Aerospace', 'gp-industry' ), esc_html__( 'High-tolerance precision parts.', 'gp-industry' ) ),
		array( '🏥', esc_html__( 'Medical', 'gp-industry' ), esc_html__( 'Clean-room grade components.', 'gp-industry' ) ),
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
	$inner = gpi_pattern_heading( esc_html__( 'Industries', 'gp-industry' ), esc_html__( 'Industries we serve', 'gp-industry' ), esc_html__( 'Proven supply experience across regulated and high-volume sectors.', 'gp-industry' ) ) . $cols;
	return gpi_pattern_section( $inner, 'nova-section-industries' );
}

/**
 * Process steps.
 *
 * @return string
 */
function gpi_pattern_process() {
	$steps = array(
		array( esc_html__( 'Enquiry & Drawings', 'gp-industry' ), esc_html__( 'Share specifications, drawings or samples. We review feasibility within 24 hours.', 'gp-industry' ) ),
		array( esc_html__( 'Quotation', 'gp-industry' ), esc_html__( 'Transparent pricing with lead times, tolerances and material certificates.', 'gp-industry' ) ),
		array( esc_html__( 'Production & QC', 'gp-industry' ), esc_html__( 'Manufacturing with in-process inspection and final quality reports.', 'gp-industry' ) ),
		array( esc_html__( 'Delivery', 'gp-industry' ), esc_html__( 'Secure packaging and on-time dispatch — domestic and export.', 'gp-industry' ) ),
	);
	$cols = '';
	foreach ( $steps as $i => $step ) {
		$cols .= '<!-- wp:column {"className":"nova-step"} --><div class="wp-block-column nova-step">';
		$cols .= '<!-- wp:paragraph {"className":"nova-step-number"} --><p class="nova-step-number">' . sprintf( '%02d', $i + 1 ) . '</p><!-- /wp:paragraph -->';
		$cols .= '<!-- wp:heading {"level":3,"className":"nova-step-title"} --><h3 class="wp-block-heading nova-step-title">' . $step[0] . '</h3><!-- /wp:heading -->';
		$cols .= '<!-- wp:paragraph {"className":"nova-step-text"} --><p class="nova-step-text">' . $step[1] . '</p><!-- /wp:paragraph -->';
		$cols .= '</div><!-- /wp:column -->' . "\n";
	}
	$inner  = gpi_pattern_heading( esc_html__( 'How we work', 'gp-industry' ), esc_html__( 'From enquiry to delivery in four steps', 'gp-industry' ) );
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
		array( esc_html__( 'Certified quality systems', 'gp-industry' ), esc_html__( 'ISO 9001, ISO 14001 and IATF-aligned processes with full traceability.', 'gp-industry' ) ),
		array( esc_html__( 'In-house testing lab', 'gp-industry' ), esc_html__( 'CMM, hardness, tensile and NDT testing on every batch.', 'gp-industry' ) ),
		array( esc_html__( 'Capacity to scale', 'gp-industry' ), esc_html__( 'Multiple production lines and 3-shift operation for large orders.', 'gp-industry' ) ),
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
	$inner .= '<!-- wp:heading {"className":"section-title"} --><h2 class="wp-block-heading section-title">' . esc_html__( 'A manufacturing partner you can depend on', 'gp-industry' ) . '</h2><!-- /wp:heading -->';
	$inner .= $list;
	$inner .= '<!-- wp:buttons --><div class="wp-block-buttons">' . gpi_pattern_button( esc_html__( 'Talk to an engineer', 'gp-industry' ), 'is-style-nova-gradient' ) . '</div><!-- /wp:buttons -->';
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
		array( '25+', esc_html__( 'Years in business', 'gp-industry' ) ),
		array( '500+', esc_html__( 'Clients served', 'gp-industry' ) ),
		array( '10K+', esc_html__( 'Projects delivered', 'gp-industry' ) ),
		array( '40+', esc_html__( 'Countries supplied', 'gp-industry' ) ),
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
	$certs = array( 'ISO 9001:2015', 'ISO 14001', 'ISO 45001', 'CE Certified', 'IATF 16949' );
	$badges = '';
	foreach ( $certs as $cert ) {
		$badges .= '<!-- wp:column {"className":"nova-cert"} --><div class="wp-block-column nova-cert">';
		$badges .= '<!-- wp:paragraph {"align":"center","className":"nova-cert-icon"} --><p class="has-text-align-center nova-cert-icon">🏅</p><!-- /wp:paragraph -->';
		$badges .= '<!-- wp:paragraph {"align":"center","className":"nova-cert-name"} --><p class="has-text-align-center nova-cert-name">' . esc_html( $cert ) . '</p><!-- /wp:paragraph -->';
		$badges .= '</div><!-- /wp:column -->' . "\n";
	}
	$clients = array( 'Tata Steel', 'L&T', 'Siemens', 'BHEL', 'Bosch', 'ABB' );
	$logos = '';
	foreach ( $clients as $client ) {
		$logos .= '<!-- wp:column {"className":"nova-client"} --><div class="wp-block-column nova-client">';
		$logos .= '<!-- wp:paragraph {"align":"center","className":"nova-client-name"} --><p class="has-text-align-center nova-client-name">' . esc_html( $client ) . '</p><!-- /wp:paragraph -->';
		$logos .= '</div><!-- /wp:column -->' . "\n";
	}
	$inner  = gpi_pattern_heading( esc_html__( 'Certifications', 'gp-industry' ), esc_html__( 'Certified. Audited. Trusted.', 'gp-industry' ), esc_html__( 'Replace the badge text with your certificates, and the client names with logo images.', 'gp-industry' ) );
	$inner .= '<!-- wp:columns {"className":"nova-certs"} --><div class="wp-block-columns nova-certs">' . "\n" . $badges . '</div><!-- /wp:columns -->' . "\n";
	$inner .= '<!-- wp:paragraph {"align":"center","className":"nova-clients-label"} --><p class="has-text-align-center nova-clients-label">' . esc_html__( 'Trusted by industry leaders', 'gp-industry' ) . '</p><!-- /wp:paragraph -->' . "\n";
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
		array( esc_html__( 'Material', 'gp-industry' ), 'EN8 / EN19 / SS304 / Aluminium 6061' ),
		array( esc_html__( 'Size range', 'gp-industry' ), 'Ø5 mm – Ø400 mm, length up to 1500 mm' ),
		array( esc_html__( 'Tolerance', 'gp-industry' ), '±0.01 mm (precision), ±0.05 mm (standard)' ),
		array( esc_html__( 'Surface finish', 'gp-industry' ), 'Ra 0.8 – 3.2 µm; zinc, nickel, powder coating' ),
		array( esc_html__( 'Certification', 'gp-industry' ), esc_html__( 'Material test certificate (MTC) with every batch', 'gp-industry' ) ),
		array( esc_html__( 'Lead time', 'gp-industry' ), esc_html__( '7–21 days depending on quantity', 'gp-industry' ) ),
		array( esc_html__( 'MOQ', 'gp-industry' ), esc_html__( '100 pcs (custom parts), no MOQ on standard items', 'gp-industry' ) ),
	);
	$body = '';
	foreach ( $rows as $r ) {
		$body .= '<tr><td><strong>' . $r[0] . '</strong></td><td>' . $r[1] . '</td></tr>';
	}
	$inner  = '<!-- wp:heading {"level":3} --><h3 class="wp-block-heading">' . esc_html__( 'Technical specifications', 'gp-industry' ) . '</h3><!-- /wp:heading -->' . "\n";
	$inner .= '<!-- wp:table {"className":"is-style-stripes nova-specs"} --><figure class="wp-block-table is-style-stripes nova-specs"><table><tbody>' . $body . '</tbody></table></figure><!-- /wp:table -->' . "\n";
	$inner .= '<!-- wp:buttons --><div class="wp-block-buttons">' . gpi_pattern_button( esc_html__( 'Request a Quote', 'gp-industry' ), 'is-style-nova-gradient' ) . gpi_pattern_button( esc_html__( 'Download datasheet (PDF)', 'gp-industry' ), 'is-style-outline', '#' ) . '</div><!-- /wp:buttons -->' . "\n";
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
		esc_html__( 'Conveyor system — Pune plant', 'gp-industry' ),
		esc_html__( 'Pressure vessel fabrication', 'gp-industry' ),
		esc_html__( 'Precision gear set, 2,000 pcs', 'gp-industry' ),
		esc_html__( 'Structural steel for warehouse', 'gp-industry' ),
		esc_html__( 'Stainless piping installation', 'gp-industry' ),
		esc_html__( 'Custom jigs & fixtures', 'gp-industry' ),
	);
	$items = '';
	foreach ( $projects as $p ) {
		$items .= '<!-- wp:image {"sizeSlug":"large","className":"nova-project"} --><figure class="wp-block-image size-large nova-project"><img src="' . $img . '" alt=""/><figcaption class="wp-element-caption">' . $p . '</figcaption></figure><!-- /wp:image -->' . "\n";
	}
	$inner  = gpi_pattern_heading( esc_html__( 'Projects', 'gp-industry' ), esc_html__( 'Recent work from our plant floor', 'gp-industry' ), esc_html__( 'Click an image to replace it with your own project photo.', 'gp-industry' ) );
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
		array( esc_html__( '“Consistent quality across 40,000 parts with zero rejections. Their QC documentation made our audit effortless.”', 'gp-industry' ), 'Ramesh Iyer', esc_html__( 'Procurement Head, AutoTech Ltd', 'gp-industry' ) ),
		array( esc_html__( '“They took our concept drawings and delivered a production-ready assembly in three weeks.”', 'gp-industry' ), 'Sneha Kulkarni', esc_html__( 'Plant Manager, Vertex Energy', 'gp-industry' ) ),
		array( esc_html__( '“Reliable lead times and honest communication. Exactly what you want from a supplier.”', 'gp-industry' ), 'David Müller', esc_html__( 'Sourcing Director, Nordwerk GmbH', 'gp-industry' ) ),
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
		array( 'Gulshan Pandey', esc_html__( 'Managing Director', 'gp-industry' ) ),
		array( 'Anil Deshmukh', esc_html__( 'Head of Production', 'gp-industry' ) ),
		array( 'Priya Nair', esc_html__( 'Quality Assurance Lead', 'gp-industry' ) ),
		array( 'Vikram Singh', esc_html__( 'Sales & Exports', 'gp-industry' ) ),
	);
	$cols = '';
	foreach ( $members as $m ) {
		$cols .= '<!-- wp:column {"className":"nova-team-card"} --><div class="wp-block-column nova-team-card">';
		$cols .= '<!-- wp:image {"sizeSlug":"medium","className":"nova-team-photo"} --><figure class="wp-block-image size-medium nova-team-photo"><img src="' . $avatar . '" alt=""/></figure><!-- /wp:image -->';
		$cols .= '<!-- wp:heading {"textAlign":"center","level":3,"className":"nova-team-name"} --><h3 class="wp-block-heading has-text-align-center nova-team-name">' . esc_html( $m[0] ) . '</h3><!-- /wp:heading -->';
		$cols .= '<!-- wp:paragraph {"align":"center","className":"nova-team-role"} --><p class="has-text-align-center nova-team-role">' . $m[1] . '</p><!-- /wp:paragraph -->';
		$cols .= '</div><!-- /wp:column -->' . "\n";
	}
	$inner  = gpi_pattern_heading( esc_html__( 'Leadership', 'gp-industry' ), esc_html__( 'The team behind the machines', 'gp-industry' ) );
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
		array( esc_html__( 'What is your minimum order quantity?', 'gp-industry' ), esc_html__( 'Standard items have no MOQ. Custom-machined parts typically start at 100 pieces, but we are happy to quote prototypes and small batches.', 'gp-industry' ) ),
		array( esc_html__( 'Which file formats do you accept for quotes?', 'gp-industry' ), esc_html__( 'STEP, IGES, DWG, DXF and PDF drawings. Physical samples are also welcome for reverse engineering.', 'gp-industry' ) ),
		array( esc_html__( 'Do you provide material certificates?', 'gp-industry' ), esc_html__( 'Yes. Every batch ships with a material test certificate and an inspection report on request.', 'gp-industry' ) ),
		array( esc_html__( 'Do you export?', 'gp-industry' ), esc_html__( 'We supply to 40+ countries with export packing, documentation and freight coordination.', 'gp-industry' ) ),
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
	$inner .= '<!-- wp:heading {"textAlign":"center","className":"cta-title"} --><h2 class="wp-block-heading has-text-align-center cta-title">' . esc_html__( 'Have drawings ready? Get a quote in 24 hours.', 'gp-industry' ) . '</h2><!-- /wp:heading -->';
	$inner .= '<!-- wp:paragraph {"align":"center","className":"cta-text"} --><p class="has-text-align-center cta-text">' . esc_html__( 'Send us your specifications and our engineering team will respond with pricing, lead time and material options.', 'gp-industry' ) . '</p><!-- /wp:paragraph -->';
	$inner .= '<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} --><div class="wp-block-buttons">' . gpi_pattern_button( esc_html__( 'Request a Quote', 'gp-industry' ), 'is-style-nova-light' ) . '</div><!-- /wp:buttons -->';
	$inner .= '</div><!-- /wp:group -->' . "\n";
	return gpi_pattern_section( $inner, 'nova-section-cta' );
}

/**
 * Request a quote: info + form placeholder.
 *
 * @return string
 */
function gpi_pattern_quote() {
	$inner  = gpi_pattern_heading( esc_html__( 'Request a quote', 'gp-industry' ), esc_html__( 'Tell us what you need to build', 'gp-industry' ) );
	$inner .= '<!-- wp:columns {"className":"nova-contact"} --><div class="wp-block-columns nova-contact">' . "\n";
	$inner .= '<!-- wp:column {"width":"40%","className":"nova-contact-info"} --><div class="wp-block-column nova-contact-info" style="flex-basis:40%">';
	$inner .= '<!-- wp:heading {"level":3} --><h3 class="wp-block-heading">' . esc_html__( 'What to include', 'gp-industry' ) . '</h3><!-- /wp:heading -->';
	$inner .= '<!-- wp:list {"className":"nova-price-list"} --><ul class="wp-block-list nova-price-list">';
	foreach ( array( esc_html__( 'Drawings or 3D files (STEP / DWG / PDF)', 'gp-industry' ), esc_html__( 'Material and surface finish', 'gp-industry' ), esc_html__( 'Quantity and target delivery date', 'gp-industry' ), esc_html__( 'Certifications required', 'gp-industry' ) ) as $li ) {
		$inner .= '<!-- wp:list-item --><li>' . $li . '</li><!-- /wp:list-item -->';
	}
	$inner .= '</ul><!-- /wp:list -->';
	$inner .= '<!-- wp:paragraph --><p>📞 +91 98765 43210<br>✉️ sales@example.com<br>🕒 ' . esc_html__( 'Mon – Sat, 9:00 – 18:00', 'gp-industry' ) . '</p><!-- /wp:paragraph -->';
	$inner .= '</div><!-- /wp:column -->' . "\n";
	$inner .= '<!-- wp:column {"width":"60%","className":"nova-contact-form"} --><div class="wp-block-column nova-contact-form" style="flex-basis:60%">';
	$inner .= '<!-- wp:heading {"level":3} --><h3 class="wp-block-heading">' . esc_html__( 'Quote request form', 'gp-industry' ) . '</h3><!-- /wp:heading -->';
	$inner .= '<!-- wp:paragraph --><p>' . esc_html__( 'Replace this paragraph with your form plugin shortcode or block (Contact Form 7, WPForms, Fluent Forms…), e.g. [contact-form-7 id="123"].', 'gp-industry' ) . '</p><!-- /wp:paragraph -->';
	$inner .= '</div><!-- /wp:column -->' . "\n";
	$inner .= '</div><!-- /wp:columns -->' . "\n";
	return gpi_pattern_section( $inner, 'nova-section-quote' );
}
