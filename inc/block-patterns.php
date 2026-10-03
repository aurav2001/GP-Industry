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

	$img_hero        = esc_url( GPI_THEME_URI . '/assets/images/hero-industrial.jpg' );
	$img_machinery   = esc_url( GPI_THEME_URI . '/assets/images/heavy-machinery.jpg' );
	$img_precision   = esc_url( GPI_THEME_URI . '/assets/images/precision-components.jpg' );
	$img_automation  = esc_url( GPI_THEME_URI . '/assets/images/industrial-automation.jpg' );
	$img_fabrication = esc_url( GPI_THEME_URI . '/assets/images/custom-fabrication.jpg' );
	$img_maintenance = esc_url( GPI_THEME_URI . '/assets/images/plant-maintenance.jpg' );
	$img_cad         = esc_url( GPI_THEME_URI . '/assets/images/engineering-cad.jpg' );
	$img_sectors     = esc_url( GPI_THEME_URI . '/assets/images/industries-sectors.jpg' );
	$img_projects    = esc_url( GPI_THEME_URI . '/assets/images/case-studies-projects.jpg' );
	$img_facility    = esc_url( GPI_THEME_URI . '/assets/images/about-facility.jpg' );
	$avatar          = esc_url( GPI_THEME_URI . '/assets/images/avatar.svg' );

	$patterns = array(
		'hero'           => array( esc_html__( 'Hero: Industrial Headline', 'gp-industry' ), gpi_pattern_hero( $img_hero ) ),
		'products'       => array( esc_html__( 'Engineered Equipment Grid (3 cards)', 'gp-industry' ), gpi_pattern_products( $img_machinery, $img_precision, $img_automation ) ),
		'services'       => array( esc_html__( 'Industrial Capabilities Grid', 'gp-industry' ), gpi_pattern_services() ),
		'industries'     => array( esc_html__( 'Sectors We Serve', 'gp-industry' ), gpi_pattern_industries() ),
		'process'        => array( esc_html__( 'Manufacturing Workflow (4 stages)', 'gp-industry' ), gpi_pattern_process() ),
		'features'       => array( esc_html__( 'Infrastructure & Precision: facility image + metrics', 'gp-industry' ), gpi_pattern_features( $img_facility ) ),
		'stats'          => array( esc_html__( 'Manufacturing Metrics row', 'gp-industry' ), gpi_pattern_stats() ),
		'certifications' => array( esc_html__( 'Industrial Certifications & Enterprise Clients', 'gp-industry' ), gpi_pattern_certifications() ),
		'specs'          => array( esc_html__( 'Engineering Specifications table', 'gp-industry' ), gpi_pattern_specs() ),
		'projects'       => array( esc_html__( 'Heavy Engineering Case Studies Gallery', 'gp-industry' ), gpi_pattern_projects() ),
		'testimonials'   => array( esc_html__( 'Client Reviews & Endorsements', 'gp-industry' ), gpi_pattern_testimonials() ),
		'team'           => array( esc_html__( 'Engineering Leadership', 'gp-industry' ), gpi_pattern_team( $avatar ) ),
		'faq'            => array( esc_html__( 'Technical FAQ accordion', 'gp-industry' ), gpi_pattern_faq() ),
		'cta'            => array( esc_html__( 'Request Quotation (RFQ) banner', 'gp-industry' ), gpi_pattern_cta() ),
		'quote'          => array( esc_html__( 'RFQ & Engineering Consultation', 'gp-industry' ), gpi_pattern_quote() ),
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
function gpi_pattern_hero( $img = '' ) {
	if ( ! $img ) {
		$img = esc_url( GPI_THEME_URI . '/assets/images/hero-industrial.jpg' );
	}
	$inner  = '<!-- wp:group {"className":"nova-pattern-hero","layout":{"type":"constrained","contentSize":"860px"}} -->' . "\n";
	$inner .= '<div class="wp-block-group nova-pattern-hero">';
	$inner .= '<!-- wp:paragraph {"align":"center","className":"section-eyebrow"} --><p class="has-text-align-center section-eyebrow">' . esc_html__( 'Heavy Manufacturing & Precision Engineering · ISO 9001:2015', 'gp-industry' ) . '</p><!-- /wp:paragraph -->' . "\n";
	$inner .= '<!-- wp:heading {"textAlign":"center","level":1,"className":"hero-title"} --><h1 class="wp-block-heading has-text-align-center hero-title">' . esc_html__( 'Advanced industrial machinery &', 'gp-industry' ) . ' <span>' . esc_html__( 'precision components', 'gp-industry' ) . '</span></h1><!-- /wp:heading -->' . "\n";
	$inner .= '<!-- wp:paragraph {"align":"center","className":"hero-subtitle"} --><p class="has-text-align-center hero-subtitle">' . esc_html__( '5-Axis CNC milling, heavy structural steel fabrication, automated robotic workcells, and turnkey engineering solutions engineered for mission-critical reliability.', 'gp-industry' ) . '</p><!-- /wp:paragraph -->' . "\n";
	$inner .= '<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} --><div class="wp-block-buttons">' . gpi_pattern_button( esc_html__( 'Request Quotation (RFQ)', 'gp-industry' ), 'is-style-nova-gradient' ) . gpi_pattern_button( esc_html__( 'Download Capabilities Profile', 'gp-industry' ), 'is-style-outline', '#' ) . '</div><!-- /wp:buttons -->' . "\n";
	$inner .= '</div><!-- /wp:group -->' . "\n";
	$inner .= '<!-- wp:image {"sizeSlug":"large","className":"nova-pattern-hero-image"} --><figure class="wp-block-image size-large nova-pattern-hero-image"><img src="' . $img . '" alt="' . esc_attr__( 'Heavy Manufacturing Plant', 'gp-industry' ) . '"/></figure><!-- /wp:image -->' . "\n";
	return gpi_pattern_section( $inner, 'nova-section-hero' );
}

/**
 * Products grid with images.
 *
 * @param string $img1 Image URL 1.
 * @param string $img2 Image URL 2.
 * @param string $img3 Image URL 3.
 * @return string
 */
function gpi_pattern_products( $img1 = '', $img2 = '', $img3 = '' ) {
	$img1 = $img1 ? $img1 : esc_url( GPI_THEME_URI . '/assets/images/heavy-machinery.jpg' );
	$img2 = $img2 ? $img2 : esc_url( GPI_THEME_URI . '/assets/images/precision-components.jpg' );
	$img3 = $img3 ? $img3 : esc_url( GPI_THEME_URI . '/assets/images/industrial-automation.jpg' );

	$items = array(
		array( esc_html__( 'Heavy Industrial Machinery', 'gp-industry' ), esc_html__( 'Hydraulic presses, automated material handling conveyors, industrial crushers, and planetary gearboxes built for heavy duty.', 'gp-industry' ), $img1, '/products/heavy-industrial-machinery/' ),
		array( esc_html__( 'Precision CNC Components', 'gp-industry' ), esc_html__( 'High-tolerance turned shafts, titanium turbine impellers, and aerospace brackets milled down to ±0.005mm accuracy.', 'gp-industry' ), $img2, '/products/precision-cnc-components/' ),
		array( esc_html__( 'Industrial Automation Systems', 'gp-industry' ), esc_html__( 'Turnkey multi-axis robotic welding cells, SCADA control consoles, and smart Industry 4.0 monitoring hardware.', 'gp-industry' ), $img3, '/products/industrial-automation/' ),
	);
	$cols = '';
	foreach ( $items as $item ) {
		$cols .= '<!-- wp:column {"className":"nova-card nova-product-card"} --><div class="wp-block-column nova-card nova-product-card">';
		$cols .= '<!-- wp:image {"sizeSlug":"large","className":"nova-product-image"} --><figure class="wp-block-image size-large nova-product-image"><img src="' . $item[2] . '" alt="' . esc_attr( $item[0] ) . '"/></figure><!-- /wp:image -->';
		$cols .= '<!-- wp:heading {"level":3,"className":"nova-card-title"} --><h3 class="wp-block-heading nova-card-title">' . $item[0] . '</h3><!-- /wp:heading -->';
		$cols .= '<!-- wp:paragraph {"className":"nova-card-text"} --><p class="nova-card-text">' . $item[1] . '</p><!-- /wp:paragraph -->';
		$cols .= '<!-- wp:buttons --><div class="wp-block-buttons">' . gpi_pattern_button( esc_html__( 'View Technical Specs', 'gp-industry' ), 'is-style-outline', $item[3] ) . '</div><!-- /wp:buttons -->';
		$cols .= '</div><!-- /wp:column -->' . "\n";
	}
	$inner  = gpi_pattern_heading( esc_html__( 'Engineered Equipment', 'gp-industry' ), esc_html__( 'Heavy machinery & precision manufactured systems', 'gp-industry' ), esc_html__( 'High performance, zero-defect engineering manufactured in our 150,000 sq.ft facility.', 'gp-industry' ) );
	$inner .= '<!-- wp:columns {"className":"nova-cards"} --><div class="wp-block-columns nova-cards">' . "\n" . $cols . '</div><!-- /wp:columns -->' . "\n";
	return gpi_pattern_section( $inner, 'nova-section-products' );
}

/**
 * Services grid.
 *
 * @return string
 */
function gpi_pattern_services() {
	$cols  = gpi_pattern_card( '⚙️', esc_html__( 'Custom Metal Fabrication', 'gp-industry' ), esc_html__( 'Heavy plate rolling, fiber laser cutting up to 30mm, and ASME-coded robotic and SAW welding.', 'gp-industry' ), esc_html__( 'Explore Fabrication', 'gp-industry' ) );
	$cols .= gpi_pattern_card( '🔧', esc_html__( 'Plant Maintenance & Overhaul', 'gp-industry' ), esc_html__( 'Turbine and compressor overhauls, dynamic rotor balancing, and 24/7 planned shutdown management.', 'gp-industry' ), esc_html__( 'Explore Maintenance', 'gp-industry' ) );
	$cols .= gpi_pattern_card( '📐', esc_html__( 'Engineering & Prototyping', 'gp-industry' ), esc_html__( '3D CAD/CAM modeling, Finite Element Analysis (FEA) stress simulation, and rapid functional prototyping.', 'gp-industry' ), esc_html__( 'Explore Prototyping', 'gp-industry' ) );
	$inner  = gpi_pattern_heading( esc_html__( 'Our Capabilities', 'gp-industry' ), esc_html__( 'Full lifecycle manufacturing & field engineering', 'gp-industry' ) );
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
		array( '🚗', esc_html__( 'Automotive & Heavy Vehicles', 'gp-industry' ), esc_html__( 'Engine blocks, transmission housings, chassis stamping dies, and robotic welding fixtures.', 'gp-industry' ) ),
		array( '✈️', esc_html__( 'Aerospace & Defense', 'gp-industry' ), esc_html__( 'High-strength titanium brackets, avionics enclosures, and precision turbine impellers.', 'gp-industry' ) ),
		array( '⚡', esc_html__( 'Energy & Power Generation', 'gp-industry' ), esc_html__( 'Gas and steam turbine rotors, high-pressure piping, and heat-exchanger assemblies.', 'gp-industry' ) ),
		array( '🛢️', esc_html__( 'Oil, Gas & Petrochemical', 'gp-industry' ), esc_html__( 'API 6D valves, high-pressure pipeline manifolds, and ASME Section VIII pressure vessels.', 'gp-industry' ) ),
		array( '🏗️', esc_html__( 'Construction & Mining', 'gp-industry' ), esc_html__( 'High-wear manganese crusher plates, excavator boom fabrication, and heavy drive assemblies.', 'gp-industry' ) ),
		array( '🚢', esc_html__( 'Marine & Renewable Energy', 'gp-industry' ), esc_html__( 'Wind turbine main hub castings, solar tracker gearing, and forged marine propulsion shafts.', 'gp-industry' ) ),
	);
	$cols = '';
	foreach ( $rows as $i => $row ) {
		if ( 0 === $i % 3 ) {
			$cols .= '<!-- wp:columns {"className":"nova-cards nova-industries"} --><div class="wp-block-columns nova-cards nova-industries">' . "\n";
		}
		$cols .= gpi_pattern_card( $row[0], $row[1], $row[2], '', 'nova-card nova-industry-card' );
		if ( 2 === $i % 3 || $i === count( $rows ) - 1 ) {
			$cols .= '</div><!-- /wp:columns -->' . "\n";
		}
	}
	$inner = gpi_pattern_heading( esc_html__( 'Sectors We Serve', 'gp-industry' ), esc_html__( 'Mission-critical manufacturing for global industries', 'gp-industry' ), esc_html__( 'Proven track record of delivering tight-tolerance engineering components to the world’s most demanding sectors.', 'gp-industry' ) ) . $cols;
	return gpi_pattern_section( $inner, 'nova-section-industries' );
}

