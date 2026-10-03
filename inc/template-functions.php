<?php
/**
 * Functions that hook into WordPress to alter default behaviour.
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get a theme option (thin wrapper around get_theme_mod with defaults).
 *
 * @param string $key     Option key (without the gpi_ prefix).
 * @param mixed  $default Default value.
 * @return mixed
 */
function gpi_get_option( $key, $default = null ) {
	if ( null === $default ) {
		$defaults = gpi_option_defaults();
		$default  = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
	}
	return get_theme_mod( 'gpi_' . $key, $default );
}

/**
 * Default values shared by the Customizer and the templates.
 *
 * @return array
 */
function gpi_option_defaults() {
	static $defaults = null;
	if ( null !== $defaults ) {
		return $defaults;
	}

	$company = get_bloginfo( 'name' );

	$defaults = array(
		/* Header */
		'header_cta_text'  => esc_html__( 'Request a Quote', 'gp-industry' ),
		'header_cta_url'   => '#contact',

		/* Hero */
		'hero_badge'       => esc_html__( 'Precision Engineering & Heavy Manufacturing', 'gp-industry' ),
		'hero_title'       => 'Precision engineering & heavy manufacturing <span>excellence</span>',
		'hero_subtitle'    => esc_html__( 'Turnkey industrial solutions, multi-axis CNC machining, heavy metal fabrication, and advanced automation systems engineered to international standards.', 'gp-industry' ),
		'hero_btn1_text'   => esc_html__( 'Explore Products', 'gp-industry' ),
		'hero_btn1_url'    => '#products',
		'hero_btn2_text'   => esc_html__( 'Our Capabilities', 'gp-industry' ),
		'hero_btn2_url'    => '#services',
		'hero_bg_1'        => GPI_THEME_URI . '/assets/images/hero-industrial.jpg',
		'hero_bg_2'        => GPI_THEME_URI . '/assets/images/heavy-machinery.jpg',
		'hero_bg_3'        => GPI_THEME_URI . '/assets/images/industrial-automation.jpg',

		/* Features */
		'features_eyebrow' => esc_html__( 'Why Choose Us', 'gp-industry' ),
		'features_title'   => esc_html__( 'Built for extreme precision and heavy-duty reliability', 'gp-industry' ),
		'features_text'    => esc_html__( 'From one-off custom engineering prototypes to full-scale production runs, our certified facilities deliver zero-defect quality on schedule.', 'gp-industry' ),
		'feature_1_icon'   => 'cog',
		'feature_1_title'  => esc_html__( '5-Axis CNC Machining', 'gp-industry' ),
		'feature_1_text'   => esc_html__( 'High-speed multi-axis milling and turning with tolerances down to ±0.005 mm.', 'gp-industry' ),
		'feature_2_icon'   => 'shield',
		'feature_2_title'  => esc_html__( 'ISO & ASME Certified', 'gp-industry' ),
		'feature_2_text'   => esc_html__( 'ISO 9001:2015, ISO 14001, CE, and ASME certified manufacturing processes.', 'gp-industry' ),
		'feature_3_icon'   => 'layers',
		'feature_3_title'  => esc_html__( 'Heavy Metal Fabrication', 'gp-industry' ),
		'feature_3_text'   => esc_html__( 'High-tensile structural steel fabrication, submerged arc welding, and pressure vessels.', 'gp-industry' ),
		'feature_4_icon'   => 'bolt',
		'feature_4_title'  => esc_html__( 'Industrial Automation', 'gp-industry' ),
		'feature_4_text'   => esc_html__( 'Turnkey assembly robotics, PLC control panels, and smart Industry 4.0 telemetry.', 'gp-industry' ),
		'feature_5_icon'   => 'chart',
		'feature_5_title'  => esc_html__( '100% Quality & NDT Testing', 'gp-industry' ),
		'feature_5_text'   => esc_html__( 'CMM coordinate inspection, ultrasonic testing, and raw material chemical traceability.', 'gp-industry' ),
		'feature_6_icon'   => 'award',
		'feature_6_title'  => esc_html__( 'Turnkey Project Delivery', 'gp-industry' ),
		'feature_6_text'   => esc_html__( 'End-to-end design, FEA stress simulation, manufacturing, and on-site commissioning.', 'gp-industry' ),

		/* Stats */
		'stat_1_number'    => '25+',
		'stat_1_label'     => esc_html__( 'Years in Heavy Industry', 'gp-industry' ),
		'stat_2_number'    => '150K+',
		'stat_2_label'     => esc_html__( 'Precision Parts Manufactured', 'gp-industry' ),
		'stat_3_number'    => '99.8%',
		'stat_3_label'     => esc_html__( 'Dimensional Precision Rate', 'gp-industry' ),
		'stat_4_number'    => '40+',
		'stat_4_label'     => esc_html__( 'Countries Exported To', 'gp-industry' ),

		/* Latest posts */
		'home_posts_eyebrow' => esc_html__( 'Engineering Insights', 'gp-industry' ),
		'home_posts_title'   => esc_html__( 'Latest manufacturing & technology updates', 'gp-industry' ),

		/* CTA */
		'cta_title'        => esc_html__( 'Ready to build your next industrial engineering project?', 'gp-industry' ),
		'cta_text'         => esc_html__( 'Send us your CAD drawings or technical specifications. Our engineering team provides a detailed RFQ and feasibility report within 24 hours.', 'gp-industry' ),
		'cta_btn_text'     => esc_html__( 'Request a Technical Quotation', 'gp-industry' ),
		'cta_btn_url'      => '#contact',

		/* Contact */
		'contact_form_title' => esc_html__( 'Request an Engineering Quotation (RFQ)', 'gp-industry' ),
	);

	if ( function_exists( 'gpi_home_defaults' ) ) {
		$defaults = array_merge( $defaults, gpi_home_defaults( $company ) );
	}

	return $defaults;
}

