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
		'header_cta_text'  => esc_html__( 'Request a Consultation', 'gp-industry' ),
		'header_cta_url'   => '#contact',

		/* Hero */
		'hero_badge'       => esc_html__( 'Strategic Workforce & Integrated Facility Solutions', 'gp-industry' ),
		'hero_title'       => 'Recruit Quality Resources, <span>Nurture</span> & Retain',
		'hero_subtitle'    => esc_html__( 'Varunya delivers executive search, HR staffing, 100% statutory payroll compliance, mechanized facilities management, and warehouse logistics workforce solutions across Pan-India.', 'gp-industry' ),
		'hero_btn1_text'   => esc_html__( 'Our Solutions Portfolio', 'gp-industry' ),
		'hero_btn1_url'    => '#services',
		'hero_btn2_text'   => esc_html__( 'Industry Practices', 'gp-industry' ),
		'hero_btn2_url'    => '#industries',
		'hero_bg_1'        => GPI_THEME_URI . '/assets/images/hero-industrial.jpg',
		'hero_bg_2'        => GPI_THEME_URI . '/assets/images/workforce-outsourcing.jpg',
		'hero_bg_3'        => GPI_THEME_URI . '/assets/images/facility-management.jpg',

		/* Features (Talent Portfolio) */
		'features_eyebrow' => esc_html__( 'Our Solutions Portfolio', 'gp-industry' ),
		'features_title'   => esc_html__( 'Comprehensive workforce, staffing and facility operations built for scale', 'gp-industry' ),
		'features_text'    => esc_html__( 'From executive headhunting to 100% statutory payroll compliance and mechanized facility upkeep, we provide dependable enterprise human capital solutions.', 'gp-industry' ),
		'feature_1_icon'   => 'briefcase',
		'feature_1_title'  => esc_html__( 'Executive Search & Leadership', 'gp-industry' ),
		'feature_1_text'   => esc_html__( 'Identifying visionary CXO leaders, senior specialists, and high-impact executives for business transformation.', 'gp-industry' ),
		'feature_2_icon'   => 'shield',
		'feature_2_title'  => esc_html__( 'Staffing & Payroll Compliance', 'gp-industry' ),
		'feature_2_text'   => esc_html__( '100% PF, ESI, EPFO & statutory compliance guarantee with monthly ECR filings and dispute-free audits.', 'gp-industry' ),
		'feature_3_icon'   => 'cpu',
		'feature_3_title'  => esc_html__( 'IT Staff Augmentation', 'gp-industry' ),
		'feature_3_text'   => esc_html__( 'Skilled technology professionals, software architects, and digital specialists available on demand.', 'gp-industry' ),
		'feature_4_icon'   => 'layers',
		'feature_4_title'  => esc_html__( 'Integrated Facilities (IFM)', 'gp-industry' ),
		'feature_4_text'   => esc_html__( 'Mechanized corporate housekeeping, bio-friendly maintenance, hygiene standards, and building upkeep.', 'gp-industry' ),
		'feature_5_icon'   => 'truck',
		'feature_5_title'  => esc_html__( 'Logistics & Warehouse Staffing', 'gp-industry' ),
		'feature_5_text'   => esc_html__( 'Certified forklift & BOPT operators, inventory controllers, and high-velocity dispatch personnel.', 'gp-industry' ),
		'feature_6_icon'   => 'users',
		'feature_6_title'  => esc_html__( 'Functional Practices', 'gp-industry' ),
		'feature_6_text'   => esc_html__( 'Specialised hiring across Finance & Accounts, Sales, Supply Chain, Operations, and Engineering.', 'gp-industry' ),

		/* Stats (Workforce Footprints) */
		'stat_1_number'    => '10+',
		'stat_1_label'     => esc_html__( 'Years Corporate Excellence', 'gp-industry' ),
		'stat_2_number'    => '100%',
		'stat_2_label'     => esc_html__( 'Statutory SLA Compliance', 'gp-industry' ),
		'stat_3_number'    => '4,000,000+',
		'stat_3_label'     => esc_html__( 'Screened Resource Pool', 'gp-industry' ),
		'stat_4_number'    => '24/7',
		'stat_4_label'     => esc_html__( 'Rapid Operations Desk', 'gp-industry' ),

		/* Latest posts */
		'home_posts_eyebrow' => esc_html__( 'Market Insights', 'gp-industry' ),
		'home_posts_title'   => esc_html__( 'Knowledge that helps you hire better', 'gp-industry' ),

		/* CTA */
		'cta_title'        => esc_html__( 'Ready to elevate your workforce with top-tier talent?', 'gp-industry' ),
		'cta_text'         => esc_html__( 'Connect with our specialized recruitment consultants today. We partner with you to source, screen, and secure high-impact professionals tailored to your culture.', 'gp-industry' ),
		'cta_btn_text'     => esc_html__( 'Schedule a Talent Consultation', 'gp-industry' ),
		'cta_btn_url'      => '#contact',

		/* Contact */
		'contact_form_title' => esc_html__( 'Request a Talent & HR Consultation', 'gp-industry' ),
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
 * Intelligent template routing for Products and Services sub-menu child pages.
 * Ensures child pages under Products or Services automatically render the modern
 * B2B single product or single service layout even if template meta was not set manually.
 *
 * @param string $template Current template file.
 * @return string
 */
