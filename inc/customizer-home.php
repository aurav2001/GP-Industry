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
function gpi_home_defaults() {
	return array(
		// About / intro.
		'home_about_eyebrow' => esc_html__( 'About GP-Industry', 'gp-industry' ),
		'home_about_title'   => esc_html__( 'Two decades of precision manufacturing', 'gp-industry' ),
		'home_about_text'    => esc_html__( 'From a single workshop in 1998 to multi-plant operations today, we build components and equipment that keep industries running — with certified processes, modern machinery and a team that cares about every tolerance.', 'gp-industry' ),
		'home_about_list'    => "ISO 9001:2015 certified plant\nIn-house testing & quality lab\nOn-time delivery across 40+ countries\nDedicated engineering support",
		'home_about_btn'     => esc_html__( 'More about us', 'gp-industry' ),
		'home_about_url'     => '/about-us/',
		'home_about_image'   => '',
		'home_about_badge'   => esc_html__( '25+ Years', 'gp-industry' ),
		'home_about_badge_2' => esc_html__( 'of industry experience', 'gp-industry' ),
		// Products.
		'home_products_eyebrow' => esc_html__( 'Our products', 'gp-industry' ),
		'home_products_title'   => esc_html__( 'Engineered products, built to specification', 'gp-industry' ),
		'home_products_page'    => 0,
		'home_products_count'   => 6,
		// Industries.
		'home_industries_eyebrow' => esc_html__( 'Industries', 'gp-industry' ),
		'home_industries_title'   => esc_html__( 'Industries we serve', 'gp-industry' ),
		'home_industries_text'    => esc_html__( 'Proven supply experience across regulated and high-volume sectors.', 'gp-industry' ),
		'home_industries_items'   => "cog | Automotive | OEM and tier-1 component supply\nlayers | Construction | Structural steel and fittings\nbolt | Energy & Power | Turbine, solar and grid hardware\npackage | Oil & Gas | Valves, flanges and pressure parts\ntarget | Aerospace | High-tolerance precision parts\nshield | Medical | Clean-room grade components",
		// Process.
		'home_process_eyebrow' => esc_html__( 'How we work', 'gp-industry' ),
		'home_process_title'   => esc_html__( 'From enquiry to delivery in four steps', 'gp-industry' ),
		'home_process_items'   => "Enquiry & Drawings | Share specifications, drawings or samples. We review feasibility within 24 hours.\nQuotation | Transparent pricing with lead times, tolerances and material certificates.\nProduction & QC | Manufacturing with in-process inspection and final quality reports.\nDelivery | Secure packaging and on-time dispatch — domestic and export.",
		// Testimonials.
		'home_testimonials_eyebrow' => esc_html__( 'Testimonials', 'gp-industry' ),
		'home_testimonials_title'   => esc_html__( 'What our clients say', 'gp-industry' ),
		'home_testimonials_items'   => "Consistent quality across 40,000 parts with zero rejections. Their QC documentation made our audit effortless. | Ramesh Iyer | Procurement Head, AutoTech Ltd\nThey took our concept drawings and delivered a production-ready assembly in three weeks. | Sneha Kulkarni | Plant Manager, Vertex Energy\nReliable lead times and honest communication. Exactly what you want from a supplier. | David Müller | Sourcing Director, Nordwerk GmbH",
		// Clients.
		'home_clients_title' => esc_html__( 'Trusted by industry leaders', 'gp-industry' ),
		'home_clients_names' => "Tata Steel\nL&T\nSiemens\nBHEL\nBosch\nABB",
		// FAQ.
		'home_faq_eyebrow' => esc_html__( 'FAQ', 'gp-industry' ),
		'home_faq_title'   => esc_html__( 'Frequently asked questions', 'gp-industry' ),
		'home_faq_items'   => "What is your minimum order quantity? | Standard items have no MOQ. Custom-machined parts typically start at 100 pieces, but we are happy to quote prototypes and small batches.\nWhich file formats do you accept? | STEP, IGES, DWG, DXF and PDF drawings. Physical samples are also welcome for reverse engineering.\nDo you provide material certificates? | Yes. Every batch ships with a material test certificate and an inspection report on request.\nDo you export? | We supply to 40+ countries with export packing, documentation and freight coordination.",
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
	foreach ( array( 'products', 'our-products', 'services', 'our-services' ) as $slug ) {
		$page = get_page_by_path( $slug, OBJECT, 'page' );
		if ( $page ) {
			return $page->ID;
		}
	}
	return 0;
}