/**
 * Process steps.
 *
 * @return string
 */
function gpi_pattern_process() {
	$steps = array(
		array( esc_html__( 'Engineering & DFM Review', 'gp-industry' ), esc_html__( 'CAD/CAM analysis, material grade selection, FEA stress simulation, and tolerance feasibility.', 'gp-industry' ) ),
		array( esc_html__( 'Precision Prototyping', 'gp-industry' ), esc_html__( 'Rapid CNC machining or additive fabrication with full CMM inspection reports within 5–7 days.', 'gp-industry' ) ),
		array( esc_html__( 'Production & Fabrication', 'gp-industry' ), esc_html__( '5-Axis milling, automated robotic welding, heat treatment, and precision surface finishing.', 'gp-industry' ) ),
		array( esc_html__( 'Quality FAT & Dispatch', 'gp-industry' ), esc_html__( '100% CMM verification, ultrasonic NDT testing, EN 10204 3.1 mill certs, and secure export packing.', 'gp-industry' ) ),
	);
	$cols = '';
	foreach ( $steps as $i => $step ) {
		$cols .= '<!-- wp:column {"className":"nova-step"} --><div class="wp-block-column nova-step">';
		$cols .= '<!-- wp:paragraph {"className":"nova-step-number"} --><p class="nova-step-number">' . sprintf( '%02d', $i + 1 ) . '</p><!-- /wp:paragraph -->';
		$cols .= '<!-- wp:heading {"level":3,"className":"nova-step-title"} --><h3 class="wp-block-heading nova-step-title">' . $step[0] . '</h3><!-- /wp:heading -->';
		$cols .= '<!-- wp:paragraph {"className":"nova-step-text"} --><p class="nova-step-text">' . $step[1] . '</p><!-- /wp:paragraph -->';
		$cols .= '</div><!-- /wp:column -->' . "\n";
	}
	$inner  = gpi_pattern_heading( esc_html__( 'Manufacturing Workflow', 'gp-industry' ), esc_html__( 'From engineering blueprint to finished delivery in four stages', 'gp-industry' ) );
	$inner .= '<!-- wp:columns {"className":"nova-process"} --><div class="wp-block-columns nova-process">' . "\n" . $cols . '</div><!-- /wp:columns -->' . "\n";
	return gpi_pattern_section( $inner, 'nova-section-process' );
}