function gpi_auto_detect_page_template( $template ) {
	if ( is_page() && ! is_front_page() ) {
		$page_id  = get_queried_object_id();
		$assigned = get_post_meta( $page_id, '_wp_page_template', true );

		// If user explicitly chose another custom template that exists, preserve it.
		if ( ! empty( $assigned ) && 'default' !== $assigned ) {
			$found = locate_template( $assigned );
			if ( $found ) {
				return $found;
			}
		}

		$parent_id       = wp_get_post_parent_id( $page_id );
		$parent_slug     = $parent_id ? get_post_field( 'post_name', $parent_id ) : '';
		$parent_title    = $parent_id ? strtolower( get_the_title( $parent_id ) ) : '';
		$parent_template = $parent_id ? get_post_meta( $parent_id, '_wp_page_template', true ) : '';
		$page_slug       = get_post_field( 'post_name', $page_id );
		$page_title      = strtolower( get_the_title( $page_id ) );

		// Product child or product-specific page detection.
		$is_product_child = ( 'products' === $parent_slug || 'page-templates/products.php' === $parent_template || false !== strpos( $parent_title, 'product' ) );
		$is_product_slug  = in_array( $page_slug, array( 'heavy-industrial-machinery', 'precision-cnc-components', 'industrial-automation', 'machinery', 'cnc-components', 'cnc' ), true );
		$is_product_title = ( false !== strpos( $page_title, 'cnc' ) || false !== strpos( $page_title, 'machinery' ) || false !== strpos( $page_title, 'components' ) || false !== strpos( $page_title, 'automation' ) );

		if ( $is_product_child || $is_product_slug || $is_product_title ) {
			$prod_tpl = locate_template( 'page-templates/product-single.php' );
			if ( $prod_tpl ) {
				return $prod_tpl;
			}
		}

		// Service child or service-specific page detection.
		$is_service_child = ( 'services' === $parent_slug || 'page-templates/services.php' === $parent_template || false !== strpos( $parent_title, 'service' ) );
		$is_service_slug  = in_array( $page_slug, array( 'custom-fabrication', 'plant-maintenance', 'engineering-prototyping', 'workforce-outsourcing', 'payroll-statutory-compliance', 'integrated-facility-management' ), true );
		$is_service_title = ( false !== strpos( $page_title, 'fabrication' ) || false !== strpos( $page_title, 'maintenance' ) || false !== strpos( $page_title, 'prototyping' ) || false !== strpos( $page_title, 'engineering' ) || false !== strpos( $page_title, 'consulting' ) || false !== strpos( $page_title, 'outsourcing' ) || false !== strpos( $page_title, 'facility management' ) );

		if ( $is_service_child || $is_service_slug || $is_service_title ) {
			$serv_tpl = locate_template( 'page-templates/service-single.php' );
			if ( $serv_tpl ) {
				return $serv_tpl;
			}
		}
	}

	return $template;
}
add_filter( 'template_include', 'gpi_auto_detect_page_template', 99 );

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
	$clean_path = trim( $path, '/' );

	// 1. Direct lookup by exact path
	$page = get_page_by_path( $clean_path );
	if ( $page && isset( $page->ID ) && 'publish' === $page->post_status ) {
		return get_permalink( $page->ID );
	}

	// 2. Lookup by common slug aliases
	$slug_aliases = array(
		'about-us'                         => array( 'about', 'company', 'about-us', 'about-company' ),
		'about'                            => array( 'about-us', 'about', 'company' ),
		'services'                         => array( 'services', 'our-services', 'solutions' ),
		'products'                         => array( 'products', 'solutions', 'core-solutions', 'services' ),
		'contact'                          => array( 'contact', 'contact-us', 'get-in-touch' ),
		'contact-us'                       => array( 'contact', 'contact-us' ),
		'industries'                       => array( 'industries', 'sectors', 'industry-expertise' ),
		'case-studies'                     => array( 'case-studies', 'projects', 'portfolio' ),
		'projects'                         => array( 'projects', 'case-studies', 'portfolio' ),
		'executive-search'                 => array( 'executive-search', 'leadership' ),
		'it-staff-augmentation'            => array( 'it-staff-augmentation', 'staff-augmentation' ),
		'workforce-outsourcing'            => array( 'workforce-outsourcing', 'staffing' ),
		'payroll-compliance'               => array( 'payroll-compliance', 'payroll-statutory-compliance' ),
		'integrated-facility-management'   => array( 'integrated-facility-management', 'facility-management' ),
		'logistics-warehouse-staffing'     => array( 'logistics-warehouse-staffing', 'warehouse-logistics' ),
	);

	$candidates = isset( $slug_aliases[ $clean_path ] ) ? $slug_aliases[ $clean_path ] : array( basename( $clean_path ) );
	foreach ( $candidates as $candidate_slug ) {
		$found = get_page_by_path( $candidate_slug );
		if ( $found && isset( $found->ID ) && 'publish' === $found->post_status ) {
			return get_permalink( $found->ID );
		}
	}

	// 3. Fallback: Search published pages by keyword in title
	$keyword     = str_replace( '-', ' ', basename( $clean_path ) );
	$query_pages = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			's'              => $keyword,
			'fields'         => 'ids',
		)
	);
	if ( ! empty( $query_pages ) ) {
		return get_permalink( $query_pages[0] );
	}

	// 4. If plain permalinks are in use, never generate /slug/ that causes Apache 500
	if ( ! get_option( 'permalink_structure' ) ) {
		return $fallback ? $fallback : home_url( '/' );
	}

	return $fallback ? $fallback : home_url( '/' . $clean_path . '/' );
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
				return function_exists( 'gpi_protocol_adaptive_url' ) ? gpi_protocol_adaptive_url( $thumb_src ) : $thumb_src;
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
		'consulting'                       => 'custom-fabrication.jpg',
		'consulting-services'              => 'custom-fabrication.jpg',
		'strategy'                         => 'heavy-machinery.jpg',
		'strategic-advisory'               => 'heavy-machinery.jpg',
		'digital-transformation'           => 'industrial-automation.jpg',
		'it-consulting'                    => 'industrial-automation.jpg',
		'products'                         => 'heavy-machinery.jpg',
		'heavy-industrial-machinery'       => 'heavy-machinery.jpg',
		'precision-cnc-components'         => 'precision-components.jpg',
		'industrial-automation'            => 'industrial-automation.jpg',
		'workforce-outsourcing'            => 'workforce-outsourcing.jpg',
		'talent-acquisition'               => 'workforce-outsourcing.jpg',
		'executive-search'                 => 'workforce-outsourcing.jpg',
		'hr-consulting'                    => 'workforce-outsourcing.jpg',
		'payroll-statutory-compliance'     => 'payroll-compliance.jpg',
		'payroll-compliance'               => 'payroll-compliance.jpg',
		'risk-compliance'                  => 'payroll-compliance.jpg',
		'financial-advisory'               => 'payroll-compliance.jpg',
		'integrated-facility-management'   => 'facility-management.jpg',
		'facility-management'              => 'facility-management.jpg',
		'operations-consulting'            => 'facility-management.jpg',
		'services'                         => 'custom-fabrication.jpg',
		'management-consulting'            => 'custom-fabrication.jpg',
		'custom-fabrication'               => 'custom-fabrication.jpg',
		'plant-maintenance'                => 'plant-maintenance.jpg',
		'change-management'                => 'plant-maintenance.jpg',
		'engineering-prototyping'          => 'engineering-cad.jpg',
		'technical-advisory'               => 'engineering-cad.jpg',
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
	if ( false !== strpos( $check_str, 'workforce' ) || false !== strpos( $check_str, 'outsourcing' ) || false !== strpos( $check_str, 'staff' ) || false !== strpos( $check_str, 'talent' ) || false !== strpos( $check_str, 'recruit' ) || false !== strpos( $check_str, 'executive search' ) ) {
		return GPI_THEME_URI . '/assets/images/workforce-outsourcing.jpg';
	}
	if ( false !== strpos( $check_str, 'payroll' ) || false !== strpos( $check_str, 'statutory' ) || false !== strpos( $check_str, 'complian' ) || false !== strpos( $check_str, 'finance' ) || false !== strpos( $check_str, 'tax' ) || false !== strpos( $check_str, 'advisory' ) ) {
		return GPI_THEME_URI . '/assets/images/payroll-compliance.jpg';
	}
	if ( false !== strpos( $check_str, 'facility' ) || false !== strpos( $check_str, 'operation' ) || false !== strpos( $check_str, 'process' ) ) {
		return GPI_THEME_URI . '/assets/images/facility-management.jpg';
	}
	if ( false !== strpos( $check_str, 'strateg' ) || false !== strpos( $check_str, 'machin' ) || false !== strpos( $check_str, 'heavy' ) ) {
		return GPI_THEME_URI . '/assets/images/heavy-machinery.jpg';
	}
	if ( false !== strpos( $check_str, 'analytic' ) || false !== strpos( $check_str, 'data' ) || false !== strpos( $check_str, 'kpi' ) || false !== strpos( $check_str, 'cnc' ) || false !== strpos( $check_str, 'precision' ) || false !== strpos( $check_str, 'component' ) ) {
		return GPI_THEME_URI . '/assets/images/precision-components.jpg';
	}
	if ( false !== strpos( $check_str, 'auto' ) || false !== strpos( $check_str, 'robot' ) || false !== strpos( $check_str, 'digital' ) || false !== strpos( $check_str, 'tech' ) || false !== strpos( $check_str, 'cloud' ) ) {
		return GPI_THEME_URI . '/assets/images/industrial-automation.jpg';
	}
	if ( false !== strpos( $check_str, 'consult' ) || false !== strpos( $check_str, 'fabricat' ) || false !== strpos( $check_str, 'weld' ) || false !== strpos( $check_str, 'service' ) || false !== strpos( $check_str, 'management' ) ) {
		return GPI_THEME_URI . '/assets/images/custom-fabrication.jpg';
	}
	if ( false !== strpos( $check_str, 'partner' ) || false !== strpos( $check_str, 'maint' ) || false !== strpos( $check_str, 'repair' ) || false !== strpos( $check_str, 'change' ) ) {
		return GPI_THEME_URI . '/assets/images/plant-maintenance.jpg';
	}
	if ( false !== strpos( $check_str, 'eng' ) || false !== strpos( $check_str, 'cad' ) || false !== strpos( $check_str, 'prototyp' ) || false !== strpos( $check_str, 'architect' ) ) {
		return GPI_THEME_URI . '/assets/images/engineering-cad.jpg';
	}
	if ( false !== strpos( $check_str, 'project' ) || false !== strpos( $check_str, 'case' ) || false !== strpos( $check_str, 'success' ) ) {
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
	$about_url      = gpi_get_page_link_by_path( 'about-us', home_url( '/#about' ) );
	$products_url   = gpi_get_page_link_by_path( 'products', home_url( '/#products' ) );
	$services_url   = gpi_get_page_link_by_path( 'services', home_url( '/#products' ) );
	$industries_url = gpi_get_page_link_by_path( 'industries', home_url( '/#industries' ) );
	$projects_url   = gpi_get_page_link_by_path( 'case-studies', home_url( '/#features' ) );
	$contact_url    = gpi_get_page_link_by_path( 'contact', home_url( '/#contact' ) );

	$machinery_url   = gpi_get_page_link_by_path( 'heavy-industrial-machinery', home_url( '/#products' ) );
	$cnc_url         = gpi_get_page_link_by_path( 'precision-cnc-components', home_url( '/#products' ) );
	$automation_url  = gpi_get_page_link_by_path( 'industrial-automation', home_url( '/#products' ) );

	$fabrication_url = gpi_get_page_link_by_path( 'workforce-outsourcing', home_url( '/#products' ) );
	$maintenance_url = gpi_get_page_link_by_path( 'payroll-compliance', home_url( '/#products' ) );
	$engineering_url = gpi_get_page_link_by_path( 'integrated-facility-management', home_url( '/#products' ) );
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

/**
 * Handle direct requests to /favicon.ico and /favicon.svg to prevent 500 Internal Server Error
 * when WordPress tries to rewrite missing root favicon requests.
 */
function gpi_handle_favicon_fallback() {
	$uri  = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
	$path = wp_parse_url( $uri, PHP_URL_PATH );
	if ( '/favicon.ico' === $path || '/favicon.svg' === $path ) {
		$svg_file = GPI_THEME_DIR . '/assets/images/favicon.svg';
		$ico_file = GPI_THEME_DIR . '/favicon.ico';
		if ( '/favicon.ico' === $path && file_exists( $ico_file ) ) {
			header( 'Content-Type: image/x-icon' );
			header( 'Cache-Control: public, max-age=604800' );
			readfile( $ico_file );
			exit;
		} elseif ( file_exists( $svg_file ) ) {
			header( 'Content-Type: image/svg+xml' );
			header( 'Cache-Control: public, max-age=604800' );
			readfile( $svg_file );
			exit;
		}
	}
}
add_action( 'init', 'gpi_handle_favicon_fallback', 1 );
add_action( 'do_faviconico', 'gpi_handle_favicon_fallback', 1 );

/**
 * Output favicon and view transition opt-in/suppression for wp-admin and login screens.
 */
function gpi_admin_and_login_head_assets() {
	if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) {
		echo '<link rel="icon" type="image/svg+xml" href="' . esc_url( get_template_directory_uri() . '/assets/images/favicon.svg' ) . '">' . "\n";
		echo '<link rel="alternate icon" type="image/x-icon" href="' . esc_url( get_template_directory_uri() . '/favicon.ico' ) . '">' . "\n";
	}
}
/**
 * Output early promise safety script at priority 0 before any other scripts run.
 */
