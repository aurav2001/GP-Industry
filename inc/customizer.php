<?php
/**
 * Theme Customizer options.
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ---------- Sanitizers ---------- */

/**
 * Sanitize checkbox.
 *
 * @param mixed $value Value.
 * @return bool
 */
function gpi_sanitize_checkbox( $value ) {
	return ( true === $value || '1' === $value || 1 === $value ) ? true : false;
}

/**
 * Sanitize select against choices.
 *
 * @param string               $value   Value.
 * @param WP_Customize_Setting $setting Setting.
 * @return string
 */
function gpi_sanitize_select( $value, $setting ) {
	$control = $setting->manager->get_control( $setting->id );
	$choices = $control ? $control->choices : array();
	return array_key_exists( $value, $choices ) ? $value : $setting->default;
}

/**
 * Sanitize a positive integer.
 *
 * @param mixed $value Value.
 * @return int
 */
function gpi_sanitize_int( $value ) {
	return absint( $value );
}

/**
 * Sanitize hero title (allows span/br/strong/em).
 *
 * @param string $value Value.
 * @return string
 */
function gpi_sanitize_hero_title( $value ) {
	return wp_kses( $value, gpi_hero_allowed_html() );
}

/* ---------- Register ---------- */

/**
 * Register Customizer panel, sections, settings and controls.
 *
 * @param WP_Customize_Manager $wp_customize Manager.
 */