/**
 * Whether the current view should show the blog sidebar.
 *
 * @return bool
 */
function gpi_has_sidebar() {
	if ( ! ( is_home() || is_archive() || is_search() ) ) {
		return false;
	}

	return 'sidebar' === gpi_get_option( 'blog_layout', 'grid' ) && is_active_sidebar( 'sidebar-1' );
}

/**
 * Body classes.
 *
 * @param array $classes Body classes.
 * @return array
 */
function gpi_body_classes( $classes ) {
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	$classes[] = gpi_has_sidebar() ? 'has-sidebar' : 'no-sidebar';
	$classes[] = 'header-' . ( 'classic' === gpi_get_option( 'header_style', 'floating' ) ? 'classic' : 'floating' );

	if ( is_singular( 'post' ) ) {
		$classes[] = 'nova-reading';
	}

	if ( is_page_template( array( 'page-templates/full-width.php', 'page-templates/services.php', 'page-templates/about.php', 'page-templates/contact.php', 'page-templates/service-single.php', 'page-templates/products.php', 'page-templates/product-single.php', 'page-templates/auto-design.php', 'page-templates/courses.php', 'page-templates/course-single.php' ) ) ) {
		$classes[] = 'is-full-width';
	}

	return $classes;
}
add_filter( 'body_class', 'gpi_body_classes' );

/**
 * Excerpt length.
 *
 * @param int $length Words.
 * @return int
 */
function gpi_excerpt_length( $length ) {
	if ( is_admin() ) {
		return $length;
	}
	return absint( gpi_get_option( 'excerpt_length', 22 ) );
}
add_filter( 'excerpt_length', 'gpi_excerpt_length' );

/**
 * Excerpt "more" string.
 *
 * @param string $more More string.
 * @return string
 */
function gpi_excerpt_more( $more ) {
	if ( is_admin() ) {
		return $more;
	}
	return '&hellip;';
}
add_filter( 'excerpt_more', 'gpi_excerpt_more' );

/**
 * Add a pingback URL for singularly identifiable articles.
 */
function gpi_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'gpi_pingback_header' );

/**
 * Add a submenu toggle button to menu items with children (primary menu only).
 *
 * @param string   $item_output Item HTML.
 * @param WP_Post  $item        Menu item.
 * @param int      $depth       Depth.
 * @param stdClass $args        Args.
 * @return string
 */
function gpi_submenu_toggle( $item_output, $item, $depth, $args ) {
	if ( isset( $args->theme_location ) && 'primary-menu' === $args->theme_location && in_array( 'menu-item-has-children', (array) $item->classes, true ) ) {
		$item_output .= sprintf(
			'<button class="submenu-toggle" aria-expanded="false" aria-label="%s">%s</button>',
			esc_attr__( 'Toggle submenu', 'gp-industry' ),
			gpi_icon( 'chevron-down', 16 )
		);
	}
	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'gpi_submenu_toggle', 10, 4 );