function gpi_print_early_safety_script() {
	?>
	<script>
	(function(){
		window.addEventListener('unhandledrejection', function(e) {
			if (e && e.reason) {
				var msg = (e.reason.message || e.reason.name || String(e.reason)).toLowerCase();
				if (msg.indexOf('transition') !== -1 || e.reason.name === 'InvalidStateError') {
					e.preventDefault();
				}
			}
		});
	})();
	</script>
	<?php
}
add_action( 'admin_print_scripts', 'gpi_print_early_safety_script', 0 );
add_action( 'wp_print_scripts', 'gpi_print_early_safety_script', 0 );
add_action( 'admin_head', 'gpi_admin_and_login_head_assets' );
add_action( 'login_head', 'gpi_admin_and_login_head_assets' );

/**
 * Automatically place physical favicon.ico in WordPress root if root is writable.
 */
function gpi_ensure_root_favicon() {
	if ( defined( 'ABSPATH' ) && ! file_exists( ABSPATH . 'favicon.ico' ) && is_writable( ABSPATH ) ) {
		$theme_ico = GPI_THEME_DIR . '/favicon.ico';
		if ( file_exists( $theme_ico ) ) {
			@copy( $theme_ico, ABSPATH . 'favicon.ico' );
		}
	}
}
add_action( 'after_switch_theme', 'gpi_ensure_root_favicon' );
add_action( 'admin_init', 'gpi_ensure_root_favicon' );