/**
 * Why choose us: image + checklist.
 *
 * @param string $img Image URL.
 * @return string
 */
function gpi_pattern_features( $img = '' ) {
	if ( ! $img ) {
		$img = esc_url( GPI_THEME_URI . '/assets/images/about-facility.jpg' );
	}
	$rows = array(
		array( esc_html__( '150,000 sq.ft Heavy Engineering Facility', 'gp-industry' ), esc_html__( 'Integrated multi-axis CNC machines, 25-tonne overhead cranes, and ASME-certified fabrication bays.', 'gp-industry' ) ),
		array( esc_html__( 'Sub-Micron Dimensional Precision (±0.005 mm)', 'gp-industry' ), esc_html__( 'Climate-controlled metrology laboratory with automated Zeiss CMM and optical laser scanners.', 'gp-industry' ) ),
		array( esc_html__( 'Full Traceability & Metallurgical Testing', 'gp-industry' ), esc_html__( '100% heat-number raw material tracking with EN 10204 3.1 certification and non-destructive testing.', 'gp-industry' ) ),
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
	$inner .= '<!-- wp:image {"sizeSlug":"large","className":"nova-split-image"} --><figure class="wp-block-image size-large nova-split-image"><img src="' . $img . '" alt="' . esc_attr__( 'Precision Manufacturing Facility', 'gp-industry' ) . '"/></figure><!-- /wp:image -->';
	$inner .= '</div><!-- /wp:column -->' . "\n";
	$inner .= '<!-- wp:column {"verticalAlignment":"center"} --><div class="wp-block-column is-vertically-aligned-center">';
	$inner .= '<!-- wp:paragraph {"className":"section-eyebrow"} --><p class="section-eyebrow">' . esc_html__( 'Why choose us', 'gp-industry' ) . '</p><!-- /wp:paragraph -->';
	$inner .= '<!-- wp:heading {"className":"section-title"} --><h2 class="wp-block-heading section-title">' . esc_html__( 'Built for extreme precision and heavy-duty reliability', 'gp-industry' ) . '</h2><!-- /wp:heading -->';
	$inner .= $list;
	$inner .= '<!-- wp:buttons --><div class="wp-block-buttons">' . gpi_pattern_button( esc_html__( 'Schedule Plant Tour', 'gp-industry' ), 'is-style-nova-gradient', '/contact/' ) . '</div><!-- /wp:buttons -->';
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
		array( '25+', esc_html__( 'Years in Heavy Industry', 'gp-industry' ) ),
		array( '150K+', esc_html__( 'Precision Parts Produced', 'gp-industry' ) ),
		array( '99.8%', esc_html__( 'Tolerance Conformance Rate', 'gp-industry' ) ),
		array( '40+', esc_html__( 'Countries Exported To', 'gp-industry' ) ),
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
	$certs = array( 'ISO 9001:2015', 'ASME Section VIII', 'ISO 14001:2015', 'CE Marking', 'EN 1090-2' );
	$badges = '';
	foreach ( $certs as $cert ) {
		$badges .= '<!-- wp:column {"className":"nova-cert"} --><div class="wp-block-column nova-cert">';
		$badges .= '<!-- wp:paragraph {"align":"center","className":"nova-cert-icon"} --><p class="has-text-align-center nova-cert-icon">🎖️</p><!-- /wp:paragraph -->';
		$badges .= '<!-- wp:paragraph {"align":"center","className":"nova-cert-name"} --><p class="has-text-align-center nova-cert-name">' . esc_html( $cert ) . '</p><!-- /wp:paragraph -->';
		$badges .= '</div><!-- /wp:column -->' . "\n";
	}
	$clients = array( 'Tata Steel', 'Siemens Energy', 'Larsen & Toubro', 'Bharat Forge', 'Caterpillar', 'Mahindra Heavy' );
	$logos = '';
	foreach ( $clients as $client ) {
		$logos .= '<!-- wp:column {"className":"nova-client"} --><div class="wp-block-column nova-client">';
		$logos .= '<!-- wp:paragraph {"align":"center","className":"nova-client-name"} --><p class="has-text-align-center nova-client-name">' . esc_html( $client ) . '</p><!-- /wp:paragraph -->';
		$logos .= '</div><!-- /wp:column -->' . "\n";
	}
	$inner  = gpi_pattern_heading( esc_html__( 'Certifications & Accreditations', 'gp-industry' ), esc_html__( 'Certified quality conforming to global engineering standards', 'gp-industry' ), esc_html__( 'Rigorous compliance and audited production lines trusted by international tier-1 manufacturers.', 'gp-industry' ) );
	$inner .= '<!-- wp:columns {"className":"nova-certs"} --><div class="wp-block-columns nova-certs">' . "\n" . $badges . '</div><!-- /wp:columns -->' . "\n";
	$inner .= '<!-- wp:paragraph {"align":"center","className":"nova-clients-label"} --><p class="has-text-align-center nova-clients-label">' . esc_html__( 'Trusted by global industrial enterprises', 'gp-industry' ) . '</p><!-- /wp:paragraph -->' . "\n";
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
		array( esc_html__( 'Machining Tolerances', 'gp-industry' ), esc_html__( '±0.005 mm (5 microns) on 5-Axis CNC machining centers', 'gp-industry' ) ),
		array( esc_html__( 'Material Compatibility', 'gp-industry' ), esc_html__( 'Titanium, Inconel 718, Stainless Steel (304/316/Duplex), Alloy Steel, Forged Aluminum', 'gp-industry' ) ),
		array( esc_html__( 'Welding Certifications', 'gp-industry' ), esc_html__( 'ASME Section IX, EN ISO 9606, Coded TIG, MIG & Submerged Arc Welding (SAW)', 'gp-industry' ) ),
		array( esc_html__( 'Non-Destructive Testing (NDT)', 'gp-industry' ), esc_html__( 'Ultrasonic (UT), Magnetic Particle (MPI), Dye Penetrant (DPI), Hydrostatic to 1,000 bar', 'gp-industry' ) ),
		array( esc_html__( 'Quality Documentation', 'gp-industry' ), esc_html__( 'EN 10204 3.1 Material Test Certificates (MTC), CMM dimensional reports, Heat treatment graphs', 'gp-industry' ) ),
		array( esc_html__( 'Maximum Machining Envelope', 'gp-industry' ), esc_html__( 'Up to 4,500 mm x 2,800 mm x 1,800 mm (X/Y/Z) with 25-tonne table capacity', 'gp-industry' ) ),
		array( esc_html__( 'Lead Times', 'gp-industry' ), esc_html__( 'Prototypes: 5–10 business days | Production runs: 3–4 weeks with buffer inventory stock', 'gp-industry' ) ),
	);
	$body = '';
	foreach ( $rows as $r ) {
		$body .= '<tr><td><strong>' . $r[0] . '</strong></td><td>' . $r[1] . '</td></tr>';
	}
	$inner  = '<!-- wp:heading {"level":3} --><h3 class="wp-block-heading">' . esc_html__( 'Technical Specifications & Quality Parameters', 'gp-industry' ) . '</h3><!-- /wp:heading -->' . "\n";
	$inner .= '<!-- wp:table {"className":"is-style-stripes nova-specs"} --><figure class="wp-block-table is-style-stripes nova-specs"><table><tbody>' . $body . '</tbody></table></figure><!-- /wp:table -->' . "\n";
	$inner .= '<!-- wp:buttons --><div class="wp-block-buttons">' . gpi_pattern_button( esc_html__( 'Request a Quotation (RFQ)', 'gp-industry' ), 'is-style-nova-gradient', '/contact/' ) . gpi_pattern_button( esc_html__( 'Download Technical Specs (PDF)', 'gp-industry' ), 'is-style-outline', '#' ) . '</div><!-- /wp:buttons -->' . "\n";
	return '<!-- wp:group {"className":"nova-section nova-section-specs","layout":{"type":"constrained","contentSize":"860px"}} --><div class="wp-block-group nova-section nova-section-specs">' . "\n" . $inner . '</div><!-- /wp:group -->';
}