function gpi_theme_customize_register( $wp_customize ) {
	$defaults = gpi_option_defaults();

	// Live preview for core settings.
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	$wp_customize->selective_refresh->add_partial(
		'blogname',
		array(
			'selector'        => '.site-branding .site-title',
			'render_callback' => function () {
				bloginfo( 'name' );
			},
		)
	);

	$wp_customize->add_panel(
		'gpi_panel',
		array(
			'title'       => esc_html__( 'GP-Industry Options', 'gp-industry' ),
			'description' => esc_html__( 'Colors, homepage sections, header, blog and footer settings.', 'gp-industry' ),
			'priority'    => 10,
		)
	);

	/**
	 * Helper to add a setting + control in one call.
	 *
	 * @param string $id      ID (without gpi_ prefix).
	 * @param array  $setting Setting args.
	 * @param array  $control Control args.
	 */
	$add = function ( $id, $setting, $control ) use ( $wp_customize ) {
		$full = 'gpi_' . $id;
		$wp_customize->add_setting( $full, wp_parse_args( $setting, array( 'transport' => 'refresh' ) ) );

		$type = isset( $control['type'] ) ? $control['type'] : 'text';
		if ( 'color' === $type ) {
			unset( $control['type'] );
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $full, $control ) );
		} elseif ( 'image' === $type ) {
			unset( $control['type'] );
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $full, $control ) );
		} else {
			$wp_customize->add_control( $full, $control );
		}
	};

	/* ----- Colors & Style ----- */
	$wp_customize->add_section( 'gpi_colors', array( 'title' => esc_html__( 'Colors & Style', 'gp-industry' ), 'panel' => 'gpi_panel', 'priority' => 10 ) );

	$add( 'color_scheme', array( 'default' => 'dark', 'sanitize_callback' => 'gpi_sanitize_select' ), array(
		'label'   => esc_html__( 'Default color scheme', 'gp-industry' ),
		'section' => 'gpi_colors',
		'type'    => 'select',
		'choices' => array(
			'dark'   => esc_html__( 'Dark', 'gp-industry' ),
			'light'  => esc_html__( 'Light', 'gp-industry' ),
			'system' => esc_html__( 'Follow visitor system setting', 'gp-industry' ),
		),
	) );

	$add( 'show_theme_toggle', array( 'default' => true, 'sanitize_callback' => 'gpi_sanitize_checkbox' ), array(
		'label'   => esc_html__( 'Show dark / light toggle in header', 'gp-industry' ),
		'section' => 'gpi_colors',
		'type'    => 'checkbox',
	) );

	$add( 'accent_color', array( 'default' => '#6366f1', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ), array(
		'label'   => esc_html__( 'Primary accent color', 'gp-industry' ),
		'section' => 'gpi_colors',
		'type'    => 'color',
	) );

	$add( 'accent_color_2', array( 'default' => '#ec4899', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ), array(
		'label'       => esc_html__( 'Gradient end color', 'gp-industry' ),
		'description' => esc_html__( 'Used for gradient buttons, headings and glows.', 'gp-industry' ),
		'section'     => 'gpi_colors',
		'type'        => 'color',
	) );

	$add( 'radius', array( 'default' => 16, 'sanitize_callback' => 'gpi_sanitize_int', 'transport' => 'postMessage' ), array(
		'label'       => esc_html__( 'Corner radius (px)', 'gp-industry' ),
		'section'     => 'gpi_colors',
		'type'        => 'range',
		'input_attrs' => array( 'min' => 0, 'max' => 32, 'step' => 2 ),
	) );

	/* ----- Header ----- */
	$wp_customize->add_section( 'gpi_header', array( 'title' => esc_html__( 'Header', 'gp-industry' ), 'panel' => 'gpi_panel', 'priority' => 20 ) );

	$add( 'header_style', array( 'default' => 'floating', 'sanitize_callback' => 'gpi_sanitize_select' ), array(
		'label'   => esc_html__( 'Header style', 'gp-industry' ),
		'section' => 'gpi_header',
		'type'    => 'select',
		'choices' => array(
			'floating' => esc_html__( 'Floating island (modern)', 'gp-industry' ),
			'classic'  => esc_html__( 'Classic full-width bar', 'gp-industry' ),
		),
	) );

	$add( 'show_search', array( 'default' => true, 'sanitize_callback' => 'gpi_sanitize_checkbox' ), array(
		'label'   => esc_html__( 'Show search button', 'gp-industry' ),
		'section' => 'gpi_header',
		'type'    => 'checkbox',
	) );

	$add( 'show_topbar', array( 'default' => false, 'sanitize_callback' => 'gpi_sanitize_checkbox' ), array(
		'label'   => esc_html__( 'Show announcement bar above header', 'gp-industry' ),
		'section' => 'gpi_header',
		'type'    => 'checkbox',
	) );
	$add( 'topbar_text', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ), array(
		'label'   => esc_html__( 'Announcement text', 'gp-industry' ),
		'section' => 'gpi_header',
		'type'    => 'text',
	) );
	$add( 'topbar_link_text', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ), array(
		'label'   => esc_html__( 'Announcement link text', 'gp-industry' ),
		'section' => 'gpi_header',
		'type'    => 'text',
	) );
	$add( 'topbar_link_url', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ), array(
		'label'   => esc_html__( 'Announcement link URL', 'gp-industry' ),
		'section' => 'gpi_header',
		'type'    => 'url',
	) );

	$add( 'header_cta_text', array( 'default' => $defaults['header_cta_text'], 'sanitize_callback' => 'sanitize_text_field' ), array(
		'label'       => esc_html__( 'Header button text', 'gp-industry' ),
		'description' => esc_html__( 'Leave empty to hide the button.', 'gp-industry' ),
		'section'     => 'gpi_header',
		'type'        => 'text',
	) );

	$add( 'header_cta_url', array( 'default' => $defaults['header_cta_url'], 'sanitize_callback' => 'esc_url_raw' ), array(
		'label'   => esc_html__( 'Header button link', 'gp-industry' ),
		'section' => 'gpi_header',
		'type'    => 'url',
	) );

	$add( 'sticky_header', array( 'default' => true, 'sanitize_callback' => 'gpi_sanitize_checkbox' ), array(
		'label'   => esc_html__( 'Sticky header', 'gp-industry' ),
		'section' => 'gpi_header',
		'type'    => 'checkbox',
	) );

	/* ----- Hero ----- */
	$wp_customize->add_section( 'gpi_hero', array( 'title' => esc_html__( 'Homepage: Hero', 'gp-industry' ), 'panel' => 'gpi_panel', 'priority' => 30 ) );

	$add( 'show_hero', array( 'default' => true, 'sanitize_callback' => 'gpi_sanitize_checkbox' ), array(
		'label'   => esc_html__( 'Show hero section', 'gp-industry' ),
		'section' => 'gpi_hero',
		'type'    => 'checkbox',
	) );

	$add( 'hero_badge', array( 'default' => $defaults['hero_badge'], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ), array(
		'label'   => esc_html__( 'Badge text', 'gp-industry' ),
		'section' => 'gpi_hero',
		'type'    => 'text',
	) );

	$add( 'hero_title', array( 'default' => $defaults['hero_title'], 'sanitize_callback' => 'gpi_sanitize_hero_title', 'transport' => 'postMessage' ), array(
		'label'       => esc_html__( 'Hero title', 'gp-industry' ),
		'description' => esc_html__( 'Wrap words in <span></span> to give them the gradient highlight.', 'gp-industry' ),
		'section'     => 'gpi_hero',
		'type'        => 'textarea',
	) );

	$add( 'hero_subtitle', array( 'default' => $defaults['hero_subtitle'], 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'postMessage' ), array(
		'label'   => esc_html__( 'Hero subtitle', 'gp-industry' ),
		'section' => 'gpi_hero',
		'type'    => 'textarea',
	) );

	$add( 'hero_btn1_text', array( 'default' => $defaults['hero_btn1_text'], 'sanitize_callback' => 'sanitize_text_field' ), array(
		'label'   => esc_html__( 'Primary button text', 'gp-industry' ),
		'section' => 'gpi_hero',
		'type'    => 'text',
	) );
	$add( 'hero_btn1_url', array( 'default' => $defaults['hero_btn1_url'], 'sanitize_callback' => 'esc_url_raw' ), array(
		'label'   => esc_html__( 'Primary button link', 'gp-industry' ),
		'section' => 'gpi_hero',
		'type'    => 'url',
	) );
	$add( 'hero_btn2_text', array( 'default' => $defaults['hero_btn2_text'], 'sanitize_callback' => 'sanitize_text_field' ), array(
		'label'   => esc_html__( 'Secondary button text', 'gp-industry' ),
		'section' => 'gpi_hero',
		'type'    => 'text',
	) );
	$add( 'hero_btn2_url', array( 'default' => $defaults['hero_btn2_url'], 'sanitize_callback' => 'esc_url_raw' ), array(
		'label'   => esc_html__( 'Secondary button link', 'gp-industry' ),
		'section' => 'gpi_hero',
		'type'    => 'url',
	) );
	$add( 'hero_image', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ), array(
		'label'       => esc_html__( 'Hero image (optional)', 'gp-industry' ),
		'description' => esc_html__( 'Shown in a floating card below the hero text. Recommended 1600×900.', 'gp-industry' ),
		'section'     => 'gpi_hero',
		'type'        => 'image',
	) );

	/* ----- Hero background slider ----- */
	$wp_customize->add_section( 'gpi_hero_slider', array( 'title' => esc_html__( 'Homepage: Hero Background Slider', 'gp-industry' ), 'description' => esc_html__( 'Add up to 5 images to show an auto-playing background slideshow behind the hero text. Recommended size 1920×1080.', 'gp-industry' ), 'panel' => 'gpi_panel', 'priority' => 35 ) );

	$add( 'hero_slider_enable', array( 'default' => true, 'sanitize_callback' => 'gpi_sanitize_checkbox' ), array(
		'label'   => esc_html__( 'Enable background slideshow', 'gp-industry' ),
		'section' => 'gpi_hero_slider',
		'type'    => 'checkbox',
	) );

	for ( $i = 1; $i <= 5; $i++ ) {
		$add( "hero_bg_{$i}", array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ), array(
			/* translators: %d: slide number */
			'label'   => sprintf( esc_html__( 'Slide image %d', 'gp-industry' ), $i ),
			'section' => 'gpi_hero_slider',
			'type'    => 'image',
		) );
	}

	$add( 'hero_slider_interval', array( 'default' => 5, 'sanitize_callback' => 'gpi_sanitize_int' ), array(
		'label'       => esc_html__( 'Seconds per slide', 'gp-industry' ),
		'section'     => 'gpi_hero_slider',
		'type'        => 'number',
		'input_attrs' => array( 'min' => 2, 'max' => 20 ),
	) );

	$add( 'hero_slider_overlay', array( 'default' => 60, 'sanitize_callback' => 'gpi_sanitize_int' ), array(
		'label'       => esc_html__( 'Dark overlay strength (%)', 'gp-industry' ),
		'description' => esc_html__( 'Higher = darker image, more readable text.', 'gp-industry' ),
		'section'     => 'gpi_hero_slider',
		'type'        => 'range',
		'input_attrs' => array( 'min' => 0, 'max' => 90, 'step' => 5 ),
	) );

	$add( 'hero_slider_kenburns', array( 'default' => true, 'sanitize_callback' => 'gpi_sanitize_checkbox' ), array(
		'label'   => esc_html__( 'Slow zoom (Ken Burns) effect', 'gp-industry' ),
		'section' => 'gpi_hero_slider',
		'type'    => 'checkbox',
	) );

	$add( 'hero_slider_dots', array( 'default' => true, 'sanitize_callback' => 'gpi_sanitize_checkbox' ), array(
		'label'   => esc_html__( 'Show slide indicator dots', 'gp-industry' ),
		'section' => 'gpi_hero_slider',
		'type'    => 'checkbox',
	) );

	/* ----- Features ----- */
	$wp_customize->add_section( 'gpi_features', array( 'title' => esc_html__( 'Homepage: Features', 'gp-industry' ), 'panel' => 'gpi_panel', 'priority' => 40 ) );

	$add( 'show_features', array( 'default' => true, 'sanitize_callback' => 'gpi_sanitize_checkbox' ), array(
		'label'   => esc_html__( 'Show features section', 'gp-industry' ),
		'section' => 'gpi_features',
		'type'    => 'checkbox',
	) );
	$add( 'features_eyebrow', array( 'default' => $defaults['features_eyebrow'], 'sanitize_callback' => 'sanitize_text_field' ), array(
		'label'   => esc_html__( 'Eyebrow label', 'gp-industry' ),
		'section' => 'gpi_features',
		'type'    => 'text',
	) );
	$add( 'features_title', array( 'default' => $defaults['features_title'], 'sanitize_callback' => 'sanitize_text_field' ), array(
		'label'   => esc_html__( 'Section title', 'gp-industry' ),
		'section' => 'gpi_features',
		'type'    => 'text',
	) );
	$add( 'features_text', array( 'default' => $defaults['features_text'], 'sanitize_callback' => 'sanitize_textarea_field' ), array(
		'label'   => esc_html__( 'Section description', 'gp-industry' ),
		'section' => 'gpi_features',
		'type'    => 'textarea',
	) );

	foreach ( array( 1, 2, 3, 4, 5, 6 ) as $i ) {
		$def = array( $defaults["feature_{$i}_icon"], $defaults["feature_{$i}_title"], $defaults["feature_{$i}_text"] );
		$add( "feature_{$i}_icon", array( 'default' => $def[0], 'sanitize_callback' => 'gpi_sanitize_select' ), array(
			/* translators: %d: feature number */
			'label'   => sprintf( esc_html__( 'Feature %d icon', 'gp-industry' ), $i ),
			'section' => 'gpi_features',
			'type'    => 'select',
			'choices' => gpi_feature_icon_choices(),
		) );
		$add( "feature_{$i}_title", array( 'default' => $def[1], 'sanitize_callback' => 'sanitize_text_field' ), array(
			/* translators: %d: feature number */
			'label'   => sprintf( esc_html__( 'Feature %d title', 'gp-industry' ), $i ),
			'section' => 'gpi_features',
			'type'    => 'text',
		) );
		$add( "feature_{$i}_text", array( 'default' => $def[2], 'sanitize_callback' => 'sanitize_textarea_field' ), array(
			/* translators: %d: feature number */
			'label'       => sprintf( esc_html__( 'Feature %d text', 'gp-industry' ), $i ),
			'description' => esc_html__( 'Leave the title empty to hide this feature.', 'gp-industry' ),
			'section'     => 'gpi_features',
			'type'        => 'textarea',
		) );
	}

	/* ----- Stats strip ----- */
	$wp_customize->add_section( 'gpi_stats', array( 'title' => esc_html__( 'Homepage: Stats Strip', 'gp-industry' ), 'description' => esc_html__( 'Key numbers shown below the features (years, clients, projects…). Leave a number empty to hide it.', 'gp-industry' ), 'panel' => 'gpi_panel', 'priority' => 45 ) );

	$add( 'show_stats', array( 'default' => true, 'sanitize_callback' => 'gpi_sanitize_checkbox' ), array(
		'label'   => esc_html__( 'Show stats strip', 'gp-industry' ),
		'section' => 'gpi_stats',
		'type'    => 'checkbox',
	) );

	foreach ( array( 1, 2, 3, 4 ) as $i ) {
		$def = array( $defaults["stat_{$i}_number"], $defaults["stat_{$i}_label"] );
		$add( "stat_{$i}_number", array( 'default' => $def[0], 'sanitize_callback' => 'sanitize_text_field' ), array(
			/* translators: %d: stat number */
			'label'   => sprintf( esc_html__( 'Stat %d number', 'gp-industry' ), $i ),
			'section' => 'gpi_stats',
			'type'    => 'text',
		) );
		$add( "stat_{$i}_label", array( 'default' => $def[1], 'sanitize_callback' => 'sanitize_text_field' ), array(
			/* translators: %d: stat number */
			'label'   => sprintf( esc_html__( 'Stat %d label', 'gp-industry' ), $i ),
			'section' => 'gpi_stats',
			'type'    => 'text',
		) );
	}

	/* ----- Latest posts ----- */
	$wp_customize->add_section( 'gpi_home_posts', array( 'title' => esc_html__( 'Homepage: Latest Posts', 'gp-industry' ), 'panel' => 'gpi_panel', 'priority' => 50 ) );

	$add( 'show_home_posts', array( 'default' => true, 'sanitize_callback' => 'gpi_sanitize_checkbox' ), array(
		'label'   => esc_html__( 'Show latest posts section', 'gp-industry' ),
		'section' => 'gpi_home_posts',
		'type'    => 'checkbox',
	) );
	$add( 'home_posts_eyebrow', array( 'default' => $defaults['home_posts_eyebrow'], 'sanitize_callback' => 'sanitize_text_field' ), array(
		'label'   => esc_html__( 'Eyebrow label', 'gp-industry' ),
		'section' => 'gpi_home_posts',
		'type'    => 'text',
	) );
	$add( 'home_posts_title', array( 'default' => $defaults['home_posts_title'], 'sanitize_callback' => 'sanitize_text_field' ), array(
		'label'   => esc_html__( 'Section title', 'gp-industry' ),
		'section' => 'gpi_home_posts',
		'type'    => 'text',
	) );
	$add( 'home_posts_count', array( 'default' => 6, 'sanitize_callback' => 'gpi_sanitize_int' ), array(
		'label'       => esc_html__( 'Number of posts', 'gp-industry' ),
		'section'     => 'gpi_home_posts',
		'type'        => 'number',
		'input_attrs' => array( 'min' => 1, 'max' => 12 ),
	) );

	/* ----- CTA ----- */
	$wp_customize->add_section( 'gpi_cta', array( 'title' => esc_html__( 'Homepage: Call to Action', 'gp-industry' ), 'panel' => 'gpi_panel', 'priority' => 60 ) );

	$add( 'show_cta', array( 'default' => true, 'sanitize_callback' => 'gpi_sanitize_checkbox' ), array(
		'label'   => esc_html__( 'Show call-to-action banner', 'gp-industry' ),
		'section' => 'gpi_cta',
		'type'    => 'checkbox',
	) );
	$add( 'cta_title', array( 'default' => $defaults['cta_title'], 'sanitize_callback' => 'sanitize_text_field' ), array(
		'label'   => esc_html__( 'Title', 'gp-industry' ),
		'section' => 'gpi_cta',
		'type'    => 'text',
	) );
	$add( 'cta_text', array( 'default' => $defaults['cta_text'], 'sanitize_callback' => 'sanitize_textarea_field' ), array(
		'label'   => esc_html__( 'Text', 'gp-industry' ),
		'section' => 'gpi_cta',
		'type'    => 'textarea',
	) );
	$add( 'cta_btn_text', array( 'default' => $defaults['cta_btn_text'], 'sanitize_callback' => 'sanitize_text_field' ), array(
		'label'   => esc_html__( 'Button text', 'gp-industry' ),
		'section' => 'gpi_cta',
		'type'    => 'text',
	) );
	$add( 'cta_btn_url', array( 'default' => $defaults['cta_btn_url'], 'sanitize_callback' => 'esc_url_raw' ), array(
		'label'   => esc_html__( 'Button link', 'gp-industry' ),
		'section' => 'gpi_cta',
		'type'    => 'url',
	) );

	/* ----- Blog ----- */
	$wp_customize->add_section( 'gpi_blog', array( 'title' => esc_html__( 'Blog & Posts', 'gp-industry' ), 'panel' => 'gpi_panel', 'priority' => 70 ) );

	$add( 'blog_layout', array( 'default' => 'grid', 'sanitize_callback' => 'gpi_sanitize_select' ), array(
		'label'   => esc_html__( 'Blog layout', 'gp-industry' ),
		'section' => 'gpi_blog',
		'type'    => 'select',
		'choices' => array(
			'grid'    => esc_html__( 'Full-width grid', 'gp-industry' ),
			'sidebar' => esc_html__( 'With sidebar', 'gp-industry' ),
		),
	) );
	$add( 'excerpt_length', array( 'default' => 22, 'sanitize_callback' => 'gpi_sanitize_int' ), array(
		'label'       => esc_html__( 'Excerpt length (words)', 'gp-industry' ),
		'section'     => 'gpi_blog',
		'type'        => 'number',
		'input_attrs' => array( 'min' => 10, 'max' => 80 ),
	) );
	$add( 'show_breadcrumbs', array( 'default' => true, 'sanitize_callback' => 'gpi_sanitize_checkbox' ), array(
		'label'   => esc_html__( 'Show breadcrumbs', 'gp-industry' ),
		'section' => 'gpi_blog',
		'type'    => 'checkbox',
	) );
	$add( 'show_reading_progress', array( 'default' => true, 'sanitize_callback' => 'gpi_sanitize_checkbox' ), array(
		'label'   => esc_html__( 'Show reading progress bar on posts', 'gp-industry' ),
		'section' => 'gpi_blog',
		'type'    => 'checkbox',
	) );
	$add( 'show_share', array( 'default' => true, 'sanitize_callback' => 'gpi_sanitize_checkbox' ), array(
		'label'   => esc_html__( 'Show share buttons on posts', 'gp-industry' ),
		'section' => 'gpi_blog',
		'type'    => 'checkbox',
	) );
	$add( 'show_author_box', array( 'default' => true, 'sanitize_callback' => 'gpi_sanitize_checkbox' ), array(
		'label'   => esc_html__( 'Show author box on posts', 'gp-industry' ),
		'section' => 'gpi_blog',
		'type'    => 'checkbox',
	) );
	$add( 'show_related', array( 'default' => true, 'sanitize_callback' => 'gpi_sanitize_checkbox' ), array(
		'label'   => esc_html__( 'Show related posts', 'gp-industry' ),
		'section' => 'gpi_blog',
		'type'    => 'checkbox',
	) );

	/* ----- Footer ----- */
	$wp_customize->add_section( 'gpi_footer', array( 'title' => esc_html__( 'Footer', 'gp-industry' ), 'panel' => 'gpi_panel', 'priority' => 80 ) );

	$add( 'footer_tagline', array( 'default' => '', 'sanitize_callback' => 'sanitize_textarea_field' ), array(
		'label'       => esc_html__( 'Footer tagline', 'gp-industry' ),
		'description' => esc_html__( 'Defaults to the site tagline.', 'gp-industry' ),
		'section'     => 'gpi_footer',
		'type'        => 'textarea',
	) );
	$add( 'footer_copyright', array( 'default' => '', 'sanitize_callback' => 'wp_kses_post', 'transport' => 'postMessage' ), array(
		'label'       => esc_html__( 'Copyright text', 'gp-industry' ),
		'description' => esc_html__( 'Use {year} for the current year. Leave empty for the default.', 'gp-industry' ),
		'section'     => 'gpi_footer',
		'type'        => 'text',
	) );
	$add( 'show_back_to_top', array( 'default' => true, 'sanitize_callback' => 'gpi_sanitize_checkbox' ), array(
		'label'   => esc_html__( 'Show "back to top" button', 'gp-industry' ),
		'section' => 'gpi_footer',
		'type'    => 'checkbox',
	) );

	/* ----- Contact info (Contact Page template) ----- */
	$wp_customize->add_section( 'gpi_contact', array( 'title' => esc_html__( 'Contact Info', 'gp-industry' ), 'description' => esc_html__( 'Shown on pages using the "Contact Page" template and in the Service Detail sidebar.', 'gp-industry' ), 'panel' => 'gpi_panel', 'priority' => 85 ) );

	$add( 'contact_address', array( 'default' => '', 'sanitize_callback' => 'sanitize_textarea_field' ), array(
		'label'   => esc_html__( 'Address', 'gp-industry' ),
		'section' => 'gpi_contact',
		'type'    => 'textarea',
	) );
	$add( 'contact_phone', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ), array(
		'label'   => esc_html__( 'Phone', 'gp-industry' ),
		'section' => 'gpi_contact',
		'type'    => 'text',
	) );
	$add( 'contact_email', array( 'default' => '', 'sanitize_callback' => 'sanitize_email' ), array(
		'label'   => esc_html__( 'Email', 'gp-industry' ),
		'section' => 'gpi_contact',
		'type'    => 'email',
	) );
	$add( 'contact_hours', array( 'default' => '', 'sanitize_callback' => 'sanitize_textarea_field' ), array(
		'label'   => esc_html__( 'Working hours', 'gp-industry' ),
		'section' => 'gpi_contact',
		'type'    => 'textarea',
	) );
	$add( 'contact_map', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ), array(
		'label'       => esc_html__( 'Google Maps embed URL', 'gp-industry' ),
		'description' => esc_html__( 'Google Maps → Share → Embed a map → copy only the src="…" URL.', 'gp-industry' ),
		'section'     => 'gpi_contact',
		'type'        => 'url',
	) );
	$add( 'contact_form_title', array( 'default' => $defaults['contact_form_title'], 'sanitize_callback' => 'sanitize_text_field' ), array(
		'label'   => esc_html__( 'Form card title', 'gp-industry' ),
		'section' => 'gpi_contact',
		'type'    => 'text',
	) );

	/* ----- Social ----- */
	$wp_customize->add_section( 'gpi_social', array( 'title' => esc_html__( 'Social Links', 'gp-industry' ), 'panel' => 'gpi_panel', 'priority' => 90 ) );

	foreach ( gpi_social_networks() as $key => $label ) {
		$add( 'social_' . $key, array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ), array(
			'label'   => $label,
			'section' => 'gpi_social',
			'type'    => 'url',
		) );
	}
}
add_action( 'customize_register', 'gpi_theme_customize_register' );
