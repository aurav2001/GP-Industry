<?php
/**
 * Customizer: extra homepage sections (About, Products, Industries, Process,
 * Testimonials, Clients, FAQ). Every section is editable from
 * Customize → GP-Industry Options → Homepage: …
 *
 * List-type fields use one item per line, columns separated by "|".
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Defaults for the homepage sections (merged into gpi_option_defaults()).
 *
 * @return array
 */
function gpi_home_defaults( $company = '' ) {
	$company = $company ? $company : get_bloginfo( 'name' );

	return array(
		// About / intro.
		/* translators: %s: company name */
		'home_about_eyebrow' => sprintf( esc_html__( 'About %s', 'gp-industry' ), $company ),
		'home_about_title'   => esc_html__( 'Advanced manufacturing infrastructure and precision engineering excellence', 'gp-industry' ),
		/* translators: %s: company name */
		'home_about_text'    => sprintf( esc_html__( '%s is an industry-leading manufacturing and engineering corporation delivering high-precision components, heavy industrial machinery, and turnkey structural fabrication. With over 25 years of engineering heritage and state-of-the-art facilities, we provide reliable, high-tolerance manufacturing solutions for global industrial leaders.', 'gp-industry' ), $company ),
		'home_about_list'    => "150,000 sq.ft heavy engineering & CNC machining facility\n5-Axis precision CNC milling with tolerances down to ±0.005mm\nISO 9001:2015, ISO 14001 & ASME Section VIII certified\nIn-house CMM coordinate measuring, NDT & metallurgical lab",
		'home_about_btn'     => esc_html__( 'Explore Our Capabilities', 'gp-industry' ),
		'home_about_url'     => '/about-us/',
		'home_about_image'   => GPI_THEME_URI . '/assets/images/about-facility.jpg',
		'home_about_badge'   => esc_html__( '25+ Years', 'gp-industry' ),
		'home_about_badge_2' => esc_html__( 'of manufacturing excellence', 'gp-industry' ),
		// Products / solutions.
		'home_products_eyebrow' => esc_html__( 'Engineered Equipment', 'gp-industry' ),
		'home_products_title'   => esc_html__( 'High-performance machinery & precision components', 'gp-industry' ),
		'home_products_page'    => 0,
		'home_products_count'   => 6,
		// Industries.
		'home_industries_eyebrow' => esc_html__( 'Sectors We Serve', 'gp-industry' ),
		'home_industries_title'   => esc_html__( 'Mission-critical manufacturing for global industries', 'gp-industry' ),
		'home_industries_text'    => esc_html__( 'Delivering precision components and structural systems across demanding industrial sectors.', 'gp-industry' ),
		'home_industries_items'   => "factory | Automotive & Heavy Vehicles | Engine blocks, transmission housings, chassis assemblies & stamping dies\nglobe | Aerospace & Defense | High-strength titanium brackets, avionics enclosures & turbine components\nbolt | Energy & Power Generation | Gas turbine rotors, high-pressure flanges & boiler heat-exchanger assemblies\nlayers | Oil, Gas & Petrochemical | API 6D valves, high-pressure pipeline skids & refinery pressure vessels\ntruck | Heavy Construction & Mining | Crusher wear plates, excavator boom fabrication & material conveyor drives\nleaf | Renewable Energy & Marine | Wind turbine hub castings, solar tracker gearing & marine propulsion shafts",
		// Process.
		'home_process_eyebrow' => esc_html__( 'Manufacturing Workflow', 'gp-industry' ),
		'home_process_title'   => esc_html__( 'From engineering blueprint to finished delivery in four stages', 'gp-industry' ),
		'home_process_items'   => "Engineering & DFM Review | CAD/CAM model analysis, material selection, FEA stress simulation and cost optimization.\nPrecision Prototyping | Rapid CNC machining or 3D metal printing prototype with full dimensional inspection.\nProduction & Fabrication | Multi-axis CNC milling, robotic welding, heat treatment, and precision surface finishing.\nQuality Testing & Delivery | CMM inspection, ultrasonic/hydrostatic testing, mill test certificates, and secure export packing.",
		// Testimonials.
		'home_testimonials_eyebrow' => esc_html__( 'Client Reviews', 'gp-industry' ),
		'home_testimonials_title'   => esc_html__( 'Trusted by engineering directors and plant managers', 'gp-industry' ),
		'home_testimonials_items'   => "The dimensional accuracy of the machined turbine housings exceeded our tightest tolerances. Zero defects across a 2,000-unit batch. | Rajesh Sharma | VP of Operations, Bharat Heavy Power\nTheir custom steel fabrication for our stamping line was delivered two weeks ahead of schedule. Exceptional weld quality and full NDT reports. | Marcus Vance | Director of Engineering, Precision AutoCorp\nReliable partner for complex alloy machining. Their metallurgical traceability and CMM documentation make audit compliance effortless. | David Miller | Supply Chain Head, AeroDynamics Global",
		// Clients.
		'home_clients_title' => esc_html__( 'Trusted by leading industrial enterprises', 'gp-industry' ),
		'home_clients_names' => "Tata Steel\nSiemens Energy\nLarsen & Toubro\nBharat Forge\nMahindra Heavy\nCaterpillar",
		// FAQ.
		'home_faq_eyebrow' => esc_html__( 'Technical FAQ', 'gp-industry' ),
		'home_faq_title'   => esc_html__( 'Frequently asked engineering questions', 'gp-industry' ),
		'home_faq_items'   => "What machining tolerances can you achieve? | We routinely achieve tolerances down to ±0.005 mm (5 microns) on our temperature-controlled 5-axis CNC machining centers.\nWhat materials do you work with? | We machine and fabricate carbon steel, stainless steel (304, 316, duplex), titanium alloys, Inconel, aluminum, brass, and high-tensile structural steel.\nDo you provide material test certificates (MTC)? | Yes. Every batch is accompanied by EN 10204 3.1 material test certificates, heat treatment charts, CMM reports, and NDT inspection records.\nWhat is your typical lead time for custom fabrication? | Standard prototypes ship in 5–10 business days. Production batch runs typically ship within 3–4 weeks depending on material availability and tooling.",
	);
}