/**
 * Render universal FAQ section at the end of every page before the footer.
 */
function gpi_render_global_faq() {
	if ( ! empty( $GLOBALS['gpi_faq_rendered'] ) ) {
		return;
	}
	if ( is_404() ) {
		return;
	}
	$GLOBALS['gpi_faq_rendered'] = true;

	$faqs = array(
		array(
			__( 'How quickly can specialized resources and consulting teams be deployed?', 'gp-industry' ),
			__( 'Our standard talent deployment and consulting rollouts go live within 7–10 business days across Pan-India, including role calibration, background verification, and SOP onboarding.', 'gp-industry' ),
		),
		array(
			__( 'How do you guarantee 100% statutory and regulatory compliance?', 'gp-industry' ),
			__( 'We operate strict compliance governance covering EPFO, ESIC, Professional Tax, Labour Welfare Fund, and GST. Monthly ECR challans, payment bank proofs, and audit dossiers are shared directly with client finance teams with zero deviation.', 'gp-industry' ),
		),
		array(
			__( 'What is your candidate vetting, testing, and profiling methodology?', 'gp-industry' ),
			__( 'Every professional undergoes a structured 4-tier assessment: functional capability evaluation, psychometric behavioral profiling, credential and KYC verification, and culture-fit alignment prior to client dossier presentation.', 'gp-industry' ),
		),
		array(
			__( 'Can you support multi-location enterprise operations across India?', 'gp-industry' ),
			__( 'Yes. We manage operations across Delhi NCR, Haryana, Uttar Pradesh, Uttarakhand, Maharashtra, and 25+ major hubs through localized resource networks and 24/7 key account management.', 'gp-industry' ),
		),
		array(
			__( 'What engagement and commercial models do you offer?', 'gp-industry' ),
			__( 'We offer flexible client-centric engagement models: Turnkey Consulting SOWs, Executive Search Retainers, Managed Staff Augmentation, and SLA-linked operational retainers.', 'gp-industry' ),
		),
	);

	// Customizer override if set
	$custom_items = gpi_get_option( 'home_faq_items' );
	if ( $custom_items ) {
		$parsed = gpi_parse_lines( $custom_items, 2 );
		if ( ! empty( $parsed ) ) {
			$faqs = $parsed;
		}
	}
	?>
	<section id="faq" class="global-faq-section section-pad" data-reveal>
		<div class="nova-container">
			<div class="section-heading align-center" data-reveal>
				<span class="section-eyebrow">
					<?php gpi_the_icon( 'target', 14 ); ?>
					<?php esc_html_e( 'Frequently Asked Questions', 'gp-industry' ); ?>
				</span>
				<h2 class="section-title"><?php esc_html_e( 'Frequently Asked Questions', 'gp-industry' ); ?></h2>
				<p class="section-text"><?php esc_html_e( 'Clear answers about our consulting processes, deployment timelines, regulatory governance, and enterprise delivery standards.', 'gp-industry' ); ?></p>
			</div>

			<div class="global-faq-wrapper" data-reveal data-reveal-delay="100">
				<?php foreach ( $faqs as $i => $faq ) : ?>
					<details class="global-faq-card"<?php echo 0 === $i ? ' open' : ''; ?>>
						<summary class="global-faq-header">
							<span class="global-faq-step"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
							<span class="global-faq-question"><?php echo esc_html( $faq[0] ); ?></span>
							<span class="global-faq-toggle" aria-hidden="true"><?php gpi_the_icon( 'arrow-down', 16 ); ?></span>
						</summary>
						<div class="global-faq-body">
							<p><?php echo esc_html( $faq[1] ); ?></p>
						</div>
					</details>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php
}

