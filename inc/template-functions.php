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

	$defaults = array(
		'feature_1_icon'  => 'award',
		'feature_1_title' => esc_html__( 'Certified Quality', 'gp-industry' ),
		'feature_1_text'  => esc_html__( 'ISO-certified processes with 100% inspection before every dispatch.', 'gp-industry' ),
		'feature_2_icon'  => 'cog',
		'feature_2_title' => esc_html__( 'Advanced Machinery', 'gp-industry' ),
		'feature_2_text'  => esc_html__( 'CNC, automated lines and modern tooling for precision at scale.', 'gp-industry' ),
		'feature_3_icon'  => 'truck',
		'feature_3_title' => esc_html__( 'On-time Delivery', 'gp-industry' ),
		'feature_3_text'  => esc_html__( 'Robust logistics and inventory planning keep your production moving.', 'gp-industry' ),
		'feature_4_icon'  => 'hardhat',
		'feature_4_title' => esc_html__( 'Safety First', 'gp-industry' ),
		'feature_4_text'  => esc_html__( 'Zero-compromise safety standards across every plant and site.', 'gp-industry' ),
		'feature_5_icon'  => 'users',
		'feature_5_title' => esc_html__( 'Skilled Workforce', 'gp-industry' ),
		'feature_5_text'  => esc_html__( 'Experienced engineers and technicians with decades of industry know-how.', 'gp-industry' ),
		'feature_6_icon'  => 'leaf',
		'feature_6_title' => esc_html__( 'Sustainable Practices', 'gp-industry' ),
		'feature_6_text'  => esc_html__( 'Energy-efficient production and responsible waste management.', 'gp-industry' ),
		'stat_1_number'   => '25+',
		'stat_1_label'    => esc_html__( 'Years in business', 'gp-industry' ),
		'stat_2_number'   => '500+',
		'stat_2_label'    => esc_html__( 'Clients served', 'gp-industry' ),
		'stat_3_number'   => '10K+',
		'stat_3_label'    => esc_html__( 'Projects delivered', 'gp-industry' ),
		'stat_4_number'   => '40+',
		'stat_4_label'    => esc_html__( 'Countries supplied', 'gp-industry' ),
	);

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

	if ( is_page_template( array( 'page-templates/full-width.php', 'page-templates/services.php', 'page-templates/about.php', 'page-templates/contact.php', 'page-templates/service-single.php', 'page-templates/products.php', 'page-templates/product-single.php', 'page-templates/auto-design.php' ) ) ) {
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