/**
 * Lighten or darken a hex color.
 *
 * @param string $hex   Hex color.
 * @param int    $steps -255..255.
 * @return string
 */
function gpi_adjust_brightness( $hex, $steps ) {
	$hex = ltrim( $hex, '#' );
	if ( 3 === strlen( $hex ) ) {
		$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
	}
	$out = '#';
	foreach ( str_split( $hex, 2 ) as $part ) {
		$v    = max( 0, min( 255, hexdec( $part ) + $steps ) );
		$out .= str_pad( dechex( $v ), 2, '0', STR_PAD_LEFT );
	}
	return $out;
}

/**
 * Convert hex color to "r, g, b".
 *
 * @param string $hex Hex color.
 * @return string
 */
function gpi_hex_to_rgb( $hex ) {
	$hex = ltrim( $hex, '#' );
	if ( 3 === strlen( $hex ) ) {
		$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
	}
	if ( 6 !== strlen( $hex ) ) {
		return '99, 102, 241';
	}
	return implode( ', ', array_map( 'hexdec', str_split( $hex, 2 ) ) );
}

/**
 * Validate a hex color, returning a fallback when invalid.
 *
 * @param string $color    Color.
 * @param string $fallback Fallback.
 * @return string
 */
function gpi_sanitize_hex( $color, $fallback ) {
	$color = trim( (string) $color );
	return preg_match( '/^#([A-Fa-f0-9]{3}){1,2}$/', $color ) ? $color : $fallback;
}

/**
 * Allowed HTML for the hero title (lets users wrap words in <span> / <br>).
 *
 * @return array
 */
function gpi_hero_allowed_html() {
	return array(
		'span'   => array( 'class' => array() ),
		'br'     => array(),
		'strong' => array(),
		'em'     => array(),
	);
}

/**
 * Estimated reading time for a post.
 *
 * @param int|null $post_id Post ID.
 * @return int Minutes.
 */
function gpi_reading_time( $post_id = null ) {
	$content = get_post_field( 'post_content', $post_id );
	$text    = trim( wp_strip_all_tags( strip_shortcodes( $content ) ) );
	$words   = $text ? count( preg_split( '/\s+/u', $text, -1, PREG_SPLIT_NO_EMPTY ) ) : 0;
	return max( 1, (int) ceil( $words / 200 ) );
}

/**
 * Comment form field tweaks: placeholders and modern layout.
 *
 * @param array $fields Fields.
 * @return array
 */
