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
		'home_about_title'   => esc_html__( 'Recruit Quality Resources, Nurture & Retain — Strategic Workforce & Facility Solutions', 'gp-industry' ),
		/* translators: %s: company name */
		'home_about_text'    => sprintf( esc_html__( '%s delivers integrated workforce solutions, strategic facilities management, and 100%% statutory payroll compliance. Backed by over a decade of operational excellence, our human-centric approach combines deep market intelligence, verified candidate networks, and structured SOP training to create measurable enterprise value.', 'gp-industry' ), $company ),
		'home_about_list'    => "10+ Years of corporate excellence & 100+ man-years of talent leadership\n100% Statutory Compliance Guarantee: PF, ESI, EPFO & monthly ECR filing\nStrategic Integrated Facilities Management (IFM) & mechanized maintenance\nLogistics & Warehouse Operations: certified forklift & BOPT workforce pods\nProprietary 4,000,000+ pre-screened talent database across 15+ verticals\nPan-India deployment network with 24/7/365 rapid-response support",
		'home_about_btn'     => esc_html__( 'Explore Our Services', 'gp-industry' ),
		'home_about_url'     => '/services/',
		'home_about_image'   => GPI_THEME_URI . '/assets/images/about-facility.jpg',
		'home_about_badge'   => esc_html__( '10+ Years', 'gp-industry' ),
		'home_about_badge_2' => esc_html__( 'of corporate excellence since 2014', 'gp-industry' ),
		// Products / solutions.
		'home_products_eyebrow' => esc_html__( 'Core Solutions', 'gp-industry' ),
		'home_products_title'   => esc_html__( 'Strategic workforce, staffing & facilities management models', 'gp-industry' ),
		'home_products_page'    => 0,
		'home_products_count'   => 6,
		// Industries.
		'home_industries_eyebrow' => esc_html__( 'Industry Expertise', 'gp-industry' ),
		'home_industries_title'   => esc_html__( 'Pan-India cross-sector support across critical industries', 'gp-industry' ),
		'home_industries_text'    => esc_html__( 'We combine domain understanding, compliance rigour, and specialized candidate networks to manage end-to-end workforce operations across key sectors.', 'gp-industry' ),
		'home_industries_items'   => "truck | Logistics & Warehousing | Forklift operators, BOPT handlers, inventory controllers & warehouse managers\nbuilding-columns | Corporate Offices & BFSI | Integrated facility managers, executive assistants, accountants & payroll analysts\nfactory | Manufacturing & Industrial Plants | Shift engineers, machine technicians, safety officers & plant maintenance\nheart-pulse | Healthcare & Pharmaceuticals | Hospital housekeeping, biomedical attendants, lab technicians & front-desk\nmicrochip | Information Technology & Telecom | Tech support, network engineers, facilities coordinators & helpdesk\ncart-shopping | Retail & E-Commerce | Hub operations, dispatch supervisors, pickers & customer support executives\nshield | Security & Surveillance | Security guards, control room monitors, fire safety marshals & access controllers\nlayers | Real Estate & Infrastructure | MEP technicians, HVAC chiller operators, DG set handlers & caretakers",
		// Process.
		'home_process_eyebrow' => esc_html__( 'Our Methodology', 'gp-industry' ),
		'home_process_title'   => esc_html__( 'A structured, high-precision hiring & deployment lifecycle', 'gp-industry' ),
		'home_process_items'   => "Role Calibration & Market Mapping | In-depth alignment on competencies, headcount budgets, compensation benchmarking, and talent availability mapping.\nRigorous Vetting & Background Verification | Multi-tier functional assessment, police verification, past work track record and KYC compliance check.\n2-Week Pre-Deployment Soft-Skills Induction | Mandatory training on client workplace SOPs, professional grooming, safety protocols and job role essentials.\n100% Compliant Payroll & SLA Governance | Automated biometric attendance, error-free monthly salary disbursement, timely PF/ESI ECR filings and 24/7 client desk.",
		// Testimonials.
		'home_testimonials_eyebrow' => esc_html__( 'Client Endorsements', 'gp-industry' ),
		'home_testimonials_title'   => esc_html__( 'Trusted by business leaders, HR directors, and operations heads', 'gp-industry' ),
		'home_testimonials_items'   => "Varunya transformed our warehouse and logistics staffing. Deploying 80+ certified equipment operators with 100% on-time attendance has boosted our dispatch speed significantly. | Rajesh Sharma | VP of Operations\nTheir payroll outsourcing and PF/ESI compliance management is completely dispute-free. Our monthly audits have been seamless for over 2 years. | Marcus Vance | Head of Human Resources\nThe integrated facilities management team maintains our 250,000 sq.ft corporate campus to five-star standards with bio-friendly mechanized upkeep. | David Miller | Director of Corporate Infrastructure",
		// Clients.
		'home_clients_title' => esc_html__( 'Enterprise partners who trust our workforce & facility expertise', 'gp-industry' ),
		'home_clients_names' => "Blinkit\nDelhivery\nMother Dairy\nSRF Limited\nJindal Steel & Power\nTata Advanced Systems\nImperial Auto\nHero MotoCorp",
		// FAQ.
		'home_faq_eyebrow' => esc_html__( 'Consulting FAQ', 'gp-industry' ),
		'home_faq_title'   => esc_html__( 'Frequently asked workforce & facilities management questions', 'gp-industry' ),
		'home_faq_items'   => "What workforce and consulting services do you offer? | We specialize in Strategic HR Staffing, 100% Statutory Payroll Compliance (PF/ESI/EPFO), Integrated Facilities Management (IFM), Logistics & Warehouse Operations, Executive Search, and IT Staff Augmentation.\nHow do you ensure 100% statutory compliance? | We manage end-to-end EPFO, ESIC, Professional Tax, Labour Welfare Fund and Gratuity. Monthly ECR challans and bank disbursement proofs are provided directly to client audit teams with zero deviation.\nWhat is your candidate induction and training process? | Every selected resource undergoes our proprietary National Resource Cell induction, including workplace SOPs, professional hygiene, POSH guidelines, and role-specific safety standards before day one.\nWhat geographic locations do you cover? | We operate across Delhi NCR, Uttar Pradesh, Haryana, Uttarakhand, and provide Pan-India workforce deployment through dedicated regional resource cells.",
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