/**
 * Format and beautify post content for detail pages:
 * - Strips redundant embedded FAQ blocks so FAQ doesn't duplicate in tab
 * - Converts lifecycle/process steps (h3 + p pairs) into modern executive cards.
 *
 * @return string Filtered HTML.
 */
function gpi_get_enhanced_detail_content() {
	$raw = get_the_content();

	// Strip inline duplicate FAQ patterns or blocks
	$clean = preg_replace( '/<!--\s*wp:pattern\s*\{"slug":"gp-industry\/faq"\}\s*\/-->/s', '', $raw );
	$clean = preg_replace( '/<!--\s*wp:group\s*\{"className":"nova-section-faq[^"]*"\}.*?<!--\s*\/wp:group\s*-->/is', '', $clean );
	$clean = preg_replace( '/<section[^>]*id="faq"[^>]*>.*?<\/section>/is', '', $clean );
	$clean = preg_replace( '/<div[^>]*class="[^"]*nova-faq[^"]*"[^>]*>.*?<\/div>\s*<\/div>/is', '', $clean );
	$clean = preg_replace( '/<div[^>]*class="[^"]*wp-block-group nova-faq[^"]*"[^>]*>.*?<\/div>/is', '', $clean );

	$html = apply_filters( 'the_content', $clean );

	// Detect consecutive <h3>...</h3><p>...</p> blocks and wrap them into executive cards
	if ( preg_match_all( '/<h3>(.*?)<\/h3>\s*<p>(.*?)<\/p>/is', $html, $matches, PREG_SET_ORDER ) && count( $matches ) >= 2 ) {
		$cards_html = '<div class="exec-lifecycle-section" data-reveal>';
		$cards_html .= '<div class="exec-lifecycle-heading">';
		$cards_html .= '<span class="section-eyebrow">' . gpi_icon( 'target', 14 ) . ' ' . esc_html__( 'Execution & Delivery Methodology', 'gp-industry' ) . '</span>';
		$cards_html .= '<h3 class="exec-lifecycle-title">' . esc_html__( 'Rigorous Quality & Onboarding Framework', 'gp-industry' ) . '</h3>';
		$cards_html .= '</div>';
		$cards_html .= '<div class="exec-lifecycle-grid">';

		$icons = array( 'target', 'shield-check', 'users', 'award', 'cog', 'chart' );
		foreach ( $matches as $idx => $m ) {
			$title = wp_strip_all_tags( $m[1] );
			$desc  = wp_strip_all_tags( $m[2] );
			$ic    = $icons[ $idx % count( $icons ) ];
			$num   = sprintf( '%02d', $idx + 1 );
			$cards_html .= '<div class="exec-lifecycle-card" data-reveal data-reveal-delay="' . esc_attr( $idx * 80 ) . '">';
			$cards_html .= '<div class="exec-card-top"><span class="exec-step-num">' . esc_html( $num ) . '</span><span class="exec-card-icon">' . gpi_icon( $ic, 22 ) . '</span></div>';
			$cards_html .= '<h4 class="exec-card-title">' . esc_html( $title ) . '</h4>';
			$cards_html .= '<p class="exec-card-desc">' . esc_html( $desc ) . '</p>';
			$cards_html .= '</div>';
		}
		$cards_html .= '</div></div>';

		// Replace the first match with the full grid, and remove the remaining matches
		$first = true;
		$html  = preg_replace_callback( '/<h3>(.*?)<\/h3>\s*<p>(.*?)<\/p>/is', function( $match ) use ( &$first, $cards_html ) {
			if ( $first ) {
				$first = false;
				return $cards_html;
			}
			return '';
		}, $html );
	}

	return $html;
}