function gpi_comment_form_fields( $fields ) {
	$commenter = wp_get_current_commenter();
	$req       = get_option( 'require_name_email' );
	$aria      = $req ? ' aria-required="true" required' : '';

	$fields['author'] = '<p class="comment-form-author"><label for="author">' . esc_html__( 'Name', 'gp-industry' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" placeholder="' . esc_attr__( 'Your name', 'gp-industry' ) . '"' . $aria . '></p>';
	$fields['email']  = '<p class="comment-form-email"><label for="email">' . esc_html__( 'Email', 'gp-industry' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label><input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" placeholder="' . esc_attr__( 'you@example.com', 'gp-industry' ) . '"' . $aria . '></p>';
	$fields['url']    = '<p class="comment-form-url"><label for="url">' . esc_html__( 'Website', 'gp-industry' ) . '</label><input id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" placeholder="https://"></p>';

	return $fields;
}
add_filter( 'comment_form_default_fields', 'gpi_comment_form_fields' );

/**
 * Comment form defaults.
 *
 * @param array $defaults Defaults.
 * @return array
 */
function gpi_comment_form_defaults( $defaults ) {
	$defaults['comment_field']        = '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Comment', 'gp-industry' ) . ' <span class="required">*</span></label><textarea id="comment" name="comment" rows="6" placeholder="' . esc_attr__( 'Share your thoughts…', 'gp-industry' ) . '" aria-required="true" required></textarea></p>';
	$defaults['class_submit']         = 'btn btn-primary';
	$defaults['title_reply']          = esc_html__( 'Leave a comment', 'gp-industry' );
	$defaults['title_reply_before']   = '<h3 id="reply-title" class="comment-reply-title">';
	$defaults['title_reply_after']    = '</h3>';
	$defaults['comment_notes_before'] = '<p class="comment-notes">' . esc_html__( 'Your email address will not be published.', 'gp-industry' ) . '</p>';
	return $defaults;
}
add_filter( 'comment_form_defaults', 'gpi_comment_form_defaults' );

/**
 * Wrap oEmbeds/iframes for responsive sizing in the content.
 *
 * @param string $html Embed HTML.
 * @return string
 */
function gpi_wrap_embed( $html ) {
	return '<div class="nova-embed">' . $html . '</div>';
}
add_filter( 'embed_oembed_html', 'gpi_wrap_embed', 10, 1 );

/**
 * Register Gutenberg block styles.
 */
function gpi_register_block_styles() {
	if ( ! function_exists( 'register_block_style' ) ) {
		return;
	}

	register_block_style(
		'core/button',
		array(
			'name'  => 'nova-gradient',
			'label' => esc_html__( 'Gradient', 'gp-industry' ),
		)
	);

	register_block_style(
		'core/button',
		array(
			'name'  => 'nova-light',
			'label' => esc_html__( 'Light (for gradient backgrounds)', 'gp-industry' ),
		)
	);

	register_block_style(
		'core/group',
		array(
			'name'  => 'nova-card',
			'label' => esc_html__( 'Card', 'gp-industry' ),
		)
	);

	register_block_style(
		'core/quote',
		array(
			'name'  => 'nova-highlight',
			'label' => esc_html__( 'Highlight', 'gp-industry' ),
		)
	);
}
add_action( 'init', 'gpi_register_block_styles' );

/**
 * Preload the first hero slide on the front page for a faster LCP.
 */
function gpi_preload_hero_slide() {
	if ( ! is_front_page() || ! gpi_get_option( 'show_hero', true ) || ! gpi_get_option( 'hero_slider_enable', true ) ) {
		return;
	}
	$first = gpi_get_option( 'hero_bg_1', '' );
	if ( $first ) {
		printf( '<link rel="preload" as="image" href="%s" fetchpriority="high">' . "\n", esc_url( $first ) );
	}
}
add_action( 'wp_head', 'gpi_preload_hero_slide', 2 );

/**
 * Helper to get a page permalink by path/slug, falling back to a given URL.
 *
 * @param string $path Page path/slug.
 * @param string $fallback Fallback URL.
 * @return string
 */
function gpi_get_page_link_by_path( $path, $fallback = '' ) {
	$page = get_page_by_path( $path );
	if ( $page && isset( $page->ID ) && 'publish' === $page->post_status ) {
		return get_permalink( $page->ID );
	}
	return $fallback ? $fallback : home_url( '/' . trim( $path, '/' ) . '/' );
}

/**
 * Get an appropriate industrial image URL for a given page or post.
 * Checks post thumbnail first, then maps post slug to bundled assets/images/.
 *
 * @param int $post_id Post ID (defaults to current post).
 * @return string Image URL or empty string.
 */
function gpi_get_page_image_url( $post_id = 0 ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}
	if ( $post_id && has_post_thumbnail( $post_id ) ) {
		$thumb_id   = get_post_thumbnail_id( $post_id );
		$thumb_post = $thumb_id ? get_post( $thumb_id ) : null;
		$thumb_name = $thumb_post ? $thumb_post->post_name : '';
		$thumb_src  = wp_get_attachment_image_url( $thumb_id, 'full' );

		// Only accept if it is NOT a synthetic GD demo image
		if ( false === strpos( $thumb_name, 'gpi-demo-' ) && false === strpos( (string) $thumb_src, 'gpi-demo-' ) ) {
			if ( $thumb_src ) {
				return $thumb_src;
			}
		}
	}

	$post  = get_post( $post_id );
	$slug  = $post ? $post->post_name : '';
	$title = $post ? strtolower( $post->post_title ) : '';

	$mapping = array(
		'home'                             => 'hero-industrial.jpg',
		'about-us'                         => 'about-facility.jpg',
		'about'                            => 'about-facility.jpg',
		'products'                         => 'heavy-machinery.jpg',
		'heavy-industrial-machinery'       => 'heavy-machinery.jpg',
		'precision-cnc-components'         => 'precision-components.jpg',
		'industrial-automation'            => 'industrial-automation.jpg',
		'workforce-outsourcing'            => 'workforce-outsourcing.jpg',
		'payroll-statutory-compliance'     => 'payroll-compliance.jpg',
		'payroll-compliance'               => 'payroll-compliance.jpg',
		'integrated-facility-management'   => 'facility-management.jpg',
		'facility-management'              => 'facility-management.jpg',
		'services'                         => 'custom-fabrication.jpg',
		'custom-fabrication'               => 'custom-fabrication.jpg',
		'plant-maintenance'                => 'plant-maintenance.jpg',
		'engineering-prototyping'          => 'engineering-cad.jpg',
		'industries'                       => 'industries-sectors.jpg',
		'case-studies'                     => 'case-studies-projects.jpg',
		'projects'                         => 'case-studies-projects.jpg',
		'contact'                          => 'contact-facility.jpg',
		'contact-us'                       => 'contact-facility.jpg',
	);

	if ( $slug && isset( $mapping[ $slug ] ) ) {
		$file = $mapping[ $slug ];
		if ( file_exists( GPI_THEME_DIR . '/assets/images/' . $file ) ) {
			return GPI_THEME_URI . '/assets/images/' . $file;
		}
	}

	// Keyword match fallbacks for slug or title
	$check_str = $slug . ' ' . $title;
	if ( false !== strpos( $check_str, 'workforce' ) || false !== strpos( $check_str, 'outsourcing' ) || false !== strpos( $check_str, 'staff' ) ) {
		return GPI_THEME_URI . '/assets/images/workforce-outsourcing.jpg';
	}
	if ( false !== strpos( $check_str, 'payroll' ) || false !== strpos( $check_str, 'statutory' ) || false !== strpos( $check_str, 'complian' ) ) {
		return GPI_THEME_URI . '/assets/images/payroll-compliance.jpg';
	}
	if ( false !== strpos( $check_str, 'facility' ) || false !== strpos( $check_str, 'integrated facility' ) ) {
		return GPI_THEME_URI . '/assets/images/facility-management.jpg';
	}
	if ( false !== strpos( $check_str, 'machin' ) || false !== strpos( $check_str, 'heavy' ) ) {
		return GPI_THEME_URI . '/assets/images/heavy-machinery.jpg';
	}
	if ( false !== strpos( $check_str, 'cnc' ) || false !== strpos( $check_str, 'precision' ) || false !== strpos( $check_str, 'component' ) ) {
		return GPI_THEME_URI . '/assets/images/precision-components.jpg';
	}
	if ( false !== strpos( $check_str, 'auto' ) || false !== strpos( $check_str, 'robot' ) ) {
		return GPI_THEME_URI . '/assets/images/industrial-automation.jpg';
	}
	if ( false !== strpos( $check_str, 'fabricat' ) || false !== strpos( $check_str, 'weld' ) || false !== strpos( $check_str, 'service' ) ) {
		return GPI_THEME_URI . '/assets/images/custom-fabrication.jpg';
	}
	if ( false !== strpos( $check_str, 'maint' ) || false !== strpos( $check_str, 'repair' ) ) {
		return GPI_THEME_URI . '/assets/images/plant-maintenance.jpg';
	}
	if ( false !== strpos( $check_str, 'eng' ) || false !== strpos( $check_str, 'cad' ) || false !== strpos( $check_str, 'prototyp' ) ) {
		return GPI_THEME_URI . '/assets/images/engineering-cad.jpg';
	}
	if ( false !== strpos( $check_str, 'project' ) || false !== strpos( $check_str, 'case' ) ) {
		return GPI_THEME_URI . '/assets/images/case-studies-projects.jpg';
	}
	if ( false !== strpos( $check_str, 'contact' ) ) {
		return GPI_THEME_URI . '/assets/images/contact-facility.jpg';
	}

	if ( is_front_page() ) {
		return GPI_THEME_URI . '/assets/images/hero-industrial.jpg';
	}

	return GPI_THEME_URI . '/assets/images/about-facility.jpg';
}