/**
 * Projects gallery.
 *
 * @param array|null $imgs Image URLs array.
 * @return string
 */
function gpi_pattern_projects( $imgs = null ) {
	$projects = array(
		array( esc_html__( '1,200 MW Power Plant Turbine Overhaul & High-Pressure Piping Skid', 'gp-industry' ), esc_url( GPI_THEME_URI . '/assets/images/case-studies-projects.jpg' ) ),
		array( esc_html__( 'Aerospace 5-Axis Titanium Impeller Machining — Batch of 500 Units', 'gp-industry' ), esc_url( GPI_THEME_URI . '/assets/images/precision-components.jpg' ) ),
		array( esc_html__( 'Heavy Structural Steel Box Girders & SAW Welding for Metro Rail Viaduct', 'gp-industry' ), esc_url( GPI_THEME_URI . '/assets/images/custom-fabrication.jpg' ) ),
		array( esc_html__( 'Automated Robotic MIG Welding Workcell for Heavy Automotive Chassis Line', 'gp-industry' ), esc_url( GPI_THEME_URI . '/assets/images/industrial-automation.jpg' ) ),
		array( esc_html__( '1,500-Tonne Hydraulic Stamping Press Manufacturing & Turnkey Commissioning', 'gp-industry' ), esc_url( GPI_THEME_URI . '/assets/images/heavy-machinery.jpg' ) ),
		array( esc_html__( 'Offshore Oil & Gas Separation Vessel with ASME ' . 'U' . ' Code Stamp', 'gp-industry' ), esc_url( GPI_THEME_URI . '/assets/images/plant-maintenance.jpg' ) ),
	);

	$items = '';
	foreach ( $projects as $p ) {
		$items .= '<!-- wp:image {"sizeSlug":"large","className":"nova-project"} --><figure class="wp-block-image size-large nova-project"><img src="' . $p[1] . '" alt="' . esc_attr( $p[0] ) . '"/><figcaption class="wp-element-caption">' . $p[0] . '</figcaption></figure><!-- /wp:image -->' . "\n";
	}
	$inner  = gpi_pattern_heading( esc_html__( 'Case Studies & Deliveries', 'gp-industry' ), esc_html__( 'Proven execution across heavy industrial projects', 'gp-industry' ), esc_html__( 'Browse our recent turnkey manufacturing, CNC machining, and structural fabrication achievements.', 'gp-industry' ) );
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
		array( esc_html__( '“The dimensional accuracy of the machined turbine housings exceeded our tightest tolerances. Zero defects across a 2,000-unit batch.”', 'gp-industry' ), 'Rajesh Sharma', esc_html__( 'VP of Operations, Bharat Heavy Power', 'gp-industry' ) ),
		array( esc_html__( '“Their custom steel fabrication for our stamping line was delivered two weeks ahead of schedule. Exceptional weld quality and full NDT records.”', 'gp-industry' ), 'Marcus Vance', esc_html__( 'Director of Engineering, Precision AutoCorp', 'gp-industry' ) ),
		array( esc_html__( '“Reliable partner for complex alloy machining. Their metallurgical traceability and CMM documentation make audit compliance effortless.”', 'gp-industry' ), 'David Miller', esc_html__( 'Supply Chain Head, AeroDynamics Global', 'gp-industry' ) ),
	);
	$cols = '';
	foreach ( $quotes as $q ) {
		$cols .= '<!-- wp:column {"className":"nova-testimonial"} --><div class="wp-block-column nova-testimonial">';
		$cols .= '<!-- wp:paragraph {"className":"nova-testimonial-stars"} --><p class="nova-testimonial-stars">★★★★★</p><!-- /wp:paragraph -->';
		$cols .= '<!-- wp:paragraph {"className":"nova-testimonial-text"} --><p class="nova-testimonial-text">' . $q[0] . '</p><!-- /wp:paragraph -->';
		$cols .= '<!-- wp:paragraph {"className":"nova-testimonial-author"} --><p class="nova-testimonial-author"><strong>' . esc_html( $q[1] ) . '</strong><br>' . $q[2] . '</p><!-- /wp:paragraph -->';
		$cols .= '</div><!-- /wp:column -->' . "\n";
	}
	$inner  = gpi_pattern_heading( esc_html__( 'Client Endorsements', 'gp-industry' ), esc_html__( 'Trusted by engineering directors and plant managers worldwide', 'gp-industry' ) );
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