/**
 * Parse a "one item per line, columns separated by |" textarea.
 *
 * @param string $text Raw option value.
 * @param int    $cols Expected columns (missing columns are filled with '').
 * @return array[]
 */
function gpi_parse_lines( $text, $cols = 2 ) {
	$rows = array();
	foreach ( preg_split( '/\r\n|\r|\n/', (string) $text ) as $line ) {
		$line = trim( $line );
		if ( '' === $line ) {
			continue;
		}
		$parts = array_map( 'trim', explode( '|', $line ) );
		$parts = array_pad( $parts, $cols, '' );
		$rows[] = $parts;
	}
	return $rows;
}

/**
 * Register homepage sections in the Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Manager.
 */
function gpi_home_customize_register( $wp_customize ) {
	$d = gpi_home_defaults();

	$add = function ( $id, $setting, $control ) use ( $wp_customize ) {
		$full = 'gpi_' . $id;
		$wp_customize->add_setting( $full, wp_parse_args( $setting, array( 'transport' => 'refresh' ) ) );
		$type = isset( $control['type'] ) ? $control['type'] : 'text';
		if ( 'image' === $type ) {
			unset( $control['type'] );
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $full, $control ) );
		} else {
			$wp_customize->add_control( $full, $control );
		}
	};

	$lines_help = esc_html__( 'One item per line. Separate columns with a vertical bar |', 'gp-industry' );

	/* ---- About / intro ---- */
	$wp_customize->add_section( 'gpi_home_about', array( 'title' => esc_html__( 'Homepage: About / Intro', 'gp-industry' ), 'panel' => 'gpi_panel', 'priority' => 46 ) );
	$add( 'show_home_about', array( 'default' => true, 'sanitize_callback' => 'gpi_sanitize_checkbox' ), array( 'label' => esc_html__( 'Show about section', 'gp-industry' ), 'section' => 'gpi_home_about', 'type' => 'checkbox' ) );
	$add( 'home_about_image', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ), array( 'label' => esc_html__( 'Image (factory / team photo)', 'gp-industry' ), 'section' => 'gpi_home_about', 'type' => 'image' ) );
	$add( 'home_about_eyebrow', array( 'default' => $d['home_about_eyebrow'], 'sanitize_callback' => 'sanitize_text_field' ), array( 'label' => esc_html__( 'Eyebrow label', 'gp-industry' ), 'section' => 'gpi_home_about', 'type' => 'text' ) );
	$add( 'home_about_title', array( 'default' => $d['home_about_title'], 'sanitize_callback' => 'sanitize_text_field' ), array( 'label' => esc_html__( 'Title', 'gp-industry' ), 'section' => 'gpi_home_about', 'type' => 'text' ) );
	$add( 'home_about_text', array( 'default' => $d['home_about_text'], 'sanitize_callback' => 'sanitize_textarea_field' ), array( 'label' => esc_html__( 'Text', 'gp-industry' ), 'section' => 'gpi_home_about', 'type' => 'textarea' ) );
	$add( 'home_about_list', array( 'default' => $d['home_about_list'], 'sanitize_callback' => 'sanitize_textarea_field' ), array( 'label' => esc_html__( 'Checklist (one per line)', 'gp-industry' ), 'section' => 'gpi_home_about', 'type' => 'textarea' ) );
	$add( 'home_about_btn', array( 'default' => $d['home_about_btn'], 'sanitize_callback' => 'sanitize_text_field' ), array( 'label' => esc_html__( 'Button text', 'gp-industry' ), 'section' => 'gpi_home_about', 'type' => 'text' ) );
	$add( 'home_about_url', array( 'default' => $d['home_about_url'], 'sanitize_callback' => 'esc_url_raw' ), array( 'label' => esc_html__( 'Button link', 'gp-industry' ), 'section' => 'gpi_home_about', 'type' => 'url' ) );
	$add( 'home_about_badge', array( 'default' => $d['home_about_badge'], 'sanitize_callback' => 'sanitize_text_field' ), array( 'label' => esc_html__( 'Floating badge – big text', 'gp-industry' ), 'section' => 'gpi_home_about', 'type' => 'text' ) );
	$add( 'home_about_badge_2', array( 'default' => $d['home_about_badge_2'], 'sanitize_callback' => 'sanitize_text_field' ), array( 'label' => esc_html__( 'Floating badge – small text', 'gp-industry' ), 'section' => 'gpi_home_about', 'type' => 'text' ) );

	/* ---- Products ---- */
	$wp_customize->add_section( 'gpi_home_products', array( 'title' => esc_html__( 'Homepage: Products', 'gp-industry' ), 'description' => esc_html__( 'Shows the child pages of your Products (or Services) page as cards.', 'gp-industry' ), 'panel' => 'gpi_panel', 'priority' => 47 ) );
	$add( 'show_home_products', array( 'default' => true, 'sanitize_callback' => 'gpi_sanitize_checkbox' ), array( 'label' => esc_html__( 'Show products section', 'gp-industry' ), 'section' => 'gpi_home_products', 'type' => 'checkbox' ) );
	$add( 'home_products_page', array( 'default' => 0, 'sanitize_callback' => 'absint' ), array( 'label' => esc_html__( 'Products page (cards come from its child pages)', 'gp-industry' ), 'description' => esc_html__( 'Leave empty to auto-detect a page named "Products" or "Services".', 'gp-industry' ), 'section' => 'gpi_home_products', 'type' => 'dropdown-pages', 'allow_addition' => false ) );
	$add( 'home_products_eyebrow', array( 'default' => $d['home_products_eyebrow'], 'sanitize_callback' => 'sanitize_text_field' ), array( 'label' => esc_html__( 'Eyebrow label', 'gp-industry' ), 'section' => 'gpi_home_products', 'type' => 'text' ) );
	$add( 'home_products_title', array( 'default' => $d['home_products_title'], 'sanitize_callback' => 'sanitize_text_field' ), array( 'label' => esc_html__( 'Title', 'gp-industry' ), 'section' => 'gpi_home_products', 'type' => 'text' ) );
	$add( 'home_products_count', array( 'default' => 6, 'sanitize_callback' => 'absint' ), array( 'label' => esc_html__( 'Number of cards', 'gp-industry' ), 'section' => 'gpi_home_products', 'type' => 'number', 'input_attrs' => array( 'min' => 1, 'max' => 12 ) ) );

	/* ---- Industries ---- */
	$wp_customize->add_section( 'gpi_home_industries', array( 'title' => esc_html__( 'Homepage: Industries', 'gp-industry' ), 'panel' => 'gpi_panel', 'priority' => 48 ) );
	$add( 'show_home_industries', array( 'default' => true, 'sanitize_callback' => 'gpi_sanitize_checkbox' ), array( 'label' => esc_html__( 'Show industries section', 'gp-industry' ), 'section' => 'gpi_home_industries', 'type' => 'checkbox' ) );
	$add( 'home_industries_eyebrow', array( 'default' => $d['home_industries_eyebrow'], 'sanitize_callback' => 'sanitize_text_field' ), array( 'label' => esc_html__( 'Eyebrow label', 'gp-industry' ), 'section' => 'gpi_home_industries', 'type' => 'text' ) );
	$add( 'home_industries_title', array( 'default' => $d['home_industries_title'], 'sanitize_callback' => 'sanitize_text_field' ), array( 'label' => esc_html__( 'Title', 'gp-industry' ), 'section' => 'gpi_home_industries', 'type' => 'text' ) );
	$add( 'home_industries_text', array( 'default' => $d['home_industries_text'], 'sanitize_callback' => 'sanitize_textarea_field' ), array( 'label' => esc_html__( 'Description', 'gp-industry' ), 'section' => 'gpi_home_industries', 'type' => 'textarea' ) );
	$add( 'home_industries_items', array( 'default' => $d['home_industries_items'], 'sanitize_callback' => 'sanitize_textarea_field' ), array( 'label' => esc_html__( 'Industries', 'gp-industry' ), 'description' => $lines_help . ' — ' . esc_html__( 'icon | Title | short text. Icons: factory, cog, truck, hardhat, wrench, award, package, users, target, ruler, leaf, bolt, shield, layers, globe, chart, star', 'gp-industry' ), 'section' => 'gpi_home_industries', 'type' => 'textarea', 'input_attrs' => array( 'rows' => 8 ) ) );

	/* ---- Process ---- */
	$wp_customize->add_section( 'gpi_home_process', array( 'title' => esc_html__( 'Homepage: Our Process', 'gp-industry' ), 'panel' => 'gpi_panel', 'priority' => 49 ) );
	$add( 'show_home_process', array( 'default' => true, 'sanitize_callback' => 'gpi_sanitize_checkbox' ), array( 'label' => esc_html__( 'Show process section', 'gp-industry' ), 'section' => 'gpi_home_process', 'type' => 'checkbox' ) );
	$add( 'home_process_eyebrow', array( 'default' => $d['home_process_eyebrow'], 'sanitize_callback' => 'sanitize_text_field' ), array( 'label' => esc_html__( 'Eyebrow label', 'gp-industry' ), 'section' => 'gpi_home_process', 'type' => 'text' ) );
	$add( 'home_process_title', array( 'default' => $d['home_process_title'], 'sanitize_callback' => 'sanitize_text_field' ), array( 'label' => esc_html__( 'Title', 'gp-industry' ), 'section' => 'gpi_home_process', 'type' => 'text' ) );
	$add( 'home_process_items', array( 'default' => $d['home_process_items'], 'sanitize_callback' => 'sanitize_textarea_field' ), array( 'label' => esc_html__( 'Steps', 'gp-industry' ), 'description' => $lines_help . ' — ' . esc_html__( 'Step title | description', 'gp-industry' ), 'section' => 'gpi_home_process', 'type' => 'textarea', 'input_attrs' => array( 'rows' => 6 ) ) );

	/* ---- Testimonials ---- */
	$wp_customize->add_section( 'gpi_home_testimonials', array( 'title' => esc_html__( 'Homepage: Testimonials', 'gp-industry' ), 'panel' => 'gpi_panel', 'priority' => 52 ) );
	$add( 'show_home_testimonials', array( 'default' => true, 'sanitize_callback' => 'gpi_sanitize_checkbox' ), array( 'label' => esc_html__( 'Show testimonials', 'gp-industry' ), 'section' => 'gpi_home_testimonials', 'type' => 'checkbox' ) );
	$add( 'home_testimonials_eyebrow', array( 'default' => $d['home_testimonials_eyebrow'], 'sanitize_callback' => 'sanitize_text_field' ), array( 'label' => esc_html__( 'Eyebrow label', 'gp-industry' ), 'section' => 'gpi_home_testimonials', 'type' => 'text' ) );
	$add( 'home_testimonials_title', array( 'default' => $d['home_testimonials_title'], 'sanitize_callback' => 'sanitize_text_field' ), array( 'label' => esc_html__( 'Title', 'gp-industry' ), 'section' => 'gpi_home_testimonials', 'type' => 'text' ) );
	$add( 'home_testimonials_items', array( 'default' => $d['home_testimonials_items'], 'sanitize_callback' => 'sanitize_textarea_field' ), array( 'label' => esc_html__( 'Testimonials', 'gp-industry' ), 'description' => $lines_help . ' — ' . esc_html__( 'Quote | Name | Company / role', 'gp-industry' ), 'section' => 'gpi_home_testimonials', 'type' => 'textarea', 'input_attrs' => array( 'rows' => 8 ) ) );

	/* ---- Clients / certifications ---- */
	$wp_customize->add_section( 'gpi_home_clients', array( 'title' => esc_html__( 'Homepage: Clients & Certifications', 'gp-industry' ), 'panel' => 'gpi_panel', 'priority' => 53 ) );
	$add( 'show_home_clients', array( 'default' => true, 'sanitize_callback' => 'gpi_sanitize_checkbox' ), array( 'label' => esc_html__( 'Show clients strip', 'gp-industry' ), 'section' => 'gpi_home_clients', 'type' => 'checkbox' ) );
	$add( 'home_clients_title', array( 'default' => $d['home_clients_title'], 'sanitize_callback' => 'sanitize_text_field' ), array( 'label' => esc_html__( 'Title', 'gp-industry' ), 'section' => 'gpi_home_clients', 'type' => 'text' ) );
	for ( $i = 1; $i <= 8; $i++ ) {
		$add( "home_client_logo_{$i}", array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ), array(
			/* translators: %d: logo number */
			'label'   => sprintf( esc_html__( 'Logo %d (client or certification)', 'gp-industry' ), $i ),
			'section' => 'gpi_home_clients',
			'type'    => 'image',
		) );
	}
	$add( 'home_clients_names', array( 'default' => $d['home_clients_names'], 'sanitize_callback' => 'sanitize_textarea_field' ), array( 'label' => esc_html__( 'Text fallback (one name per line, used when no logos are uploaded)', 'gp-industry' ), 'section' => 'gpi_home_clients', 'type' => 'textarea' ) );

	/* ---- Services page extras ---- */
	$wp_customize->add_section( 'gpi_services_page', array( 'title' => esc_html__( 'Services Page: Sections', 'gp-industry' ), 'description' => esc_html__( 'Extra sections shown on pages using the "Services Page" template (they reuse the homepage Process / Testimonials / FAQ content).', 'gp-industry' ), 'panel' => 'gpi_panel', 'priority' => 56 ) );
	$add( 'services_show_process', array( 'default' => true, 'sanitize_callback' => 'gpi_sanitize_checkbox' ), array( 'label' => esc_html__( 'Show "Our Process"', 'gp-industry' ), 'section' => 'gpi_services_page', 'type' => 'checkbox' ) );
	$add( 'services_show_testimonials', array( 'default' => true, 'sanitize_callback' => 'gpi_sanitize_checkbox' ), array( 'label' => esc_html__( 'Show testimonials', 'gp-industry' ), 'section' => 'gpi_services_page', 'type' => 'checkbox' ) );
	$add( 'services_show_faq', array( 'default' => true, 'sanitize_callback' => 'gpi_sanitize_checkbox' ), array( 'label' => esc_html__( 'Show FAQ', 'gp-industry' ), 'section' => 'gpi_services_page', 'type' => 'checkbox' ) );

	/* ---- FAQ ---- */
	$wp_customize->add_section( 'gpi_home_faq', array( 'title' => esc_html__( 'Homepage: FAQ', 'gp-industry' ), 'panel' => 'gpi_panel', 'priority' => 54 ) );
	$add( 'show_home_faq', array( 'default' => true, 'sanitize_callback' => 'gpi_sanitize_checkbox' ), array( 'label' => esc_html__( 'Show FAQ', 'gp-industry' ), 'section' => 'gpi_home_faq', 'type' => 'checkbox' ) );
	$add( 'home_faq_eyebrow', array( 'default' => $d['home_faq_eyebrow'], 'sanitize_callback' => 'sanitize_text_field' ), array( 'label' => esc_html__( 'Eyebrow label', 'gp-industry' ), 'section' => 'gpi_home_faq', 'type' => 'text' ) );
	$add( 'home_faq_title', array( 'default' => $d['home_faq_title'], 'sanitize_callback' => 'sanitize_text_field' ), array( 'label' => esc_html__( 'Title', 'gp-industry' ), 'section' => 'gpi_home_faq', 'type' => 'text' ) );
	$add( 'home_faq_items', array( 'default' => $d['home_faq_items'], 'sanitize_callback' => 'sanitize_textarea_field' ), array( 'label' => esc_html__( 'Questions', 'gp-industry' ), 'description' => $lines_help . ' — ' . esc_html__( 'Question | Answer', 'gp-industry' ), 'section' => 'gpi_home_faq', 'type' => 'textarea', 'input_attrs' => array( 'rows' => 8 ) ) );
}
add_action( 'customize_register', 'gpi_home_customize_register', 20 );

/**
 * Find the page whose child pages feed the homepage products section.
 *
 * @return int Page ID or 0.
 */
function gpi_home_products_page_id() {
	$id = absint( gpi_get_option( 'home_products_page', 0 ) );
	if ( $id ) {
		return $id;
	}
	foreach ( array( 'solutions', 'products', 'our-products', 'services', 'our-services' ) as $slug ) {
		$page = get_page_by_path( $slug, OBJECT, 'page' );
		if ( $page ) {
			return $page->ID;
		}
	}
	return 0;
}