/**
 * Render card image tag with automatic fallback to bundled photography.
 * Bypasses synthetic GD demo images.
 *
 * @param int    $post_id Post ID.
 * @param string $size    Thumbnail size.
 * @param string $icon    Fallback icon name.
 * @param string $class   CSS class for img tag.
 */
function gpi_the_card_media( $post_id = 0, $size = 'nova-card', $icon = 'package', $class = 'service-card-img' ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$has_real_thumb = false;
	if ( has_post_thumbnail( $post_id ) ) {
		$thumb_id   = get_post_thumbnail_id( $post_id );
		$thumb_post = $thumb_id ? get_post( $thumb_id ) : null;
		$thumb_name = $thumb_post ? $thumb_post->post_name : '';
		$thumb_src  = wp_get_attachment_image_url( $thumb_id, 'full' );

		if ( false === strpos( $thumb_name, 'gpi-demo-' ) && false === strpos( (string) $thumb_src, 'gpi-demo-' ) ) {
			$has_real_thumb = true;
		}
	}

	if ( $has_real_thumb ) {
		echo get_the_post_thumbnail( $post_id, $size, array( 'loading' => 'lazy', 'class' => $class ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		return;
	}

	$img_url = gpi_get_page_image_url( $post_id );
	if ( $img_url ) {
		echo '<img src="' . esc_url( $img_url ) . '" alt="' . the_title_attribute( array( 'echo' => false, 'post' => $post_id ) ) . '" loading="lazy" class="' . esc_attr( $class ) . '">';
	} else {
		echo '<span class="service-card-icon">' . gpi_icon( $icon, 26 ) . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

/**
 * Clean, branded navigation fallback that renders GP-Industry's structure
 * instead of arbitrary WordPress database pages from a previous theme.
 */
function gpi_primary_nav_fallback() {
	$home_url       = home_url( '/' );
	$about_url      = gpi_get_page_link_by_path( 'about-us', home_url( '/about-us/' ) );
	$products_url   = gpi_get_page_link_by_path( 'products', home_url( '/products/' ) );
	$services_url   = gpi_get_page_link_by_path( 'services', home_url( '/services/' ) );
	$industries_url = gpi_get_page_link_by_path( 'industries', home_url( '/industries/' ) );
	$projects_url   = gpi_get_page_link_by_path( 'case-studies', home_url( '/case-studies/' ) );
	$contact_url    = gpi_get_page_link_by_path( 'contact', home_url( '/contact/' ) );

	$machinery_url   = gpi_get_page_link_by_path( 'products/heavy-industrial-machinery', home_url( '/products/heavy-industrial-machinery/' ) );
	$cnc_url         = gpi_get_page_link_by_path( 'products/precision-cnc-components', home_url( '/products/precision-cnc-components/' ) );
	$automation_url  = gpi_get_page_link_by_path( 'products/industrial-automation', home_url( '/products/industrial-automation/' ) );

	$fabrication_url = gpi_get_page_link_by_path( 'services/custom-fabrication', home_url( '/services/custom-fabrication/' ) );
	$maintenance_url = gpi_get_page_link_by_path( 'services/plant-maintenance', home_url( '/services/plant-maintenance/' ) );
	$engineering_url = gpi_get_page_link_by_path( 'services/engineering-prototyping', home_url( '/services/engineering-prototyping/' ) );
	?>
	<ul id="primary-menu" class="nav-menu">
		<li class="menu-item<?php echo is_front_page() ? ' current-menu-item' : ''; ?>">
			<a href="<?php echo esc_url( $home_url ); ?>"><?php esc_html_e( 'Home', 'gp-industry' ); ?></a>
		</li>
		<li class="menu-item<?php echo is_page( 'about-us' ) ? ' current-menu-item' : ''; ?>">
			<a href="<?php echo esc_url( $about_url ); ?>"><?php esc_html_e( 'About Us', 'gp-industry' ); ?></a>
		</li>
		<li class="menu-item menu-item-has-children<?php echo is_page( 'products' ) ? ' current-menu-item' : ''; ?>">
			<a href="<?php echo esc_url( $products_url ); ?>"><?php esc_html_e( 'Products', 'gp-industry' ); ?></a>
			<button class="submenu-toggle" type="button" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle submenu', 'gp-industry' ); ?>"><?php gpi_the_icon( 'chevron-down', 16 ); ?></button>
			<ul class="sub-menu">
				<li><a href="<?php echo esc_url( $machinery_url ); ?>"><?php esc_html_e( 'Heavy Industrial Machinery', 'gp-industry' ); ?></a></li>
				<li><a href="<?php echo esc_url( $cnc_url ); ?>"><?php esc_html_e( 'Precision CNC Components', 'gp-industry' ); ?></a></li>
				<li><a href="<?php echo esc_url( $automation_url ); ?>"><?php esc_html_e( 'Industrial Automation', 'gp-industry' ); ?></a></li>
			</ul>
		</li>
		<li class="menu-item menu-item-has-children<?php echo is_page( 'services' ) ? ' current-menu-item' : ''; ?>">
			<a href="<?php echo esc_url( $services_url ); ?>"><?php esc_html_e( 'Services', 'gp-industry' ); ?></a>
			<button class="submenu-toggle" type="button" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle submenu', 'gp-industry' ); ?>"><?php gpi_the_icon( 'chevron-down', 16 ); ?></button>
			<ul class="sub-menu">
				<li><a href="<?php echo esc_url( $fabrication_url ); ?>"><?php esc_html_e( 'Custom Metal Fabrication', 'gp-industry' ); ?></a></li>
				<li><a href="<?php echo esc_url( $maintenance_url ); ?>"><?php esc_html_e( 'Plant Maintenance & Overhaul', 'gp-industry' ); ?></a></li>
				<li><a href="<?php echo esc_url( $engineering_url ); ?>"><?php esc_html_e( 'Engineering & Prototyping', 'gp-industry' ); ?></a></li>
			</ul>
		</li>
		<li class="menu-item<?php echo is_page( 'industries' ) ? ' current-menu-item' : ''; ?>">
			<a href="<?php echo esc_url( $industries_url ); ?>"><?php esc_html_e( 'Industries', 'gp-industry' ); ?></a>
		</li>
		<li class="menu-item<?php echo is_page( 'case-studies' ) ? ' current-menu-item' : ''; ?>">
			<a href="<?php echo esc_url( $projects_url ); ?>"><?php esc_html_e( 'Projects', 'gp-industry' ); ?></a>
		</li>
		<li class="menu-item<?php echo is_page( 'contact' ) ? ' current-menu-item' : ''; ?>">
			<a href="<?php echo esc_url( $contact_url ); ?>"><?php esc_html_e( 'Contact', 'gp-industry' ); ?></a>
		</li>
	</ul>
	<?php
}

/**
 * Footer navigation fallback.
 */
function gpi_footer_nav_fallback() {
	$home_url       = home_url( '/' );
	$about_url      = gpi_get_page_link_by_path( 'about-us', home_url( '/about-us/' ) );
	$products_url   = gpi_get_page_link_by_path( 'products', home_url( '/products/' ) );
	$services_url   = gpi_get_page_link_by_path( 'services', home_url( '/services/' ) );
	$industries_url = gpi_get_page_link_by_path( 'industries', home_url( '/industries/' ) );
	$projects_url   = gpi_get_page_link_by_path( 'case-studies', home_url( '/case-studies/' ) );
	$contact_url    = gpi_get_page_link_by_path( 'contact', home_url( '/contact/' ) );
	?>
	<ul class="footer-menu">
		<li><a href="<?php echo esc_url( $home_url ); ?>"><?php esc_html_e( 'Home', 'gp-industry' ); ?></a></li>
		<li><a href="<?php echo esc_url( $about_url ); ?>"><?php esc_html_e( 'About Us', 'gp-industry' ); ?></a></li>
		<li><a href="<?php echo esc_url( $products_url ); ?>"><?php esc_html_e( 'Products', 'gp-industry' ); ?></a></li>
		<li><a href="<?php echo esc_url( $services_url ); ?>"><?php esc_html_e( 'Services', 'gp-industry' ); ?></a></li>
		<li><a href="<?php echo esc_url( $industries_url ); ?>"><?php esc_html_e( 'Industries', 'gp-industry' ); ?></a></li>
		<li><a href="<?php echo esc_url( $projects_url ); ?>"><?php esc_html_e( 'Projects', 'gp-industry' ); ?></a></li>
		<li><a href="<?php echo esc_url( $contact_url ); ?>"><?php esc_html_e( 'Contact', 'gp-industry' ); ?></a></li>
	</ul>
	<?php
}