/**
 * Automatically strip any inline/embedded FAQ blocks from post content
 * so FAQ never appears in the middle of page content.
 * FAQ is rendered cleanly and universally at the end of every page before the footer.
 *
 * @param string $content Post content HTML.
 * @return string Filtered content.
 */
function gpi_strip_embedded_faq_from_content( $content ) {
	if ( empty( $content ) || ! is_string( $content ) ) {
		return $content;
	}

	// 1. Remove WP block pattern comment
	$content = preg_replace( '/<!--\s*wp:pattern\s*\{"slug":"gp-industry\/faq"\}\s*\/-->/s', '', $content );

	// 2. Remove entire Gutenberg nova-section-faq outer block and all its contents
	$content = preg_replace( '/<!--\s*wp:group\s*\{[^\}]*"nova-section-faq"[^\}]*\}\s*-->[\s\S]*?<!--\s*\/wp:group\s*-->\s*(?:<\/div>\s*<!--\s*\/wp:group\s*-->)?/is', '', $content );

	// 3. Remove standalone Gutenberg section-heading group containing FAQ eyebrow/title
	$content = preg_replace( '/<!--\s*wp:group\s*\{[^\}]*"section-heading[^\}]*"[^\}]*\}\s*-->\s*<div[^>]*class="[^"]*section-heading[^"]*"[^>]*>\s*(?:<!--[\s\S]*?-->\s*)*<p[^>]*class="[^"]*section-eyebrow[^"]*"[^>]*>\s*FAQ\s*<\/p>\s*(?:<!--[\s\S]*?-->\s*)*<h2[^>]*class="[^"]*section-title[^"]*"[^>]*>\s*Frequently\s+asked\s+questions\s*<\/h2>[\s\S]*?<!--\s*\/wp:group\s*-->/is', '', $content );

	// 4. Remove HTML section/div wrapper with nova-section-faq
	$content = preg_replace( '/<div[^>]*class="[^"]*nova-section-faq[^"]*"[^>]*>[\s\S]*?<\/div>\s*(?:<\/div>)?/is', '', $content );
	$content = preg_replace( '/<section[^>]*class="[^"]*nova-section-faq[^"]*"[^>]*>[\s\S]*?<\/section>/is', '', $content );
	$content = preg_replace( '/<section[^>]*id="faq"[^>]*>[\s\S]*?<\/section>/is', '', $content );

	// 5. Remove HTML section-heading container containing FAQ and Frequently asked questions
	$content = preg_replace( '/<div[^>]*class="[^"]*section-heading[^"]*"[^>]*>\s*(?:<!--[\s\S]*?-->\s*)*<p[^>]*class="[^"]*section-eyebrow[^"]*"[^>]*>\s*FAQ\s*<\/p>\s*(?:<!--[\s\S]*?-->\s*)*<h2[^>]*class="[^"]*section-title[^"]*"[^>]*>\s*Frequently\s+asked\s+questions\s*<\/h2>(?:\s*<p[^>]*class="[^"]*section-text[^"]*"[^>]*>[\s\S]*?<\/p>)?\s*<\/div>/is', '', $content );

	// 6. Remove any standalone FAQ eyebrow + Frequently asked questions heading pairs or orphan FAQ headings
	$content = preg_replace( '/<p[^>]*class="[^"]*section-eyebrow[^"]*"[^>]*>\s*FAQ\s*<\/p>\s*<h2[^>]*class="[^"]*(?:section-title|wp-block-heading)[^"]*"[^>]*>\s*Frequently\s+asked\s+questions\s*<\/h2>/is', '', $content );
	$content = preg_replace( '/<h2[^>]*class="[^"]*(?:section-title|wp-block-heading)[^"]*"[^>]*>\s*Frequently\s+asked\s+questions\s*<\/h2>/is', '', $content );

	// 7. Remove any inner nova-faq groups or accordion details
	$content = preg_replace( '/<!--\s*wp:group\s*\{[^\}]*"nova-faq"[^\}]*\}\s*-->[\s\S]*?<!--\s*\/wp:group\s*-->/is', '', $content );
	$content = preg_replace( '/<div[^>]*class="[^"]*nova-faq[^"]*"[^>]*>[\s\S]*?<\/div>\s*<\/div>/is', '', $content );
	$content = preg_replace( '/<div[^>]*class="[^"]*wp-block-group\s+nova-faq[^"]*"[^>]*>[\s\S]*?<\/div>/is', '', $content );
	$content = preg_replace( '/<div[^>]*class="[^"]*nova-faq[^"]*"[^>]*>[\s\S]*?<\/div>/is', '', $content );
	$content = preg_replace( '/<details[^>]*class="[^"]*nova-faq-item[^"]*"[^>]*>[\s\S]*?<\/details>/is', '', $content );

	return $content;
}
add_filter( 'the_content', 'gpi_strip_embedded_faq_from_content', 9 );
add_filter( 'the_content', 'gpi_strip_embedded_faq_from_content', 999 );





